@extends('landing.app')

@section('title', 'The Operating System for Advertising Campaigns')

@section('content')
    {{-- Hero Section --}}
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h1
                    class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">
                    The Operating System for <span class="gradient-text">Advertising Campaigns</span></h1>
                <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">From
                    Excel to Execution – Automate your entire campaign workflow, track every step, and deliver perfect
                    results every time.</p>
                <div class="space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center w-full px-5 py-3 text-sm font-medium text-center text-white bg-gradient rounded-lg sm:w-auto hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 dark:focus:ring-purple-800">
                        Get Started Free
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="{{ route('login', ['demo' => true]) }}"
                        class="inline-flex items-center justify-center w-full px-5 py-3 text-sm font-medium text-gray-900 border border-gray-200 rounded-lg sm:w-auto hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        Watch Demo
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-4 shadow-2xl">
                    <img src="{{ asset('assets/img/demo-light.png') }}" class="w-full rounded-lg dark:hidden"
                        alt="Dashboard Preview">
                    <img src="{{ asset('assets/img/demo-dark.png') }}" class="w-full rounded-lg hidden dark:block"
                        alt="Dashboard Preview">
                </div>
            </div>
        </div>
    </section>

    {{-- Problem Section --}}
    <section class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl dark:text-white">
                The Chaos of Manual Campaigns
            </h2>
            <p class="mt-4 text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                Advertising production is stuck in the past. Here's what's holding you back.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-12">
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl dark:text-white font-bold">Excel Chaos</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Endless spreadsheets, lost data, version control
                        nightmares.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl dark:text-white font-bold">Disconnected Teams</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Designers, printers, installers working in silos.
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl dark:text-white font-bold">No Visibility</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Where is the campaign? What's the status? No one
                        knows.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl  dark:text-white font-bold">Delayed Execution</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Missed deadlines, frustrated clients, lost revenue.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Solution Section --}}
    <section class="bg-white dark:bg-gray-900 py-16">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl dark:text-white">CampaignOS: The
                Complete Operating System</h2>
            <p class="mt-4 text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">One platform to manage the entire
                campaign lifecycle – from initial data to final installation.</p>
            <div class="flex flex-wrap justify-center gap-8 mt-12">
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 bg-gradient rounded-full flex items-center justify-center text-white font-bold text-xl">
                        1</div>
                    <p class="mt-2 font-medium dark:text-white">Excel Input</p>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 bg-gradient rounded-full flex items-center justify-center text-white font-bold text-xl">
                        2</div>
                    <p class="mt-2 font-medium  dark:text-white">Automated Design</p>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 bg-gradient rounded-full flex items-center justify-center text-white font-bold text-xl">
                        3</div>
                    <p class="mt-2 font-medium  dark:text-white">Print Management</p>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 bg-gradient rounded-full flex items-center justify-center text-white font-bold text-xl">
                        4</div>
                    <p class="mt-2 font-medium  dark:text-white">Installation Tracking</p>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 bg-gradient rounded-full flex items-center justify-center text-white font-bold text-xl">
                        5</div>
                    <p class="mt-2 font-medium dark:text-white">Before/After Proof</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl dark:text-white">Powerful
                    Features for Modern Campaigns</h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Everything you need to run campaigns with
                    confidence.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl dark:text-white font-bold">Excel to Workflow</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Import your data and instantly create structured
                        campaigns.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl dark:text-white font-bold">Auto-Generate Designs</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Python-powered design generation from templates and
                        data.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl dark:text-white font-bold">Field Execution Tracking</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Contractors upload before/after photos, update
                        status in real-time.
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl dark:text-white font-bold">Team Management</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Assign roles: designers, contractors, managers with
                        fine-grained
                        permissions.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl dark:text-white font-bold">Real-Time Analytics</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Dashboard with campaign health, performance
                        metrics, and insights.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl dark:text-white font-bold">API First</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Connect with your existing tools. Build custom
                        integrations.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works Section --}}
    <section id="how-it-works" class="bg-white dark:bg-gray-900 py-16">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl dark:text-white">How
                    CampaignOS Works</h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Simple, intuitive, and powerful.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-gradient rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto">
                        1</div>
                    <h3 class="mt-4 text-xl dark:text-white font-bold">Import Excel Data</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Upload your campaign spreadsheet. We parse and
                        structure it
                        automatically.</p>
                </div>
                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-gradient rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto">
                        2</div>
                    <h3 class="mt-4 text-xl dark:text-white font-bold">Generate Designs</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Our Python engine creates designs from your
                        templates and data.</p>
                </div>
                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-gradient rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto">
                        3</div>
                    <h3 class="mt-4 text-xl dark:text-white font-bold">Track Execution</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Assign tasks to contractors. They update progress
                        via mobile app.</p>
                </div>
                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-gradient rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto">
                        4</div>
                    <h3 class="mt-4 text-xl dark:text-white font-bold">Analyze & Improve</h3>
                    <p class="text-gray-600 dark:text-gray-200 mt-2">Get insights on campaign performance and team
                        efficiency.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Dashboard Preview Section --}}
    <section class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl dark:text-white">One Dashboard
                to Rule Them All</h2>
            <p class="mt-4 text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">See campaign health, team
                performance, and key metrics at a glance.</p>
            <div class="mt-12 bg-white rounded-xl shadow-xl overflow-hidden">
                <img src="{{ asset('assets/img/demo-light.png') }}" class="w-full dark:hidden" alt="Dashboard Preview">
                <img src="{{ asset('assets/img/demo-dark.png') }}" class="w-full hidden dark:block" alt="Dashboard Preview">
            </div>
        </div>
    </section>

    {{-- Apps Preview Section --}}
    <section id="apps" class="bg-gradient py-16">
        <div class="w-full text-center bg-neutral-primary-soft p-6 rounded-base shadow-xs">
            <h5 class="mb-3 text-2xl tracking-tight font-semibold text-heading text-white">Work fast from anywhere
            </h5>
            <p class="mb-6 text-base text-body text-white sm:text-lg">Stay up to date and move work forward with
                CampaignOS on iOS &
                Android. <br>Download the app today.</p>
            <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
                <a href="#"
                    class="w-full sm:w-auto rounded-lg bg-dark dark:bg-light hover:bg-purple-500 focus:ring-4 focus:outline-none focus:ring-neutral-quaternary text-white dark:text-black rounded-base inline-flex items-center justify-center px-4 py-3">
                    <svg class="me-2 w-7 h-7" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="apple"
                        role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                        <path fill="currentColor"
                            d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z">
                        </path>
                    </svg>
                    <div class="text-left rtl:text-right">
                        <div class="text-xs">Download on the</div>
                        <div class="text-sm font-bold">Mac App Store</div>
                    </div>
                </a>
                <a href="#"
                    class="w-full sm:w-auto rounded-lg bg-dark dark:bg-light hover:bg-purple-500 focus:ring-4 focus:outline-none focus:ring-neutral-quaternary text-white dark:text-black rounded-base inline-flex items-center justify-center px-4 py-3">
                    <svg class="me-2 w-7 h-7" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google-play"
                        role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z">
                        </path>
                    </svg>
                    <div class="text-left rtl:text-right">
                        <div class="text-xs">Get in on</div>
                        <div class="text-sm font-bold">Google Play</div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- Pricing Section --}}
    <section id="pricing" class="bg-white dark:bg-gray-800 py-16">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl dark:text-white">Simple,
                    Transparent Pricing
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Choose the plan that fits your team.</p>
            </div>
            <!-- Plans Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($plans as $plan)
                    <div
                        class="bg-gray-50 dark:bg-gray-800 dark:text-white rounded-lg shadow-md p-6 text-center border-2 transform {{ $plan->is_popular ? 'border-blue-500 md:scale-105' : 'border-blue-500 scale-95 md:scale-100' }}">
                        @if ($plan->is_popular)
                            <div class="bg-gradient text-white text-xs font-bold px-2 py-1 rounded-full inline-block -mt-8 mb-2">
                                Most Popular
                            </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-bold">{{ $plan->name }}</h3>
                            <p class="text-sm text-body dark:text-white mt-1">
                                {{ $plan->billing_cycle === 'monthly' ? 'Monthly' : 'Yearly' }} billing
                            </p>
                        </div>
                        <div class="mt-4 text-4xl font-bold">
                            @if($plan->price == 0)
                                <span class="text-2xl">Contact Us</span>
                            @else
                                ${{ number_format($plan->price, 2) }}
                                <span class="text-lg font-normal">
                                    /{{ $plan->billing_cycle === 'monthly' ? 'month' : 'year' }}
                                </span>
                            @endif
                        </div>
                        <!-- Plan Details -->
                        <div class="p-5 space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-body dark:text-white">User limit</span>
                                <span
                                    class="font-medium text-heading dark:text-white">{{ $plan->user_limit ?: 'Unlimited' }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-body dark:text-white">Campaign limit</span>
                                <span
                                    class="font-medium text-heading dark:text-white">{{ $plan->campaign_limit ?: 'Unlimited' }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-body dark:text-white">Storage limit</span>
                                <span
                                    class="font-medium text-heading dark:text-white">{{ $plan->storage_limit ? $plan->storage_limit . ' MB' : 'Unlimited' }}</span>
                            </div>

                            @if($plan->features && count($plan->features) > 0)
                                <div class="pt-3">
                                    <p class="text-sm font-medium text-heading dark:text-white mb-2">Features</p>
                                    <ul class="space-y-1">
                                        @foreach($plan->features as $feature)
                                            <li class="flex items-center text-sm text-body dark:text-white">
                                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ $feature }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <a href="{{ $plan->price == 0 ? route('pages.contact') : '#' }}"
                            class="mt-6 inline-block w-full px-5 py-3 text-sm font-medium
                                                                    {{ $plan->is_popular ? 'bg-gradient text-white' : 'border-2 text-blue-500' }}
                                                                    border-blue-500 hover:bg-blue-500 hover:text-white hover:scale-105 rounded-lg transition-all ease-linear">
                            {{ $plan->price == 0 ? 'Contact Us' : 'Get Started' }}
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-body">
                        No plans found.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="bg-gradient py-16">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Ready to Transform Your Campaigns?
            </h2>
            <p class="mt-4 text-lg text-purple-100 max-w-2xl mx-auto">Join hundreds of advertising companies already
                using CampaignOS to streamline their operations.</p>
            <div class="mt-8">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-blue-600 bg-white rounded-lg hover:bg-gray-100">
                    Get Started Free
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
@endsection
