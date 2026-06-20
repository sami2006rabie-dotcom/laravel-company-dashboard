<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; }
        </style>
    </head>
    <body class="bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 py-3">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-8">
                        <a href="/" class="text-2xl font-bold text-blue-600">Dashboard</a>
                        @auth
                            @if(Auth::user()->isAdmin())
                                <a href="/dashboard" class="text-gray-600 hover:text-blue-600">Admin Dashboard</a>
                                <a href="/admin/departments" class="text-gray-600 hover:text-blue-600">Departments</a>
                            @else
                                <a href="/dashboard" class="text-gray-600 hover:text-blue-600">My Dashboard</a>
                            @endif
                            <a href="/blog" class="text-gray-600 hover:text-blue-600">Blog</a>
                        @else
                            <a href="/blog" class="text-gray-600 hover:text-blue-600">Blog</a>
                        @endauth
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <div class="relative group">
                                <button class="text-gray-600 hover:text-blue-600 flex items-center gap-2">
                                    {{ Auth::user()->name }}
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                                <div class="hidden group-hover:block absolute right-0 bg-white rounded-lg shadow-lg py-2 w-48 z-10">
                                    <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600">Login</a>
                            <a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white mt-12 py-8">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p>&copy; {{ date('Y') }} Company Dashboard. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>