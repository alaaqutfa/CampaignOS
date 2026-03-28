@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-heading dark:text-white">Create your account</h2>
            <p class="text-body dark:text-neutral-400 mt-1">Join CampaignOS and start managing your campaigns</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-heading dark:text-white mb-1">Full Name <span
                        class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Company Name -->
            <div>
                <label for="company_name" class="block text-sm font-medium text-heading dark:text-white mb-1">Company Name
                    <span class="text-red-500">*</span></label>
                <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" required
                    class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('company_name') border-red-500 @enderror">
                @error('company_name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-heading dark:text-white mb-1">Email Address <span
                        class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="username"
                    class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-heading dark:text-white mb-1">Password <span
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

            <!-- Submit Button & Login Link -->
            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('login') }}"
                    class="text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 transition">
                    Already registered?
                </a>
                <button type="submit"
                    class="px-5 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 transition focus:outline-none focus:ring-2 focus:ring-primary-500">
                    Register
                </button>
            </div>
        </form>
    </div>
@endsection
