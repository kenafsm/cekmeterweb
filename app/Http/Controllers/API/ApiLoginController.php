<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        // Revoke current user token
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil.',
        ], 200);
    }

    public function userProfile(Request $request)
    {
        return response()->json([
            'status' => true,
            'data' => $request->user(),
        ], 200);
    }
}
