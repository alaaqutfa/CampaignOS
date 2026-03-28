@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-heading dark:text-white">Users</h1>
                <p class="text-body dark:text-gray-400 mt-1">Manage all platform users (excluding super admins)</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('super-admin.roles.index') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-base text-white bg-primary-600 hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 transition">
                    <svg class="w-5 h-5 mr-2"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-1 1v8a1 1 0 001 1h10a1 1 0 001-1V8a1 1 0 00-1-1h-1V6a4 4 0 00-4-4zM8 6a2 2 0 114 0v1H8V6zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="ms-3">Roles</span>
                </a>
                <a href="{{ route('super-admin.users.create') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-base text-white bg-primary-600 hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New User
                </a>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-default">
                    <thead class="bg-neutral-50 dark:bg-neutral-800">
                        <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">Company</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">Roles</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">Created At
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">Actions</th>
                    </thead>
                    <tbody class="bg-light dark:bg-dark divide-y divide-default">
                        @forelse($users as $user)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-heading dark:text-white">
                                    {{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">{{ $user->company->name ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                    @foreach($user->roles as $role)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900/30 dark:text-primary-300 mr-1">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                    {{ $user->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('super-admin.users.edit', $user) }}"
                                            class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 transition">
                                            Edit
                                        </a>
                                        <a href="{{ route('super-admin.roles.edit', $role) }}"
                                            class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 transition">
                                            Edit Role
                                        </a>
                                        <button type="button" data-modal-target="delete-modal-{{ $user->id }}"
                                            data-modal-toggle="delete-modal-{{ $user->id }}"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition">
                                            Delete
                                        </button>
                                    </div>

                                    <!-- Delete Confirmation Modal -->
                                    <div id="delete-modal-{{ $user->id }}" tabindex="-1"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                            <div
                                                class="relative bg-light dark:bg-dark rounded-base shadow border border-default">
                                                <div class="p-5 text-center">
                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-300"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-heading dark:text-white">Are you
                                                        sure you want to delete "{{ $user->name }}"?</h3>
                                                    <form action="{{ route('super-admin.users.destroy', $user) }}" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-base text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                            Yes, delete
                                                        </button>
                                                    </form>
                                                    <button data-modal-hide="delete-modal-{{ $user->id }}" type="button"
                                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-heading focus:outline-none bg-light rounded-base border border-default hover:bg-neutral-100 dark:hover:bg-neutral-800 focus:z-10 focus:ring-4 focus:ring-neutral-300 dark:focus:ring-neutral-700">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-body">
                                    No users found.
                                    <a href="{{ route('super-admin.users.create') }}"
                                        class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 underline">Create
                                        one</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-default">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
