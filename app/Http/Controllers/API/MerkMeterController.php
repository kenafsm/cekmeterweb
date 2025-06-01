<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//import Resource "MerkMeter"
use App\Http\Resources\MerkMeterResource;
//import Model "Merk Meter"
use App\Models\MerkMeter;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

class MerkMeterController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $merkmeter = MerkMeter::latest()->paginate(5);

        //return collection of posts as a resource
        return new MerkMeterResource(true, 'List Data Merk Meter', $merkmeter);
    }

    /**
     * Store a newly created MerkMeter in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama_merk' => 'required|min:3'
        ]);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Membuat merk meter baru dengan data yang valid
        $merkmeter = MerkMeter::create([
            'nama_merk' => $request->nama_merk
        ]);

        // Mengembalikan respon
        return new MerkMeterResource(true, 'Data Merk Meter Berhasil Ditambahkan!', $merkmeter);
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
        $merkmeter = MerkMeter::find($id);

        //return single merkmeter as a resource
        return new MerkMeterResource(true, 'Detail Data Merk Meter!', $merkmeter);
    }

    /**
     * Update the specified Merk Meter in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nama_merk' => 'required|min:3'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find Merk Meter by ID
        $merkmeter = MerkMeter::findOrFail($id);

        // Update Merk Meter with new data
        $merkmeter->update([
            'nama_merk'     => $request->nama_merk,
        ]);

        // Return response
        return new MerkMeterResource(true, 'Data Merk Meter Berhasil Diubah!', $merkmeter);
    }

    /**
     * Remove the specified Merk Meter from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Find Merk Meter by ID
        $merkmeter = MerkMeter::findOrFail($id);

        // Delete Merk Meter
        $merkmeter->delete();

        // Return response
        return new MerkMeterResource(true, 'Data Merk Meter Berhasil Dihapus!', null);
    }
}
