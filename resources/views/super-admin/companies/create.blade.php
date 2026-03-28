@extends('layouts.app')

@section('title', 'Add New Company')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-heading dark:text-white">Add New Company</h1>
                <p class="text-body dark:text-gray-400 mt-1">Create a new company account</p>
            </div>

            <form action="{{ route('super-admin.companies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-heading dark:text-white mb-1">Company Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Commercial Name -->
                <div class="mb-4">
                    <label for="commercial_name"
                        class="block text-sm font-medium text-heading dark:text-white mb-1">Commercial Name
                        (Optional)</label>
                    <input type="text" name="commercial_name" id="commercial_name" value="{{ old('commercial_name') }}"
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <!-- Logo -->
                <div class="mb-4">
                    <label for="logo" class="block text-sm font-medium text-heading dark:text-white mb-1">Logo
                        (Optional)</label>
                    <input type="file" name="logo" id="logo" accept="image/*"
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-base file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 dark:file:bg-primary-900/20 dark:file:text-primary-300 hover:file:bg-primary-100">
                    <p class="mt-1 text-xs text-body">Max size: 2MB. Supported formats: JPG, PNG, GIF</p>
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Info -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-heading dark:text-white mb-1">Contact Information
                        (Optional)</label>
                    <div class="space-y-3">
                        <input type="text" name="contact_info[email]" placeholder="Email"
                            value="{{ old('contact_info.email') }}"
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <input type="text" name="contact_info[phone]" placeholder="Phone"
                            value="{{ old('contact_info.phone') }}"
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <input type="text" name="contact_info[address]" placeholder="Address"
                            value="{{ old('contact_info.address') }}"
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="status" value="1" {{ old('status') ? 'checked' : '' }}
                            class="rounded border-default text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-heading dark:text-white">Active</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('super-admin.companies.index') }}"
                        class="px-4 py-2 text-sm font-medium text-heading bg-light border border-default rounded-base hover:bg-neutral-100 dark:hover:bg-neutral-800 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                        Create Company
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
