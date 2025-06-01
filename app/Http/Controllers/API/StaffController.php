<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaffResource;
use App\Models\Staff;
use Illuminate\Http\Request;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $staff = Staff::latest()->paginate(5);

        //return collection of posts as a resource
        return new StaffResource(true, 'List Data Staff', $staff);
    }

    /**
     * Store a newly created Staff in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nip' => 'required',
            'nama_staff' => 'required',
            'no_telepon' => 'required',
            'wilayah' => 'required',
            'password' => 'required',
        ]);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Membuat Staff baru dengan data yang valid
        $staff = Staff::create([
            'nip' => $request->nip,
            'nama_staff' => $request->nama_staff,
            'no_telepon' => $request->no_telepon,
            'wilayah' => $request->wilayah,
            'password' => $request->password,
        ]);

        // Mengembalikan respon
        return new StaffResource(true, 'Data Staff Berhasil Ditambahkan!', $staff);
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
        $staff = Staff::find($id);

        //return single staff as a resource
        return new StaffResource(true, 'Detail Data Staff!', $staff);
    }

    /**
     * Update the specified Staff in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nip' => 'required',
            'nama_staff' => 'required',
            'no_telepon' => 'required',
            'wilayah' => 'required',
            'password' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find Staff by ID
        $staff = Staff::findOrFail($id);

        // Update Staff with new data
        $staff->update([
            'nip' => $request->nip,
            'nama_staff' => $request->nama_staff,
            'no_telepon' => $request->no_telepon,
            'wilayah' => $request->wilayah,
            'password' => $request->password,
        ]);

        // Return response
        return new StaffResource(true, 'Data Staff Berhasil Diubah!', $staff);
    }

    /**
     * Remove the specified Staff from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Find Staff by ID
        $staff = Staff::findOrFail($id);

        // Delete Staff
        $staff->delete();

        // Return response
        return new StaffResource(true, 'Data Staff Berhasil Dihapus!', null);
    }
}
