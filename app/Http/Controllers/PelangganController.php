<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Wilayah;
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
        $wilayah = Wilayah::all();
        return view('data.pelanggan.pelanggan', compact('pelanggan', 'wilayah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data.pelanggan.tambah-pelanggan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_wilayah' => 'required|string|size:2',  // Harus 2 karakter
            'no_sp_lain' => 'required|string|max:255',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        // Gabungkan kode wilayah dan nomor SP lain
        $no_sp = $request->kode_wilayah . $request->no_sp_lain;

        // Cari wilayah berdasarkan kode_wilayah
        $wilayah = Wilayah::where('kode_wilayah', $request->kode_wilayah)->first();

        if ($wilayah) {
            // Simpan data pelanggan
            Pelanggan::create([
                'no_sp' => $no_sp,
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat' => $request->alamat,
                'wilayah_id' => $wilayah->id,  // Simpan wilayah_id berdasarkan kode_wilayah yang ditemukan
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
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('data.pelanggan.edit-pelanggan', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kode_wilayah' => 'required|string|size:2', // Kode wilayah harus 2 karakter
            'no_sp_lain' => 'required|string|max:255', // Bagian nomor SP lainnya
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        // Gabungkan kode wilayah dan nomor SP lainnya
        $no_sp = $request->kode_wilayah . $request->no_sp_lain;

        // Cari wilayah berdasarkan kode_wilayah
        $wilayah = Wilayah::where('kode_wilayah', $request->kode_wilayah)->first();

        if ($wilayah) {
            // Temukan data pelanggan yang akan diupdate
            $pelanggan = Pelanggan::findOrFail($id);

            // Update data pelanggan
            $pelanggan->update([
                'no_sp' => $no_sp,
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat' => $request->alamat,
                'wilayah_id' => $wilayah->id, // Update wilayah_id berdasarkan kode_wilayah yang ditemukan
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
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Pelanggan Berhasil Dihapus!');

        return redirect()->route('pelanggan.index');
    }
}
