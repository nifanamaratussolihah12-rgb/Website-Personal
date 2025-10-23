{{-- resources/views/backend/auth/reset-password.blade.php --}}
<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - Asset Management System</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo_AKM.png') }}">
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #b3aebbff, #d0cacdff, #8231f4ff);
            font-family: 'Segoe UI', sans-serif;
            color: #333;
        }

        .auth-wrapper {
            min-height: 100vh;
        }

        .auth-box {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            padding: 35px;
            width: 100%;
            max-width: 400px;
        }

        .auth-box .logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .auth-box .logo img {
            height: 85px;
        }

        .form-control-lg {
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 12px;
        }

        .btn-custom-login {
            background-color: #4B0082;
            color: white;
            border-radius: 8px;
            font-weight: bold;
            padding: 10px 20px;
        }

        .btn-custom-login:hover {
            background-color: #360061;
        }

        .btn-custom-back {
            background-color: #6c757d;
            color: white;
            border-radius: 8px;
            padding: 10px 20px;
        }

        .btn-custom-back:hover {
            background-color: #545b62;
        }

        .input-group-text {
            width: 45px;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <div class="auth-wrapper d-flex justify-content-center align-items-center">
            <div class="auth-box">
                <div class="logo">
                    <img src="{{ asset('image/logo_AKM.png') }}" alt="Logo AKM">
                    <h4 class="mt-3">Buat Password Baru</h4>
                    <p class="text-muted small">Masukkan password baru untuk akun Anda</p>
                </div>

                {{-- pesan sukses/gagal --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('failed'))
                    <div class="alert alert-danger alert-dismissible">
                        {{ session('failed') }}
                    </div>
                @endif

                {{-- pesan error validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- form reset password --}}
                <form action="{{ route('backend.password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email ?? '' }}">

                    {{-- Password --}}
                    <div class="form-group mb-3">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" name="password" id="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                placeholder="Masukkan Password Baru" required>
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" data-target="password">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="form-group mb-3">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control form-control-lg"
                                placeholder="Konfirmasi Password Baru" required>
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" data-target="password_confirmation">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.login') }}" class="btn btn-custom-back">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-custom-login">
                            <i class="fa fa-check-circle"></i> Simpan Password
                        </button>
                    </div>
                </form>

                {{-- Script toggle --}}
                <script>
                    document.querySelectorAll('.toggle-password').forEach(item => {
                        item.addEventListener('click', function() {
                            const targetId = this.getAttribute('data-target');
                            const input = document.getElementById(targetId);
                            const icon = this.querySelector('i');

                            if (input.type === "password") {
                                input.type = "text";
                                icon.classList.remove('fa-eye');
                                icon.classList.add('fa-eye-slash');
                            } else {
                                input.type = "password";
                                icon.classList.remove('fa-eye-slash');
                                icon.classList.add('fa-eye');
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</body>
</html>
