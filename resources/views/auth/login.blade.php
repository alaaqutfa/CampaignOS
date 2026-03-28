@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-heading dark:text-white">Welcome Back</h2>
            <p class="text-body dark:text-neutral-400 mt-1">Sign in to your account to continue</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div
                class="p-4 rounded-base bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-heading dark:text-white mb-1">Email Address <span
                        class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username"
                    class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-heading dark:text-white mb-1">Password <span
                        class="text-red-500">*</span></label>
                <input type="password" name="password" id="password" required autocomplete="current-password"
                    class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember"
                        class="rounded border-default text-primary-600 focus:ring-primary-500">
                    <span class="ml-2 text-sm text-body dark:text-neutral-400">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 transition">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full px-5 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 transition focus:outline-none focus:ring-2 focus:ring-primary-500">
                    Log in
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <p class="text-sm text-body dark:text-neutral-400">
                    Don't have an account?
                    <a href="{{ route('register') }}"
                        class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 transition">Get
                        Started</a>
                </p>
            </div>
        </form>
    </div>
@endsection
