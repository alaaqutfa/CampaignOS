<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('dark_mode', false) ? 'dark' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CampaignOS - @yield('title')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    <!-- Vite (Tailwind + JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-light dark:bg-dark font-sans antialiased">

    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <!-- Sidebar (Dynamic based on role) -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="sm:ml-64 mt-16 p-4 transition-all duration-300">
        <div class="container mx-auto">
            <!-- Flash Messages -->
            @if(session('success'))
                <div
                    class="mb-4 p-4 rounded-base bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div
                    class="mb-4 p-4 rounded-base bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
        <!-- Footer -->
        @include('layouts.footer')
    </main>

    <button id="scrollToTopBtn"
        class="fixed bottom-5 right-5 p-3 rounded-full bg-primary-600 text-white shadow-lg hover:bg-primary-700 transition-all duration-300 opacity-0 invisible z-50"
        style="transition: opacity 0.3s, visibility 0.3s;">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <!-- CampaignOS JS (loaded via Vite or CDN) -->
    @vite('resources/js/app.js')
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2/dist/flowbite.min.js"></script>
    @stack('scripts')
</body>

</html>
