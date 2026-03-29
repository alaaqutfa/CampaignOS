@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-heading dark:text-white">Create New User</h1>
                <p class="text-body dark:text-neutral-400 mt-1">Add a new user to your company</p>
            </div>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-heading dark:text-white mb-1">Full Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-heading dark:text-white mb-1">Email Address
                        <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-heading dark:text-white mb-1">Password <span
                            class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="mb-4">
                    <label for="password_confirmation"
                        class="block text-sm font-medium text-heading dark:text-white mb-1">Confirm Password <span
                            class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <!-- Role -->
                <div class="mb-6">
                    <label for="roles" class="block text-sm font-medium text-heading dark:text-white mb-1">Roles <span
                            class="text-red-500">*</span></label>
                    @foreach (['management' => 'Management', 'design' => 'Design', 'field' => 'Field Staff'] as $groupKey => $groupLabel)
                        <div class="mb-4">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-2">
                                {{ $groupLabel }}
                            </p>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach($roles->where('group', $groupKey) as $role)
                                    <label
                                        class="flex items-center gap-2 p-2 rounded-lg border border-default cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800">
                                        <input type="checkbox" name="roles[]" value="{{ $role['name'] }}"
                                            class="text-primary-500 focus:ring-primary-500" {{ in_array($role['name'], old('roles', [])) ? 'checked' : '' }}>

                                        <span class="text-sm text-heading dark:text-white">
                                            {{ ucfirst(str_replace('_', ' ', $role['name'])) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @error('roles')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('users.index') }}"
                        class="px-4 py-2 text-sm font-medium text-heading bg-light border border-default rounded-base hover:bg-neutral-100 dark:hover:bg-neutral-800 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
