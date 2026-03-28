@extends('layouts.app')

@section('title', 'Campaigns')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-heading dark:text-white">Campaigns</h1>
                <p class="text-body dark:text-neutral-400 mt-1">Manage all your campaigns</p>
            </div>
            <a href="{{ route('campaigns.create') }}"
                class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 transition">
                + New Campaign
            </a>
        </div>

        <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-default">
                    <thead class="bg-neutral-50 dark:bg-neutral-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">
                                Title
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">
                                Client
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">
                                Priority
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">
                                Due Date
                            </th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-body dark:text-white uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-light dark:bg-dark divide-y divide-default">
                        @forelse($campaigns as $campaign)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-heading dark:text-white">
                                    <a href="{{ route('campaigns.show', $campaign) }}"
                                        class="hover:underline">{{ $campaign->title }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                    {{ $campaign->client_name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full
                                                    @if($campaign->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                    @elseif($campaign->status === 'draft') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300 @endif">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full
                                                    @if($campaign->priority === 'high') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                                    @elseif($campaign->priority === 'medium') bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300
                                                    @else bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 @endif">
                                        {{ ucfirst($campaign->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                    {{ $campaign->due_date ? $campaign->due_date->format('M d, Y') : '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('campaigns.show', $campaign) }}"
                                        class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 mr-3">
                                        View
                                    </a>
                                    <a href="{{ route('campaigns.edit', $campaign) }}"
                                        class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 mr-3">
                                        Edit
                                    </a>
                                    <button type="button" data-modal-target="delete-modal-{{ $campaign->id }}"
                                        data-modal-toggle="delete-modal-{{ $campaign->id }}"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            {{-- Delete Modal (مشابه للذي كان موجود) --}}
                            <div id="delete-modal-{{ $campaign->id }}" tabindex="-1"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                    <div class="relative bg-light dark:bg-dark rounded-base shadow border border-default">
                                        <div class="p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-300" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-heading dark:text-white">Are you sure you
                                                want to delete "{{ $campaign->title }}"?</h3>
                                            <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-base text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Yes, delete
                                                </button>
                                            </form>
                                            <button data-modal-hide="delete-modal-{{ $campaign->id }}" type="button"
                                                class="py-2.5 px-5 ms-3 text-sm font-medium text-heading focus:outline-none bg-light rounded-base border border-default hover:bg-neutral-100 dark:hover:bg-neutral-800">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-body">
                                    No campaigns found.
                                    <a href="{{ route('campaigns.create') }}"
                                        class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 underline">Create
                                        one</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-default">
                {{ $campaigns->links() }}
            </div>
        </div>
    </div>
@endsection
