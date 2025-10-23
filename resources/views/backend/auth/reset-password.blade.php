<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - Asset Management System</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo_AKM.png') }}">
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #b3aebbff, #d0cacdff, #9e97a8ff);
            background-attachment: fixed;
            color: #333;
            font-family: 'Segoe UI', sans-serif;
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
                    <h4 class="mt-3">Reset Password</h4>
                    <p class="text-muted small">Masukkan token dan password baru Anda</p>
                </div>

                {{-- pesan sukses --}}
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- pesan error --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('backend.password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token ?? old('token') }}">

                    <div class="form-group mb-3">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Masukkan Email"
                                value="{{ old('email') }}"
                                required>
                        </div>
                        @error('email')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-key"></i>
                                </span>
                            </div>
                            <input type="text" name="token"
                                class="form-control @error('token') is-invalid @enderror"
                                placeholder="Masukkan Token"
                                value="{{ old('token') }}"
                                required>
                        </div>
                        @error('token')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Password Baru"
                                required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword" title="Tampilkan / Sembunyikan">
                                👁
                            </button>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Konfirmasi Password Baru"
                                required>
                        </div>
                        @error('password_confirmation')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('backend.login') }}" class="btn btn-custom-back">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-custom-login">
                            <i class="fa fa-paper-plane"></i> Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                this.textContent = '👁';
            }
        });
    </script>
</body>
</html>
