<div style="font-family: Consolas, monospace; color: #333; line-height: 1.6;">
    <h3 style="font-weight: 600; margin-bottom: 16px;">Halo,</h3>
    <p style="margin: 0 0 12px 0;">
        Kami menerima permintaan untuk melakukan <strong>reset password</strong> pada akun Anda.
        Jika benar, silakan klik tautan di bawah ini untuk mengatur ulang password:
    </p>
    <p style="margin: 20px 0;">
        <a href="{{ route('validasi-forgot-password', ['token' => $token]) }}" 
           style="background-color: #0056b3; color: #fff; padding: 12px 20px; text-decoration: none; border-radius: 6px; font-weight: bold; font-family: Consolas, monospace;">
           Reset Password
        </a>
    </p>
    <p style="margin: 20px 0 0 0; font-size: 14px; color: #555;">
        Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.
    </p>
    <br>
    <p style="margin: 0; font-size: 14px; color: #777;">
        Salam hormat,<br>
        <strong>Asset Management System</strong>
    </p>
</div>
