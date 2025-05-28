<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

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
        ], [
            'username.required' => 'Silakan isi username Anda.',
            'password.required' => 'Silakan isi kata sandi Anda.',
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
        return view('auth.forgot-password');
    }

    public function editPassword()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ], [
            'new_password.required' => 'Password baru harus diisi.',
            'new_password.min' => 'Password baru harus minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok dengan password baru.',
            'old_password.required' => 'Password lama harus diisi.',
        ]);

        $admin = Auth::user();

        if (!Hash::check($request->old_password, $admin->password)) {
            return back()->with('error', 'Old password is incorrect.');
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return back()->with('success', 'Password successfully updated.');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Debugging untuk melihat input yang diterima
        // Validasi input: email dan phone harus diisi
        $request->validate([
            'email' => ['required', 'email'], // Wajib email yang valid
        ]);

        // Cek apakah email sudah ada di database
        $admins = Admin::where('email', $request->email)->first(); // Cari pengguna berdasarkan email
        if (!$admins) {
            return redirect()->back()->withErrors(['email' => 'Pengguna dengan email tersebut tidak ditemukan.']);
        }

        $newPassword = Str::random(8);
        $admins->password = Hash::make($newPassword);  // Pastikan password di-hash
        $admins->save();
        $data = [
            'subject' => 'Pemulihan Kata Sandi Akun Anda',
            'title' => 'Password Baru Untuk Akun Anda',
            'body' => 'Anda baru saja melakukan permintaan untuk mereset kata sandi akun Anda. ' .  "\n" .
                'Berikut adalah kata sandi sementara yang telah kami buat untuk Anda: ' . "\n\n" .
                'Kata Sandi Baru: ' . $newPassword . "\n\n" .
                'Silakan gunakan kata sandi ini untuk login ke akun Anda. Demi keamanan, kami sangat menyarankan agar Anda segera mengganti kata sandi tersebut melalui menu Profil setelah berhasil masuk.' . "\n\n" .
                'Terima kasih' . "\n" .
                'Tracer Study'
        ];

        $adminsEmail = $admins->email;
        Mail::raw($data['body'], function ($message) use ($adminsEmail, $data) {
            $message->to($adminsEmail)
                ->subject($data['subject']);
        });


        return redirect()->route('login')->with('success', 'Password baru berhasil dikirim!');
    }
}
