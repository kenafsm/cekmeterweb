<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Hash;
use RealRashid\SweetAlert\Facades\Alert;


class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $staffs = Staff::all();
        return view('data.staff.staff', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data.staff.tambahstaff');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'nama_staff' => 'required',
            'no_telepon' => 'required',
            'wilayah' => 'required',
            'password' => 'required',
        ]);

        Staff::create([
            'nip' => $request->nip,
            'nama_staff' => $request->nama_staff,
            'no_telepon' => $request->no_telepon,
            'wilayah' => $request->wilayah,
            'password' => $request->password,
        ]);

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Staff Berhasil Ditambahkan!');

        return redirect()->route('staff.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        return view('data.staff.editstaff', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required',
            'nama_staff' => 'required',
            'no_telepon' => 'required',
            'wilayah' => 'required',
            'password' => 'required',
        ]);

        $staffs = Staff::findOrFail($id);
        $staffs->update([
            'nip' => $request->nip,
            'nama_staff' => $request->nama_staff,
            'no_telepon' => $request->no_telepon,
            'wilayah' => $request->wilayah,
            'password' => $request->password ? ($request->password) : $staffs->password,
        ]);

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Staff berhasil diperbarui!');

        return redirect()->route('staff.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Staff::findOrFail($id)->delete();
        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Staff berhasil dihapus!');
        return redirect()->route('staff.index');
    }
}
