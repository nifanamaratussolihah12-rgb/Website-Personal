<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // Tampilkan form forgot password
    public function showForm()
    {
        return view('backend.auth.forgot-password');
    }

    // Kirim token reset password
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        $token = Str::random(40);

        // simpan token terenkripsi di DB
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Crypt::encryptString($token),
                'created_at' => now(),
            ]
        );

        // kirim email (log driver di .env)
        Mail::raw("Token reset password kamu: $token. Berlaku 2 menit.", function($message) use ($user) {
            $message->to($user->email)
                    ->subject('Reset Password');
        });

        return back()->with('status', 'Token reset password berhasil dikirim. Silakan cek email (log jika testing lokal).');
    }

    // Tampilkan form reset password
    public function showResetForm($token)
    {
        return view('backend.auth.reset-password', ['token' => $token]);
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $record = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Email tidak ditemukan atau token sudah kadaluarsa.']);
        }

        // cek token
        try {
            $dbToken = Crypt::decryptString($record->token);
        } catch (\Exception $e) {
            return back()->withErrors(['token' => 'Token tidak valid.']);
        }

        if ($dbToken !== $request->token) {
            return back()->withErrors(['token' => 'Token salah.']);
        }

        // cek expired 2 menit
        if (Carbon::parse($record->created_at)->addMinutes(2)->isPast()) {
            return back()->withErrors(['token' => 'Token sudah kadaluarsa.']);
        }

        // update password
        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        // hapus token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('backend.login')->with('status', 'Password berhasil direset, silakan login.');
    }
}
