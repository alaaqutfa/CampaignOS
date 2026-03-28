@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-heading dark:text-white">Verify Your Email</h2>
            <p class="text-body dark:text-neutral-400 mt-1">Thanks for signing up! Before getting started, please verify
                your email address.</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div
                class="p-4 rounded-base bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                A new verification link has been sent to the email address you provided.
            </div>
        @endif

        <div class="flex flex-col space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                    class="w-full px-5 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 transition focus:outline-none focus:ring-2 focus:ring-primary-500">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full px-5 py-2 text-sm font-medium text-heading dark:text-white bg-light dark:bg-dark border border-default rounded-base hover:bg-neutral-100 dark:hover:bg-neutral-800 transition focus:outline-none focus:ring-2 focus:ring-primary-500">
                    Log Out
                </button>
            </form>
        </div>
    </div>
@endsection
