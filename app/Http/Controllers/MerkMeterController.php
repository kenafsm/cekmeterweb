<?php

namespace App\Http\Controllers;

use App\Models\MerkMeter;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MerkMeterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $merks = MerkMeter::all();
        return view('data.merkmeter.merkmeter', compact('merks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data.merkmeter.tambahmerkmeter');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_merk' => 'required|min:3',
            'deskripsi' => 'nullable'
        ]);

        MerkMeter::create($validatedData);

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Merk Meter Berhasil Ditambahkan!');

        return redirect(route('merkmeter.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(MerkMeter $merk)
    {
        // return view('data.merkmeter.merkmeter', [
        //     'nama_merk' => $merk
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $merks = MerkMeter::findorfail($id);
        return view('data.merkmeter.editmerkmeter', compact('merks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $merks = MerkMeter::findOrFail($id);
        $validatedData = $request->validate([
            'nama_merk' => 'required|string|max:255',
            'deskripsi' => 'nullable'
        ]);
        $merks->update($validatedData);

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Merk Meter Berhasil Diubah!');

        return redirect(route('merkmeter.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $merk = MerkMeter::findOrFail($id);
        $merk->delete();
        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Merk Meter Berhasil Dihapus!');
        return redirect(route('merkmeter.index'));
    }
}
