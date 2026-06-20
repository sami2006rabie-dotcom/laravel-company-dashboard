<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Welcome</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; }
            .hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        </style>
    </head>
    <body>
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
                <a href="/" class="text-2xl font-bold text-blue-600">Company Dashboard</a>
                <div class="flex gap-4">
                    <a href="/blog" class="text-gray-600 hover:text-blue-600">Blog</a>
                    @auth
                        <a href="/dashboard" class="text-gray-600 hover:text-blue-600">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-blue-600">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Register</a>
                    @endauth
                </div>
            </div>
        </nav>

        <div class="hero text-white py-24 text-center">
            <h1 class="text-5xl font-bold mb-4">Welcome to Company Dashboard</h1>
            <p class="text-xl mb-8 opacity-90">Manage your company, departments, and share thoughts on our blog</p>
            <div class="flex gap-4 justify-center">
                @auth
                    <a href="/dashboard" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">Login</a>
                    <a href="{{ route('register') }}" class="border-2 border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600">Register</a>
                @endauth
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-4xl mb-4">👥</div>
                    <h3 class="text-xl font-bold mb-2">Manage Employees</h3>
                    <p class="text-gray-600">Organize and manage your team members efficiently</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl mb-4">🏢</div>
                    <h3 class="text-xl font-bold mb-2">Department Management</h3>
                    <p class="text-gray-600">Create and organize departments within your company</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl mb-4">📝</div>
                    <h3 class="text-xl font-bold mb-2">Blog System</h3>
                    <p class="text-gray-600">Share ideas and thoughts with your team</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 py-12">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-4">Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h4 class="font-bold mb-2">🔐 Secure Authentication</h4>
                        <p class="text-gray-600">Google OAuth 2.0 & Email/WhatsApp OTP verification</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h4 class="font-bold mb-2">📊 Admin Dashboard</h4>
                        <p class="text-gray-600">Complete control over users and departments</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h4 class="font-bold mb-2">💬 Interactive Blog</h4>
                        <p class="text-gray-600">Post, comment, and engage with your team</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h4 class="font-bold mb-2">📱 Responsive Design</h4>
                        <p class="text-gray-600">Works perfectly on desktop and mobile devices</p>
                    </div>
                </div>
            </div>
        </div>

        <footer class="bg-gray-800 text-white text-center py-8">
            <p>&copy; {{ date('Y') }} Company Dashboard. All rights reserved.</p>
        </footer>
    </body>
</html>