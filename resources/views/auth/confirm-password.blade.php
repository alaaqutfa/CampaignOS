@extends('layouts.guest')

@section('title', 'Confirm Password')

@section('content')
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-heading dark:text-white">Confirm Password</h2>
            <p class="text-body dark:text-neutral-400 mt-1">This is a secure area. Please confirm your password before
                continuing.</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

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

            <!-- Submit Button -->
            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="px-5 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 transition focus:outline-none focus:ring-2 focus:ring-primary-500">
                    Confirm
                </button>
            </div>
        </form>
    </div>
@endsection
