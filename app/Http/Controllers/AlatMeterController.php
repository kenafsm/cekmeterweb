<?php

namespace App\Http\Controllers;

use App\Models\AlatMeter;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AlatMeterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alatmeters = AlatMeter::all();
        return view('data.alatmeter.alatmeter', compact('alatmeters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        return view('data.alatmeter.tambahalatmeter');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $validatedData = $request->validate([
            'nama_merk' => 'required|min:3',
            'no_seri' => 'nullable'
        ]);

        AlatMeter::create($validatedData);

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Merk Meter Berhasil Ditambahkan!');

        return redirect(route('alatmeter.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(AlatMeter $alatmeter)
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
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $alatmeters = AlatMeter::findorfail($id);
        return view('data.alatmeter.editalatmeter', compact('alatmeters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $alatmeters = AlatMeter::findOrFail($id);
        $validatedData = $request->validate([
            'nama_merk' => 'required|string|max:255',
            'no_seri' => 'nullable'
        ]);
        $alatmeters->update($validatedData);

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Merk Meter Berhasil Diubah!');

        return redirect(route('alatmeter.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $alatmeter = AlatMeter::findOrFail($id);
        $alatmeter->delete();
        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Merk Meter Berhasil Dihapus!');
        return redirect(route('alatmeter.index'));
    }
}
