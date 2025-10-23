<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-light">
    <div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
        @yield('content')
    </div>
</body>
</html>
