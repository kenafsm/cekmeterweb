<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AlatMeter;
use Illuminate\Http\Request;

class ApiAlatMeterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alatmeters = AlatMeter::all();

        return response()->json([
            'success' => true,
            'message' => 'Data Merk Meter berhasil diambil',
            'data' => $alatmeters
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_merk' => 'required|min:3',
            'no_seri' => 'nullable|string'
        ]);

        // Simpan data
        $alatmeter = AlatMeter::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Data Merk Meter berhasil ditambahkan',
            'data' => $alatmeter
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $alatmeter = AlatMeter::find($id);

        if (!$alatmeter) {
            return response()->json([
                'success' => false,
                'message' => 'Data Merk Meter tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Merk Meter berhasil diambil',
            'data' => $alatmeter
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $alatmeter = AlatMeter::find($id);

        if (!$alatmeter) {
            return response()->json([
                'success' => false,
                'message' => 'Data Merk Meter tidak ditemukan'
            ], 404);
        }

        // Validasi input
        $validatedData = $request->validate([
            'nama_merk' => 'required|string|max:255',
            'no_seri' => 'nullable|string'
        ]);

        // Update data
        $alatmeter->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Data Merk Meter berhasil diupdate',
            'data' => $alatmeter
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alatmeter = AlatMeter::find($id);

        if (!$alatmeter) {
            return response()->json([
                'success' => false,
                'message' => 'Data Merk Meter tidak ditemukan'
            ], 404);
        }

        $alatmeter->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Merk Meter berhasil dihapus'
        ], 200);
    }
}
