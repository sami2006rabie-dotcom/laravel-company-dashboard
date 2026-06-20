@php
$login_url = NULL;
$register_url = NULL;
$forgot_password_url = NULL;

if (Route::has('login')) {
    $login_url = route('login');
}

if (Route::has('register')) {
    $register_url = route('register');
}

if (Route::has('password.request')) {
    $forgot_password_url = route('password.request');
}
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-blue-600">Company Dashboard</h1>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>