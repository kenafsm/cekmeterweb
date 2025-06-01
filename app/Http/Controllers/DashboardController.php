<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MerkMeter;
use App\Models\Staff;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    // Untuk input count data ke dashboard
    public function index() {
        $merkmeter = MerkMeter::count();
        $staff = Staff::count();
        $pelanggan = Pelanggan::count();
        return view('dashboard', compact('pelanggan', 'merkmeter', 'staff'));
    }

    public function profile() {
        return view('profile.profile');
    }

    public function ubahpassword(Request $request) {
        return view('profile.ubahpassword');
    }

    public function changepassword(Request $request) {
        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|confirmed|min:8|string'
        ]);
        $auth = Auth::user();

        // The passwords matches
        if (!Hash::check($request->get('current_password'), $auth->password))
        {
            return back()->with('error', "Current Password is Invalid");
        }

        // Current password and new password same
        if (strcmp($request->get('current_password'), $request->new_password) == 0)
        {
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
