<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//import Resource "PelangganResource"
use App\Http\Resources\PelangganResource;
//import Model "Pelanggan"
use App\Models\Pelanggan;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;
//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $pelanggan = Pelanggan::latest()->paginate(5);

        //return collection of posts as a resource
        return new PelangganResource(true, 'List Data Pelanggan', $pelanggan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'no_sp' => 'required',
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'wilayah' => 'required|not_in:Pilih Wilayah',
            'merk_meter_id' => 'nullable|exists:merk_meters,id',
            'kondisi_meter' => 'nullable',
            'tanggal_cek' => 'nullable|date',
            'foto_meter' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Mengambil semua data request kecuali 'foto_meter'
        $pelangganData = $request->except('foto_meter');

        // Jika ada file yang diunggah
        if ($request->hasFile('foto_meter')) {
            // Menyimpan file dan mendapatkan path-nya
            $filePath = $request->file('foto_meter')->store('pelanggan', 'public');
            $pelangganData['foto_meter'] = $filePath;
        }

        //create pelanggan
        $pelanggan = Pelanggan::create($pelangganData);

        //return response
        return new PelangganResource(true, 'Data Pelanggan Berhasil Ditambahkan!', $pelanggan);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $pelanggan = Pelanggan::find($id);

        //return single pelanggan as a resource
        return new PelangganResource(true, 'Detail Data Pelanggan!', $pelanggan);
    }

    /**
     * Update the specified Pelanggan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'no_sp' => 'required',
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'wilayah' => 'required',
            'merk_meter_id' => 'nullable|exists:merk_meters,id',
            'kondisi_meter' => 'nullable',
            'tanggal_cek' => 'nullable|date',
            'foto_meter' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find Pelanggan by ID
        $pelanggan = Pelanggan::findOrFail($id);
        $pelangganData = $request->except('foto_meter');

        if ($request->hasFile('foto_meter')) {
            // Delete old file if exists
            if ($pelanggan->foto_meter && Storage::disk('public')->exists($pelanggan->foto_meter)) {
                Storage::disk('public')->delete($pelanggan->foto_meter);
            }

            // Store new file and get its path
            $filePath = $request->file('foto_meter')->store('pelanggan', 'public');
            $pelangganData['foto_meter'] = $filePath;
        }

        // Update Pelanggan with new data
        $pelanggan->update($pelangganData);

        // Return response
        return new PelangganResource(true, 'Data Pelanggan Berhasil Diubah!', $pelanggan);
    }

    /**
     * Remove the specified Pelanggan from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Find Pelanggan by ID
        $pelanggan = Pelanggan::findOrFail($id);

        // If there is a file associated with this pelanggan, delete it
        if ($pelanggan->foto_meter && Storage::disk('public')->exists($pelanggan->foto_meter)) {
            Storage::disk('public')->delete($pelanggan->foto_meter);
        }

        // Delete Pelanggan
        $pelanggan->delete();

        // Return response
        return new PelangganResource(true, 'Data Pelanggan Berhasil Dihapus!', null);
    }
}
