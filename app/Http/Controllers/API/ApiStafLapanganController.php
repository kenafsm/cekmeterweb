<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StafLapangan;
use App\Models\LogData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Api Staf Lapangan Controller
 * 
 * Controller ini menangani semua operasi terkait staf lapangan melalui API,
 * termasuk autentikasi, manajemen data staf, dan pengiriman data log.
 * Digunakan untuk komunikasi antara aplikasi mobile dan backend.
 */
class ApiStafLapanganController extends Controller
{
    /**
     * Menangani proses login staf lapangan melalui NIP dan password.
     * 
     * @param Request $request Request berisi nip dan password staf
     * @return \Illuminate\Http\JsonResponse Respons JSON berisi token API dan data staf
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Attempt to find user with nip as email and role staf_lapangan
        $user = User::where('email', $request->nip)->where('role', 'staf_lapangan')->first();

        // Debug logging for troubleshooting login issues
        $logFile = storage_path('logs/custom_login_debug.log');
        file_put_contents($logFile, 'Login attempt for NIP: ' . $request->nip . PHP_EOL, FILE_APPEND);
        file_put_contents($logFile, 'User found: ' . ($user ? 'Yes' : 'No') . PHP_EOL, FILE_APPEND);
        if ($user) {
            file_put_contents($logFile, 'Password hash: ' . $user->password . PHP_EOL, FILE_APPEND);
            file_put_contents($logFile, 'Password check result: ' . (Hash::check($request->password, $user->password) ? 'true' : 'false') . PHP_EOL, FILE_APPEND);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid nip or password'], 401);
        }

        // Create token for API authentication
        $token = $user->createToken('staflapangan-token')->plainTextToken;

        // Ambil data staf lapangan
        $stafLapangan = StafLapangan::where('nip', $request->nip)->first();

        // Load related stafLapangan data
        $user->load('stafLapangan');

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
            'staff_data' => $stafLapangan
        ]);
    }

    /**
     * Menampilkan daftar semua staf lapangan.
     * 
     * @return \Illuminate\Http\JsonResponse Respons JSON berisi daftar semua staf lapangan beserta data wilayahnya
     */
    public function index()
    {
        $staffs = StafLapangan::with('wilayah')->get();
        return response()->json([
            'message' => 'Data staff retrieved successfully',
            'data' => $staffs
        ]);
    }

    /**
     * Membuat data staf lapangan baru.
     * 
     * @param Request $request Request berisi data staf lapangan baru
     * @return \Illuminate\Http\JsonResponse Respons JSON berisi data staf yang baru dibuat
     */
    public function store(Request $request)
    {
        // Validasi hanya admin yang bisa membuat staff baru
        $user = $request->user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized. Only admin can create new staff'], 403);
        }

