@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-heading dark:text-white">Profile Settings</h1>
            <p class="text-body dark:text-neutral-400 mt-1">Manage your account settings and preferences</p>
        </div>

        <!-- Update Profile Information -->
        <div class="bg-light dark:bg-dark rounded-base shadow-sm border border-default p-6">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password -->
        <div class="bg-light dark:bg-dark rounded-base shadow-sm border border-default p-6">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete Account -->
        <div class="bg-light dark:bg-dark rounded-base shadow-sm border border-default p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
