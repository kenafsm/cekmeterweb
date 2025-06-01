<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ApiPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get page from request or default to 1
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 15); // Default 15 items per page
        
        $pelanggan = Pelanggan::with('wilayah')->paginate($perPage);
        
        return response()->json([
            'data' => $pelanggan,
            'message' => 'Data pelanggan berhasil diambil'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_wilayah' => 'required|string|size:2',
            'no_sp_lain' => 'required|string|max:255',
            'nama_pelanggan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'tahun_instalasi' => 'required|string|size:4|digits:4',
            'tahun_kadaluarsa' => 'required|string|size:4|digits:4',
        ]);

        // Logging seluruh request data kecuali wilayah dan kode_wilayah
        $logRequestData = $request->except(['wilayah', 'kode_wilayah']);
        Log::info('Request data (filtered): ' . json_encode($logRequestData));

        $no_sp = $request->kode_wilayah . $request->no_sp_lain;

        // Set no_sp_lain sama dengan no_sp
        $request->merge(['no_sp_lain' => $no_sp]);

        if (empty($request->kode_wilayah)) {
            return response()->json(['message' => 'Kode Wilayah wajib diisi'], 400);
        }

        // Trim kode_wilayah dan log dengan delimiter
        $kodeWilayahTrimmed = trim($request->kode_wilayah);
        Log::info('Mencari Wilayah dengan kode_wilayah (trimmed): [' . $kodeWilayahTrimmed . ']');

        // Logging query SQL
        DB::enableQueryLog();

        // Cari wilayah menggunakan raw query untuk bypass model dengan case-insensitive match
        $wilayah = DB::table('wilayah')
            ->whereRaw('LOWER(TRIM(kode_wilayah)) = ?', [strtolower($kodeWilayahTrimmed)])
            ->first();

        // Logging query SQL yang dijalankan
        $queries = DB::getQueryLog();
        Log::info('Query yang dijalankan: ' . json_encode($queries));

        // Logging hasil pencarian wilayah
        Log::info('Hasil pencarian Wilayah: ' . json_encode($wilayah));

        if (!$wilayah) {
            return response()->json(['message' => 'Wilayah Tidak Ditemukan'], 404);
        }

        // Simpan data pelanggan
        $pelanggan = Pelanggan::create([
            'no_sp' => $no_sp,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'kode_wilayah' => $wilayah->kode_wilayah,
            'tahun_instalasi' => $request->tahun_instalasi,
            'tahun_kadaluarsa' => $request->tahun_kadaluarsa,
        ]);

        return response()->json(['message' => 'Data Pelanggan Berhasil Ditambahkan', 'data' => $pelanggan], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($no_sp)
    {
        $pelanggan = Pelanggan::with('wilayah')->where('no_sp', $no_sp)->first();

        if (!$pelanggan) {
            return response()->json(['message' => 'Pelanggan Tidak Ditemukan'], 404);
        }

        return response()->json($pelanggan, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $no_sp)
    {
        // Validasi input dasar
        $request->validate([
            'kode_wilayah' => 'nullable|string|size:2',
            'no_sp_lain' => 'nullable|string|max:255',
            'nama_pelanggan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'tahun_instalasi' => 'nullable|string|size:4|digits:4',
            'tahun_kadaluarsa' => 'nullable|string|size:4|digits:4',
            'alat_meter_id' => 'nullable|integer',
            'kondisi_meter' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_cek' => 'nullable|date',
            'foto_meter' => 'nullable|file|image|max:1024' // max 1MB
        ]);

        $pelanggan = Pelanggan::where('no_sp', $no_sp)->first();

        if (!$pelanggan) {
            return response()->json(['message' => 'Pelanggan Tidak Ditemukan'], 404);
        }

        $new_no_sp = $request->kode_wilayah . $request->no_sp_lain;

        // Set no_sp_lain sama dengan new_no_sp
        $request->merge(['no_sp_lain' => $new_no_sp]);

        $kodeWilayahTrimmed = trim($request->kode_wilayah);

        Log::info('Mencari Wilayah dengan kode_wilayah (trimmed): [' . $kodeWilayahTrimmed . ']');

        DB::enableQueryLog();

        $wilayah = Wilayah::whereRaw('LOWER(kode_wilayah) = ?', [strtolower($kodeWilayahTrimmed)])->first();

        $queries = DB::getQueryLog();
        Log::info('Query yang dijalankan: ' . json_encode($queries));
        Log::info('Hasil pencarian Wilayah: ' . json_encode($wilayah));

        if (!$wilayah) {
            return response()->json(['message' => 'Wilayah Tidak Ditemukan'], 404);
        }

        // Update data pelanggan dasar
        $pelanggan->update([
            'no_sp' => $new_no_sp,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'kode_wilayah' => $wilayah->kode_wilayah,
            'tahun_instalasi' => $request->tahun_instalasi ?? $pelanggan->tahun_instalasi,
            'tahun_kadaluarsa' => $request->tahun_kadaluarsa ?? $pelanggan->tahun_kadaluarsa,
        ]);

        // Tangani upload foto meter jika ada
        $fotoPath = null;
        if ($request->hasFile('foto_meter')) {
            $file = $request->file('foto_meter');
            $fotoPath = $file->store('foto_meter', 'public');
        }

        // Buat record LogData baru
        $logData = new \App\Models\LogData();
        $logData->no_sp = $pelanggan->no_sp;
        $logData->staf_nip = $request->user()->email; // Ambil staf_nip dari user yang login
        $logData->alat_meter_id = $request->merk_meter_id;
        $logData->kondisi_meter = $request->kondisi_meter;
        $logData->ket_kondisi = $request->keterangan;
        $logData->tahun_instalasi = $pelanggan->tahun_instalasi; // Ambil dari data pelanggan
        $logData->tahun_kadaluarsa = $pelanggan->tahun_kadaluarsa; // Ambil dari data pelanggan
        $logData->tanggal_cek = $request->tanggal_cek;
        if ($fotoPath) {
            $logData->foto_meter = $fotoPath;
        }
        $logData->save();

        return response()->json([
            'message' => 'Data Pelanggan dan Log Data Berhasil Diperbarui',
            'data' => $pelanggan,
            'log_data' => $logData
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($no_sp)
    {
        $pelanggan = Pelanggan::where('no_sp', $no_sp)->first();

        if (!$pelanggan) {
            return response()->json(['message' => 'Pelanggan Tidak Ditemukan'], 404);
        }

        $pelanggan->delete();
        return response()->json(['message' => 'Data Pelanggan Berhasil Dihapus'], 200);
    }

    /**
     * Search pelanggan by no_sp.
     */
    public function search(Request $request)
    {
        // Log Authorization header for debugging
        error_log("Authorization header: " . $request->header('Authorization'));

        // Ambil nilai dari request dan normalisasi 
        $no_sp_original = $request->input('no_sp');
        $no_sp = trim($no_sp_original); // Menghilangkan spasi di awal dan akhir
        
        $staff = $request->user();
        
        // Debug log tentang format user dari token
        error_log("User from token type: " . gettype($staff));
        error_log("User from token content: " . json_encode($staff));
        
        // Ambil NIP staf dari kolom email model User (struktur yang digunakan oleh sistem)
        if (!is_object($staff) || empty($staff->email)) {
            error_log("User object tidak memiliki properti email atau email kosong");
            error_log("User object dump: " . print_r($staff, true));
            return response()->json([
                'message' => 'Format data staf tidak valid. Silakan login ulang.',
                'debug_info' => json_encode($staff)
            ], 401);
        }

        // Logging tipe data dan isi properti email
        error_log("Tipe data email user: " . gettype($staff->email));
        error_log("Isi email user: " . $staff->email);
        
        // Di sistem ini, NIP staf disimpan di kolom email tabel users
        $staff_nip_original = $staff->email;
        $staff_nip = trim($staff_nip_original); // Menghilangkan spasi di awal dan akhir
        
        // Debug log yang lebih detail
        error_log("Search request - Original SP: '$no_sp_original', Normalized SP: '$no_sp'");
        error_log("Staff - Original NIP: '$staff_nip_original', Normalized NIP: '$staff_nip'");

        try {
            // Log query yang akan dijalankan untuk membantu debug
            error_log("Running query for: no_sp='$no_sp' AND staf_nip='$staff_nip'");
            
        // Query dengan filter ketat berdasarkan no_sp dan staf_nip
        $pelanggan = Pelanggan::with([
            'wilayah',
            'stafLapangan',
            'logData' => function($query) {
                $query->latest()->with('alatMeter');
            }
        ])
        ->where('no_sp', $no_sp)
        ->where('staf_nip', $staff_nip)
        ->first();

        // Pastikan stafLapangan adalah objek, bukan koleksi
        if ($pelanggan && is_iterable($pelanggan->stafLapangan)) {
            $pelanggan->stafLapangan = $pelanggan->stafLapangan->first();
        }
        
        // Jika ditemukan, log detail untuk debugging
        if ($pelanggan) {
            error_log("Pelanggan ditemukan dengan no_sp: '$no_sp', memiliki staf_nip: '{$pelanggan->staf_nip}'");
            error_log("User login memiliki nip (dari email): '$staff_nip'");
        } else {
            error_log("Pelanggan tidak ditemukan atau tidak sesuai dengan staf_nip");
            return response()->json([
                'message' => 'Data pelanggan tidak ditemukan atau Anda tidak memiliki akses',
                'debug' => [
                    'no_sp_sent' => $no_sp,
                    'staff_nip' => $staff_nip
                ]
            ], 404);
        }

                
        
            // Get the latest log data
            $latestLog = $pelanggan->logData->first();
            
            error_log("Latest log data: " . ($latestLog ? json_encode($latestLog->toArray()) : "No log data"));

            $response = [
                'data' => [
                    'nama_pelanggan' => $pelanggan->nama_pelanggan,
                    'alamat' => $pelanggan->alamat,
                    'wilayah' => $pelanggan->wilayah->nama_wilayah ?? 'Tidak Diketahui',
                    'no_sp' => $pelanggan->no_sp,
                    'status' => $pelanggan->status ?? 'Belum Dicek',
                    'kondisi_meter' => $latestLog ? $latestLog->kondisi_meter : 'Belum Ada Kondisi',
                    'tahun_instalasi' => $pelanggan->tahun_instalasi,
                    'tahun_kadaluarsa' => $pelanggan->tahun_kadaluarsa,
                    'nama_merk' => $latestLog && $latestLog->alatMeter ? $latestLog->alatMeter->nama_merk : null,
                    'keterangan' => $latestLog ? $latestLog->ket_kondisi : null,
                    'foto_meter' => $latestLog ? $latestLog->foto_meter : null,
                    'tanggal_cek' => $latestLog ? $latestLog->tanggal_cek : null
                ]
            ];

            error_log("Found customer data: " . json_encode($response));
            return response()->json($response, 200);

        } catch (\Exception $e) {
            error_log("Error searching customer: " . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat mencari data pelanggan'
            ], 500);
        }
    }
}
