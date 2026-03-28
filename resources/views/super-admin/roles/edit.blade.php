@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-heading dark:text-white">Edit Role</h1>
                <p class="text-body dark:text-neutral-400 mt-1">Update role name and permissions</p>
            </div>

            <form action="{{ route('super-admin.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Role Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-heading dark:text-white mb-1">Role Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Permissions -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-heading dark:text-white mb-2">Permissions</label>
                    <div
                        class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 p-3 bg-neutral-50 dark:bg-neutral-800/50 rounded-base border border-default">
                        @forelse($permissions as $permission)
                            <label class="inline-flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                    class="rounded border-default text-primary-600 focus:ring-primary-500 focus:ring-2 focus:ring-offset-0 dark:bg-dark dark:checked:bg-primary-600"
                                    {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                <span class="text-sm text-body dark:text-neutral-300">{{ $permission->name }}</span>
                            </label>
                        @empty
                            <p class="text-sm text-body col-span-full">No permissions available.</p>
                        @endforelse
                    </div>
                    @error('permissions')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-default">
                    <a href="{{ route('super-admin.roles.index') }}"
                        class="px-4 py-2 text-sm font-medium text-heading bg-light border border-default rounded-base hover:bg-neutral-100 dark:hover:bg-neutral-800 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
