@extends('layouts.app')

@section('title', 'Add Client')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white dark:bg-dark rounded-xl shadow-md border border-default overflow-hidden">
            <div
                class="px-6 py-4 border-b border-default bg-gradient-to-r from-primary-50 to-transparent dark:from-primary-900/20">
                <h1 class="text-xl font-bold text-heading dark:text-white">Add New Client</h1>
                <p class="text-sm text-gray-500">Fill in the details to create a client portal</p>
            </div>
            <form action="{{ route('clients.store') }}" method="POST" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-heading dark:text-white mb-1">Full Name *</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                        class="w-full rounded-lg border-default bg-light dark:bg-gray-900 focus:ring-primary-500 focus:border-primary-500">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-heading dark:text-white mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full rounded-lg border-default bg-light dark:bg-gray-900">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-heading dark:text-white mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full rounded-lg border-default bg-light dark:bg-gray-900">
                </div>
                <div>
                    <label class="block text-sm font-medium text-heading dark:text-white mb-1">Address</label>
                    <textarea name="address" rows="3"
                        class="w-full rounded-lg border-default bg-light dark:bg-gray-900">{{ old('address') }}</textarea>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('clients.index') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-white">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Save
                        Client</button>
                </div>
            </form>
        </div>
    </div>
@endsection
