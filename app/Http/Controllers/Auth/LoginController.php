<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Session as FacadesSession;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    function index()
    {
        return view('Auth.login');
    }

    function validate_login(Request $request)
    {
        $request->validate([
            'email'       =>  'required',
            'password'  =>  'required'
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            if ($user->role === 'staf_lapangan') {
                Auth::logout();
                Alert::error('Maaf!', 'Role Staf Lapangan tidak dapat login ke website.');
                return redirect('/');
            }
            return redirect('dashboard');
        }

        // Menampilkan SweetAlert
        Alert::info('Maaf!', 'Email atau Password Salah!');

        return redirect('/');
    }

    function dashboard()
    {
        if(Auth::check())
        {
            return view('dashboard');
        }

        // Menampilkan SweetAlert
        Alert::error('Maaf!', 'Login Gagal!, Silahkan Coba Lagi Beberapa Saat Lagi!');

        return redirect('/');
    }

    function logout()
    {
        FacadesSession::flush();
        Auth::logout();
        return Redirect('/');
    }
}
