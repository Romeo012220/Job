<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Job Portal')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts: Poppins & Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    @include('layouts.navigation')

    <div class="min-h-screen p-6">
        @yield('content')
    </div>

    @stack('scripts') <!-- ✅ FIXED: Now scripts will load and run correctly -->
</body>
</html>
