<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password - Asset Management System</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/icon_AKM.png') }}">
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">

    <style>
        body {
            background: linear-gradient(135deg, #b3aebbff, #d0cacdff, #8231f4ff);
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
    </style>
</head>

<body>
    <div class="main-wrapper">
        <div class="auth-wrapper d-flex justify-content-center align-items-center">
            <div class="auth-box">
                <div class="logo">
                    <img src="{{ asset('image/logo_AKM.png') }}" alt="Logo AKM">
                    <h4 class="mt-3">Reset Password</h4>
                    <p class="text-muted small">Masukkan email akun Anda untuk permintaan reset</p>
                </div>

                {{-- pesan sukses/gagal --}}
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible">
                        {{ $message }}
                    </div>
                @endif

                @if ($message = Session::get('failed'))
                    <div class="alert alert-danger alert-dismissible">
                        {{ $message }}
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

                {{-- form lupa password --}}
                <form method="POST" action="{{ route('forgot-password-act') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                            <input type="email" name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                placeholder="Email"
                                autocomplete="new-email"
                                required>
                            </div>
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.login') }}" class="btn btn-custom-back">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-custom-login">
                            <i class="fa fa-paper-plane"></i> Kirim 
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
