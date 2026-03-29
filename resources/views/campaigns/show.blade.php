@extends('layouts.app')

@section('title', $campaign->title)

@section('content')
    <div class="space-y-6">
        <!-- Header with actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <h1 class="text-2xl font-bold text-heading dark:text-white">{{ $campaign->title }}</h1>
                    <span class="px-2 py-1 text-xs font-medium rounded-full
                        @if($campaign->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                        @elseif($campaign->status === 'draft') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                        @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300 @endif">
                        {{ ucfirst($campaign->status) }}
                    </span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full
                        @if($campaign->priority === 'high') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                        @elseif($campaign->priority === 'medium') bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300
                        @else bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 @endif">
                        {{ ucfirst($campaign->priority) }} Priority
                    </span>
                </div>
                <p class="text-body dark:text-neutral-400 mt-1">Campaign details and measurements</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('campaigns.edit', $campaign) }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 transition">
                    Edit Campaign
                </a>
                <button type="button" data-modal-target="delete-campaign-modal" data-modal-toggle="delete-campaign-modal"
                    class="px-4 py-2 text-sm font-medium text-red-600 border border-red-600 rounded-base hover:bg-red-50 dark:text-red-400 dark:border-red-400 dark:hover:bg-red-900/20 transition">
                    Delete
                </button>
            </div>
        </div>

        <!-- Campaign Information Card -->
        <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default overflow-hidden">
            <div class="px-6 py-4 border-b border-default">
                <h2 class="text-lg font-semibold text-heading dark:text-white">Campaign Information</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-body dark:text-white mb-1">Client Name</p>
                    <p class="text-base text-heading dark:text-white">{{ $campaign->client_name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-body dark:text-white mb-1">Location</p>
                    <p class="text-base text-heading dark:text-white">{{ $campaign->location ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-body dark:text-white mb-1">Due Date</p>
                    <p class="text-base text-heading dark:text-white">
                        {{ $campaign->due_date ? $campaign->due_date->format('M d, Y') : '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-body dark:text-white mb-1">Created By</p>
                    <p class="text-base text-heading dark:text-white">{{ $campaign->creator->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-body dark:text-white mb-1">Created At</p>
                    <p class="text-base text-heading dark:text-white">{{ $campaign->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-body dark:text-white mb-1">Last Updated</p>
                    <p class="text-base text-heading dark:text-white">{{ $campaign->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Measurements Section -->
        <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default overflow-hidden">
            <div class="px-6 py-4 border-b border-default flex justify-between items-center">
                <h2 class="text-lg font-semibold text-heading dark:text-white">Measurements
                    ({{ $campaign->items->count() }})</h2>
                    <div class="flex gap-2">
                        <a href="{{ route('items.create', $campaign) }}"
                            class="px-3 py-1 text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300">
                            + Add Measurement
                        </a>
                        <a href="{{ route('contractor-assignments.index') }}"
                            class="px-3 py-1 text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300">
                            + Contractor Assignments
                        </a>
                    </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-default">
                    <thead class="bg-neutral-50 dark:bg-neutral-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Shop</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Material</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Dimensions</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Qty</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">SQM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Recorded By</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-body dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-light dark:bg-dark divide-y divide-default">
                        @forelse($campaign->items as $item)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-heading dark:text-white">
                                    {{ $item->shop->name }}<br>
                                    <span class="text-xs text-body">{{ $item->shop->city->name ?? '' }} - </span>
                                    <span class="text-xs text-body">{{ $item->shop->address ?? '' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                    {{ $item->material }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                    {{ $item->width }} x {{ $item->height }} {{ $item->unit }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                    {{ number_format($item->sqm, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                            @if($item->status === 'installed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                            @elseif($item->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                            @elseif($item->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300 @endif">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                    {{ $item->recordedBy->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    {{-- @if(in_array($item->status, ['pending', 'design', 'print', 'rejected'])) --}}
                                        <a href="{{ route('items.edit', [$campaign, $item]) }}"
                                            class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 mr-3">Edit</a>
                                    {{-- @endif --}}
                                    <a href="{{ route('assets.index', [$campaign, $item]) }}"
                                        class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 mr-3">Images</a>
                                    @if($item->status === 'pending')
                                        <button type="button" data-modal-target="delete-item-modal-{{ $item->id }}"
                                            data-modal-toggle="delete-item-modal-{{ $item->id }}"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                    @endif
                                </td>
                            </tr>

                            {{-- Delete Item Modal --}}
                            <div id="delete-item-modal-{{ $item->id }}" tabindex="-1"
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
                                                want to delete this measurement?</h3>
                                            <form action="{{ route('items.destroy', [$campaign, $item]) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-base text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Yes, delete
                                                </button>
                                            </form>
                                            <button data-modal-hide="delete-item-modal-{{ $item->id }}" type="button"
                                                class="py-2.5 px-5 ms-3 text-sm font-medium text-heading focus:outline-none bg-light rounded-base border border-default hover:bg-neutral-100 dark:hover:bg-neutral-800">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-body">
                                    No measurements added yet.
                                    <a href="{{ route('items.create', $campaign) }}"
                                        class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 underline">Add
                                        one</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Workflows Section (اختياري) -->
        @if($campaign->workflows->count() > 0)
            <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default overflow-hidden">
                <div class="px-6 py-4 border-b border-default">
                    <h2 class="text-lg font-semibold text-heading dark:text-white">Workflows</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-default">
                        <thead class="bg-neutral-50 dark:bg-neutral-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Stage</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Assigned To</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Started At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Completed At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($campaign->workflows as $workflow)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-heading dark:text-white">
                                        {{ ucfirst($workflow->stage) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                        {{ ucfirst($workflow->status) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                        {{ $workflow->assignee->name ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                        {{ $workflow->started_at ? $workflow->started_at->format('M d, Y H:i') : '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                        {{ $workflow->completed_at ? $workflow->completed_at->format('M d, Y H:i') : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    {{-- Delete Campaign Modal (مشابه للي كان) --}}
    <div id="delete-campaign-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-light dark:bg-dark rounded-base shadow border border-default">
                <div class="p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-heading dark:text-white">Are you sure you want to delete
                        "{{ $campaign->title }}"?</h3>
                    <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-base text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Yes, delete
                        </button>
                    </form>
                    <button data-modal-hide="delete-campaign-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-heading focus:outline-none bg-light rounded-base border border-default hover:bg-neutral-100 dark:hover:bg-neutral-800">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
