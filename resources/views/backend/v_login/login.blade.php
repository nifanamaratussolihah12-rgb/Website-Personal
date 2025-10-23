<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asset Management System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/icon_AKM.png') }}">
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(90deg, 
                rgb(75, 65, 183)  0%,      /* warna awal */
                rgb(158, 206, 236) 50%,      /* warna tengah */
                rgb(151, 93, 222) 100%        /* warna akhir */
            ) !important;
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

        .btn-custom-forgot {
            background-color: #D32F2F;
            color: white;
            border-radius: 8px;
            padding: 10px 20px;
        }

        .btn-custom-forgot:hover {
            background-color: #a22222;
        }
        
    </style>
</head>

<body>
    <div class="main-wrapper">
        <div class="auth-wrapper d-flex justify-content-center align-items-center">
            <div class="auth-box">
                <div class="logo">
                    <img src="{{ asset('image/logo_AKM.png') }}" alt="Logo AKM">
                    <h4 class="mt-3">Asset Management System</h4>
                </div>

                <!-- Pesan sukses -->
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <strong>{{ session('success') }}</strong>
                    </div>
                @endif
                
                <!-- Pesan error -->
                @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <strong>{{ session('error') }}</strong>
                </div>
                @endif

                <form action="{{ route('backend.login.process') }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                            <input type="text" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Email">
                        </div>
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                {{ $message }}
                            </span>
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
                                placeholder="Password">

                            <div class="input-group-append">
                                <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('forgot-password') }}" class="btn btn-custom-forgot">
                            <i class="fa fa-lock"></i> Lupa Password
                        </a>
                        <button type="submit" class="btn btn-custom-login">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script>