        $validator = Validator::make($request->all(), [
            'nip' => 'required|unique:users,email',
            'nama_staff' => 'required',
            'status' => 'required',
            'no_telepon' => 'required',
            'target_cek' => 'required',
            'kode_wilayah' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Buat user di tabel users
        $user = User::create([
            'name' => $request->nama_staff,
            'email' => $request->nip, // using nip as email for login
            'password' => Hash::make($request->password),
            'role' => 'staf_lapangan',
        ]);

        // Buat data staf lapangan
        $staff = StafLapangan::create([
            'nip' => $request->nip,
            'nama_staff' => $request->nama_staff,
            'status' => $request->status,
            'no_telepon' => $request->no_telepon,
            'jumlah_cek' => 0,
            'target_cek' => $request->target_cek,
            'kode_wilayah' => $request->kode_wilayah,
            'password' => $request->password, // menyimpan password sebagai plaintext
        ]);

        return response()->json([
            'message' => 'Staff created successfully',
            'data' => $staff
        ], 201);
    }

    /**
     * Menampilkan data staf lapangan tertentu berdasarkan NIP.
     * 
     * @param string $id NIP staf lapangan yang ingin ditampilkan
     * @return \Illuminate\Http\JsonResponse Respons JSON berisi data staf lapangan beserta wilayahnya
     */
    public function show($id)
    {
        $staff = StafLapangan::with('wilayah')->findOrFail($id);
        return response()->json([
            'message' => 'Staff data retrieved successfully',
            'data' => $staff
        ]);
    }

    /**
     * Memperbarui data staf lapangan yang sudah ada.
     * 
     * @param Request $request Request berisi data staf lapangan yang diperbarui
     * @param string $id NIP staf lapangan yang ingin diperbarui
     * @return \Illuminate\Http\JsonResponse Respons JSON berisi data staf yang telah diperbarui
     */
    public function update(Request $request, $id)
    {
        // Validasi hanya admin atau staf lapangan bersangkutan yang bisa mengupdate data
        $user = $request->user();
        $staff = StafLapangan::findOrFail($id);
        
        if (!$user || ($user->role !== 'admin' && $user->email !== $staff->nip)) {
            return response()->json(['error' => 'Unauthorized. Only admin or the staff itself can update data'], 403);
        }

        $validator = Validator::make($request->all(), [
            'nip' => 'required|unique:users,email,'.$staff->nip.',email',
            'nama_staff' => 'required',
            'status' => 'required',
            'no_telepon' => 'required',
            'target_cek' => 'required',
            'kode_wilayah' => 'required',
            'password' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Update user di tabel users
        $userRecord = User::where('email', $staff->nip)->first();
        if ($userRecord) {
            $userRecord->name = $request->nama_staff;
            $userRecord->email = $request->nip;
            
            if ($request->password) {
                $userRecord->password = Hash::make($request->password);
            }
            
            $userRecord->save();
        }

        // Update data staf lapangan
        $staff->update([
            'nip' => $request->nip,
            'nama_staff' => $request->nama_staff,
            'status' => $request->status,
            'no_telepon' => $request->no_telepon,
            'target_cek' => $request->target_cek,
            'kode_wilayah' => $request->kode_wilayah,
            'password' => $request->password ? $request->password : $staff->password,
        ]);

        return response()->json([
            'message' => 'Staff data updated successfully',
            'data' => $staff
        ]);
    }

    /**
     * Menghapus data staf lapangan beserta akun usernya.
     * 
     * @param string $id NIP staf lapangan yang ingin dihapus
     * @return \Illuminate\Http\JsonResponse Respons JSON berisi pesan keberhasilan
     */
    public function destroy($id)
    {
        // Validasi hanya admin yang bisa menghapus staff
        $user = request()->user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized. Only admin can delete staff'], 403);
        }

        $staff = StafLapangan::findOrFail($id);

        // Hapus user di tabel users
        $userRecord = User::where('email', $staff->nip)->first();
        if ($userRecord) {
            $userRecord->delete();
        }

        $staff->delete();

        return response()->json([
            'message' => 'Staff deleted successfully'
        ]);
    }

    /**
     * Menangani pengiriman data log baru dari staf lapangan.
     * 
     * @param Request $request Request berisi data log baru (no_sp, alat_meter_id, foto_meter, dll)
     * @return \Illuminate\Http\JsonResponse Respons JSON berisi data log yang berhasil disimpan dan pesan keberhasilan
     */
    public function submitData(Request $request)
    {
        $user = $request->user();

        if (!$user || $user->role !== 'staf_lapangan') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'no_sp' => 'required|string',
            'alat_meter_id' => 'required|integer',
            'foto_meter' => 'nullable|string',
            'kondisi_meter' => 'required|string',
            'tahun_instalasi' => 'nullable|string',
            'tahun_kadaluarsa' => 'nullable|string',

            'ket_kondisi' => 'nullable|string',
            'tanggal_cek' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $logData = LogData::create([
            'staf_nip' => $user->email,
            'no_sp' => $request->no_sp,
            'alat_meter_id' => $request->alat_meter_id,
            'foto_meter' => $request->foto_meter,
            'kondisi_meter' => $request->kondisi_meter,
            'tahun_instalasi' => $request->tahun_instalasi,
            'tahun_kadaluarsa' => $request->tahun_kadaluarsa,
            'ket_kondisi' => $request->ket_kondisi,
            'tanggal_cek' => $request->tanggal_cek,
        ]);

        // Update juga jumlah_cek pada staff
        $staff = StafLapangan::where('nip', $user->email)->first();
        if ($staff) {
            $staff->jumlah_cek = $staff->jumlah_cek + 1;
            $staff->save();
        }

        return response()->json([
            'message' => 'Data submitted successfully', 
            'log_data' => $logData
        ]);
    }

    /**
     * Update password for logged-in staf lapangan.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6',
        ]);

        if (!$user || $user->role !== 'staf_lapangan') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Old password is incorrect'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        // Update password in StafLapangan model as well
        $staff = StafLapangan::where('nip', $user->email)->first();
        if ($staff) {
            $staff->password = $request->new_password; // plaintext as per existing code
            $staff->save();
        }

        return response()->json(['success' => true, 'message' => 'Password berhasil diubah']);
    }
}
