@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-heading dark:text-white">Reset Password</h2>
            <p class="text-body dark:text-neutral-400 mt-1">Forgot your password? Enter your email and we'll send you a
                reset link.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div
                class="p-4 rounded-base bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-heading dark:text-white mb-1">Email Address <span
                        class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="px-5 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 transition focus:outline-none focus:ring-2 focus:ring-primary-500">
                    Send Password Reset Link
                </button>
            </div>
        </form>
    </div>
@endsection
