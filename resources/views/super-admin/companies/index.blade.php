@extends('layouts.app')

@section('title', 'Companies')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-heading dark:text-white">Companies</h1>
            <p class="text-body dark:text-gray-400 mt-1">Manage all registered companies on the platform</p>
        </div>
        <a href="{{ route('super-admin.companies.create') }}"
           class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-base text-white bg-primary-600 hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Company
        </a>
    </div>

    <!-- Companies Table -->
    <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-default">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">Logo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">Commercial Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-light dark:bg-dark divide-y divide-default">
                    @forelse($companies as $company)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($company->logo)
                                <img src="{{ asset("storage/app/public/".$company->logo) }}" alt="{{ $company->name }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/20 flex items-center justify-center">
                                    <span class="text-primary-600 dark:text-primary-400 font-semibold">{{ substr($company->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-heading dark:text-white">{{ $company->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">{{ $company->commercial_name ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $company->status ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                                {{ $company->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('super-admin.companies.edit', $company) }}"
                                   class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 transition">
                                    Edit
                                </a>
                                <button type="button"
                                        data-modal-target="delete-modal-{{ $company->id }}"
                                        data-modal-toggle="delete-modal-{{ $company->id }}"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition">
                                    Delete
                                </button>
                            </div>

                            <!-- Delete Confirmation Modal -->
                            <div id="delete-modal-{{ $company->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                    <div class="relative bg-light dark:bg-dark rounded-base shadow border border-default">
                                        <div class="p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-heading dark:text-white">Are you sure you want to delete "{{ $company->name }}"?</h3>
                                            <form action="{{ route('super-admin.companies.destroy', $company) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-base text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Yes, delete
                                                </button>
                                            </form>
                                            <button data-modal-hide="delete-modal-{{ $company->id }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-heading focus:outline-none bg-light rounded-base border border-default hover:bg-neutral-100 dark:hover:bg-neutral-800 focus:z-10 focus:ring-4 focus:ring-neutral-300 dark:focus:ring-neutral-700">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-body">
                            No companies found.
                            <a href="{{ route('super-admin.companies.create') }}" class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 underline">Create one</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($companies->hasPages())
        <div class="px-6 py-4 border-t border-default">
            {{ $companies->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
