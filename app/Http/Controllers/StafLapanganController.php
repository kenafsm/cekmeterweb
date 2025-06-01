<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStafLapanganRequest;
use App\Http\Requests\UpdateStafLapanganRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\StafLapangan;
use App\Models\Wilayah;
use App\Models\LogData;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class StafLapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staflapangans = StafLapangan::all();
        $wilayah = Wilayah::all();
        return view('data.staflapangan.staflapangan', compact('staflapangans', 'wilayah'));
    }

    public function rekap()
    {
        $staflapangans = StafLapangan::all();
        $wilayah = Wilayah::all();
        return view('data.staflapangan.rekap', compact('staflapangans', 'wilayah'));
    }

    public function detailrekap($nip)
    {
        $staff = StafLapangan::where('nip', $nip)->firstOrFail();
        $logdata = LogData::with(['pelanggan', 'alatMeter'])
            ->where('staf_nip', $nip)
            ->orderBy('tanggal_cek', 'desc')
            ->get();
            
        return view('data.staflapangan.detailrekap', [
            'staff' => $staff,
            'logdata' => $logdata
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $wilayah = Wilayah::all();
        $staflapangans = StafLapangan::all();
        return view('data.staflapangan.tambahstaflapangan', compact('staflapangans', 'wilayah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'nip' => 'required|unique:users,email',
            'nama_staff' => 'required',
            'status' => 'required',
            'no_telepon' => 'required',
            'target_cek' => 'required',
            'kode_wilayah' => 'required',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->nama_staff,
            'email' => $request->nip, //menggunakan nip pada field email
            'password' => Hash::make($request->password),
            'role' => 'staf_lapangan',
        ]);

        StafLapangan::create([
            'nip' => $request->nip,
            'nama_staff' => $request->nama_staff,
            'status' => $request->status,
            'no_telepon' => $request->no_telepon,
            'jumlah_cek' => 0,
            'target_cek' => $request->target_cek,
            'kode_wilayah' => $request->kode_wilayah,
            'password' => $request->password,
        ]);

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Staff Berhasil Ditambahkan!');

        return redirect()->route('staflapangan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(StafLapangan $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($nip)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $staflapangans = StafLapangan::findOrFail($nip);
        $wilayah = Wilayah::all();
        return view('data.staflapangan.editstaflapangan', compact('staflapangans', 'wilayah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nip)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'nip' => 'required|unique:users,email,'.$nip.',email',
            'nama_staff' => 'required',
            'status' => 'required',
            'no_telepon' => 'required',
            'target_cek' => 'required',
            'kode_wilayah' => 'required',
            'password' => 'nullable',
        ]);

        $staffs = StafLapangan::findOrFail($nip);

        // Update user in users table
        $user = User::where('email', $nip)->first();
        if ($user) {
            $user->name = $request->nama_staff;
            $user->email = $request->nip;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        }

        // Update staf lapangan data
        $staffs->update([
            'nip' => $request->nip,
            'nama_staff' => $request->nama_staff,
            'status' => $request->status,
            'no_telepon' => $request->no_telepon,
            'target_cek' => $request->target_cek,
            'kode_wilayah' => $request->kode_wilayah,
            'password' => $request->password ? $request->password : $staffs->password,
        ]);

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Staff berhasil diperbarui!');

        return redirect()->route('staflapangan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($nip)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }

        // Delete user in users table
        $user = User::where('email', $nip)->first();
        if ($user) {
            $user->delete();
        }

        StafLapangan::findOrFail($nip)->delete();

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Staff berhasil dihapus!');
        return redirect()->route('staflapangan.index');
    }
}
