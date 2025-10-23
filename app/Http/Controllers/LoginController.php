<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\AssetHistory;


class LoginController extends Controller
{
    public function loginBackend()
    {
        return view('backend.v_login.login', ['judul' => 'Login']);
    }

    public function authenticateBackend(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            // Super admin dan semua admin/staff bisa login
            if (in_array($role, [0, 1, 2, 3, 4])) {
                return redirect()->route('backend.beranda');
            }

            // Kalau role tidak dikenali
            Auth::logout();
            return redirect()->route('backend.login')->with('error', 'Role tidak dikenali.');
        }

        return back()->with('error', 'Login Gagal');
    }

    public function logoutBackend()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('backend.login');
    }

    public function forgot_password()
    {
        return view('backend.auth.forgot-password');
    }

    public function forgot_password_act(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user,email'
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.exists' => 'Email tidak terdaftar di database',
        ]);

        $token = \Str::random(60);

        // hapus token lama
        PasswordResetToken::where('email', $request->email)->delete();

        // simpan token baru
        $tokenRecord = PasswordResetToken::create([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // kirim email reset
        Mail::to($request->email)->send(new ResetPasswordMail($tokenRecord->token));

        return redirect()->route('forgot-password')->with('success', 'Kami telah mengirimkan link reset password ke email Anda.');
    }

    public function validasi_forgot_password(Request $request, $token)
    {
        $tokenRecord = PasswordResetToken::where('token', $token)->first();

        if (!$tokenRecord) {
            return back()->with('failed', 'Token tidak valid');
        }

        return view('backend.auth.validasi-token', [
            'token' => $tokenRecord->token,
            'email' => $tokenRecord->email
        ]);
    }

    public function validasi_forgot_password_act(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $tokenRecord = PasswordResetToken::where('token', $request->token)->first();

        if (!$tokenRecord) {
            return back()->with('failed', 'Token tidak valid');
        }

        $user = User::where('email', $tokenRecord->email)->first();

        if (!$user) {
            return back()->with('failed', 'Email tidak terdaftar di database');
        }

        // update password user
        $user->password = Hash::make($request->password);
        $user->save();

        // Catat ke history / log
        AssetHistory::log(
            null, // tidak terkait asset
            'updated', // status / aksi
            "Password user {$user->nama} ({$user->email}) berhasil direset",
            null, // tidak ada changes detail
            $user->id // user yang passwordnya direset
        );

        // hapus token menggunakan where (supaya nggak error primary key)
        PasswordResetToken::where('token', $request->token)->delete();

        // redirect langsung ke login dengan flash message
        return redirect()->route('backend.login')->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }
}
