<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('dark_mode', false) ? 'dark' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampaignOS - @yield('title')</title>
    <meta name="title" content="@yield('meta_title', 'CampaignOS - The Operating System for Advertising Campaigns')">
    <meta name="description"
        content="@yield('meta_description', 'Manage your advertising campaigns end-to-end: from measurement to installation, track progress and share results with clients.')">
    <meta name="keywords" content="campaign management, advertising, OOH, measurements, installation, CampaignOS">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description"
        content="@yield('og_description', 'Manage advertising campaigns from measurement to installation.')">
    <meta property="og:image" content="{{ asset('assets/img/logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('twitter_title', config('app.name'))">
    <meta property="twitter:description"
        content="@yield('twitter_description', 'Manage advertising campaigns from measurement to installation.')">
    <meta property="twitter:image" content="{{ asset('assets/img/logo.png') }}">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/flowbite.css') }}">
    <style>
        * {
            font-family: 'Plus Jakarta Sans'
        }

        .bg-gradient {
            background: linear-gradient(135deg, #5B3DF5, #3B82F6, #4DC0DE);
        }

        .gradient-text {
            background: linear-gradient(135deg, #5B3DF5, #3B82F6, #4DC0DE);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #5B3DF5, #3B82F6, #4DC0DE);
        }
    </style>
    @stack('styles')
</head>

<body class="bg-white dark:bg-gray-800">

    @include('landing.navigation')

    @yield('content')

    @include('landing.footer')

    <button id="scrollToTopBtn"
        class="fixed bottom-5 right-5 p-3 rounded-full bg-primary-600 text-white shadow-lg hover:bg-primary-700 transition-all duration-300 opacity-0 invisible z-50"
        style="transition: opacity 0.3s, visibility 0.3s;">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script src="{{ asset('assets/js/flowbite.js') }}"></script>
    @stack('scripts')
</body>

</html>
