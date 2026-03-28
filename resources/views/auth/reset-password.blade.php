@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-heading dark:text-white">Reset Password</h2>
            <p class="text-body dark:text-neutral-400 mt-1">Enter your new password below</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-heading dark:text-white mb-1">Email Address <span
                        class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $request->email) }}" required autofocus
                    autocomplete="username"
                    class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-heading dark:text-white mb-1">New Password <span
                        class="text-red-500">*</span></label>
                <input type="password" name="password" id="password" required autocomplete="new-password"
                    class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation"
                    class="block text-sm font-medium text-heading dark:text-white mb-1">Confirm Password <span
                        class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    autocomplete="new-password"
                    class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="px-5 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 transition focus:outline-none focus:ring-2 focus:ring-primary-500">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
@endsection
