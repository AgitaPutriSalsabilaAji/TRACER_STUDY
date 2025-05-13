<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan file ada di resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Cek apakah input adalah email atau username
        $loginField = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Lakukan autentikasi berdasarkan email atau username
        $credentials = [
            $loginField => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau email atau password salah.',
        ])->withInput($request->only('username', 'remember'));
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showForgotPassword()
{
    return view('auth.forgot-password'); // Pastikan view-nya ada
}

public function editPassword()
{
    return view('auth.change-password');
}

public function updatePassword(Request $request)
{
    $request->validate([
        'old_password' => ['required'],
        'new_password' => ['required', 'min:8'],
        'confirm_password' => ['same:new_password'],
    ]);

    if (!Hash::check($request->old_password, auth()->user()->password)) {
        return back()->with('error', 'Password lama salah.');
    }

    auth()->user()->update([
        'password' => Hash::make($request->new_password),
    ]);

    return back()->with('success', 'Password berhasil diperbarui.');
}

}
