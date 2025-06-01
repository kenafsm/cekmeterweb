<?php

namespace App\Http\Controllers;

use App\Models\AlatMeter;
use App\Models\LogData;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\StafLapangan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $merkmeterCount = AlatMeter::count();
        $staffCount = StafLapangan::count();
        $pelangganCount = Pelanggan::count();
        $logdataCount = LogData::count();
        
        // Count meter conditions
        $baikCount = LogData::where('kondisi_meter', 'Baik')->count();
        $rusakCount = LogData::where('kondisi_meter', 'Rusak')->count();

        $merkmeter = AlatMeter::all();
        $staff = StafLapangan::all();
        $pelanggan = Pelanggan::all();

        // Ambil filter tanggal mulai dan tanggal akhir dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query untuk menampilkan 10 data terbaru dengan rentang tanggal
        $logdata = LogData::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('tanggal_cek', [$startDate, $endDate]);
            })
            ->orderBy('tanggal_cek', 'desc') // Urutkan berdasarkan tanggal cek terbaru
            ->take(10) // Batasi hanya 10 data
            ->get();

        return view('dashboard', compact(
            'pelanggan', 'merkmeter', 'staff', 'logdata',
            'pelangganCount', 'merkmeterCount', 'staffCount', 'logdataCount',
            'startDate', 'endDate', 'baikCount', 'rusakCount'
        ));
    }

    public function profile()
    {
        return view('profile.profile');
    }

    public function ubahpassword(Request $request)
    {
        return view('profile.ubahpassword');
    }

    public function changepassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|confirmed|min:8|string'
        ]);
        $auth = Auth::user();

        // Memeriksa apakah password lama valid
        if (!Hash::check($request->get('current_password'), $auth->password)) {
            return back()->with('error', "Current Password is Invalid");
        }

        // Memeriksa apakah password lama dan baru sama
        if (strcmp($request->get('current_password'), $request->new_password) == 0) {
            return redirect()->back()->with("error", "New Password cannot be same as your current password.");
        }

        $user =  User::find($auth->id);
        $user->password =  Hash::make($request->new_password);
        $user->save();
        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Password Berhasil Diubah!');
        return redirect(route('profile'));
    }
}
