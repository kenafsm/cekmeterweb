<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Wilayah;
use App\Models\StafLapangan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggan = Pelanggan::all();
        $staflapangan = StafLapangan::all();
        $wilayah = Wilayah::all();
        return view('data.pelanggan.pelanggan', compact('pelanggan', 'wilayah', 'staflapangan'));
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
        $staflapangan = StafLapangan::all();
        return view('data.pelanggan.tambah-pelanggan', compact('wilayah', 'staflapangan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        // Validasi input
        $request->validate([
            'kode_wilayah' => 'required|string|size:2',  // Harus 2 karakter
            'no_sp_lain' => 'required|string|max:255',
            'nama_pelanggan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'alamat' => 'required|string',
            'staf_nip' => 'required|exists:staflapangan,nip',
            'tahun_instalasi' => 'required|string|size:4',
            'tahun_kadaluarsa' => 'required|string|size:4'
        ]);

        // Gabungkan kode wilayah dan nomor SP lain
        $no_sp = $request->kode_wilayah . $request->no_sp_lain;

        // Cari wilayah berdasarkan kode_wilayah
        $wilayah = Wilayah::where('kode_wilayah', $request->kode_wilayah)->first();

        // Data staf lapangan berisi nip
        $pelanggan['staf_nip'] = $request->input('staf_nip');

        if ($wilayah) {
            // Simpan data pelanggan
            Pelanggan::create([
                'no_sp' => $no_sp,
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat' => $request->alamat,
                'staf_nip' => $request->staf_nip,
                'status' => $request->status,
                'kode_wilayah' => $wilayah->kode_wilayah,  // Simpan wilayah berdasarkan kode_wilayah yang ditemukan
                'tahun_instalasi' => $request->tahun_instalasi,
                'tahun_kadaluarsa' => $request->tahun_kadaluarsa
            ]);

            // Menampilkan SweetAlert
            Alert::success('Berhasil!', 'Data Pelanggan Berhasil Ditambahkan!');
            // Redirect ke halaman index dengan pesan sukses
            return redirect()->route('pelanggan.index');
        }

        // Menampilkan SweetAlert
        Alert::info('Maaf!', 'Wilayah Tidak Ditemukan');
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pelanggan.create');
    }


    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        // return view('pelanggan.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($no_sp)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $pelanggan = Pelanggan::findOrFail($no_sp); // Cari berdasarkan no_sp
        $wilayah = Wilayah::all();
        $staflapangan = StafLapangan::all();

        // Ambil logdata terbaru untuk pelanggan ini
        $logdata = \App\Models\LogData::where('no_sp', $no_sp)->latest()->first();

        return view('data.pelanggan.edit-pelanggan', compact('pelanggan', 'wilayah', 'staflapangan', 'logdata')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $no_sp)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        // Validasi input
        $validatedData = $request->validate([
            'kode_wilayah' => 'required|string|size:2', // Kode wilayah harus 2 karakter
            'no_sp_lain' => 'required|string|max:255', // Bagian nomor SP lainnya
            'nama_pelanggan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'staf_nip' => 'required|exists:staflapangan,nip',
            'alamat' => 'required|string',
            'tahun_instalasi' => 'required|string|size:4',
            'tahun_kadaluarsa' => 'required|string|size:4'
        ]);

        // Gabungkan kode wilayah dan nomor SP lainnya
        $new_no_sp = $request->kode_wilayah . $request->no_sp_lain;

        // Data staf_nip berisi nip
        $pelanggan['staf_nip'] = $request->input('staf_nip');

        // Cari wilayah berdasarkan kode_wilayah
        $wilayah = Wilayah::where('kode_wilayah', $request->kode_wilayah)->first();

        if ($wilayah) {
            // Temukan data pelanggan yang akan diupdate
            $pelanggan = Pelanggan::findOrFail($no_sp);

            // Update data pelanggan
            $pelanggan->update([
                'no_sp' => $new_no_sp,
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat' => $request->alamat,
                'staf_nip' => $request->staf_nip,
                'status' => $request->status,
                'kode_wilayah' => $wilayah->kode_wilayah, // Update wilayah berdasarkan kode_wilayah yang ditemukan
                'tahun_instalasi' => $request->tahun_instalasi,
                'tahun_kadaluarsa' => $request->tahun_kadaluarsa
            ]);

            // Menampilkan SweetAlert
            Alert::success('Berhasil!', 'Data Pelanggan Berhasil Diperbarui!');
            return redirect()->route('pelanggan.index');
        }

        // Menampilkan SweetAlert jika wilayah tidak ditemukan
        Alert::info('Maaf!', 'Wilayah Tidak Ditemukan');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($no_sp)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $pelanggan = Pelanggan::findOrFail($no_sp); // Cari berdasarkan no_sp
        $pelanggan->delete();

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Pelanggan Berhasil Dihapus!');
        return redirect()->route('pelanggan.index');
    }

    // Search
    public function search(Request $request)
    {
        $no_sp = $request->input('no_sp');
        $pelanggan = Pelanggan::with('wilayah') // Mengambil data relasi wilayah
        ->where('no_sp', $no_sp)
        ->first();

        if ($pelanggan) {
            return response()->json([
                'nama_pelanggan' => $pelanggan->nama_pelanggan,
                'alamat' => $pelanggan->alamat,
                'staf_nip' => $request->staf_nip,
                'wilayah' => $pelanggan->wilayah->nama_wilayah ?? 'Tidak Diketahui',
                'no_sp' => $pelanggan->no_sp,
                'status' => $pelanggan->status
            ]);
        } else {
            return response()->json(null, 404); // Jika pelanggan tidak ditemukan
        }
    }
}
