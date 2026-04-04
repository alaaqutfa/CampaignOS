@extends('layouts.app')

@section('title', $campaign->title)

@section('content')
    <div class="space-y-8">
        <!-- Header with actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <h1
                        class="text-2xl font-bold bg-gradient-to-r from-primary-600 to-accent-400 bg-clip-text text-transparent">
                        {{ $campaign->title }}
                    </h1>
                    <span
                        class="px-2 py-1 text-xs font-medium rounded-full
                                                                                        @if($campaign->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                                                        @elseif($campaign->status === 'draft') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                                                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300 @endif">
                        {{ ucfirst($campaign->status) }}
                    </span>
                    <span
                        class="px-2 py-1 text-xs font-medium rounded-full
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
                    class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 transition shadow-sm">
                    Edit Campaign
                </a>
                <button type="button" data-modal-target="delete-campaign-modal" data-modal-toggle="delete-campaign-modal"
                    class="px-4 py-2 text-sm font-medium text-red-600 border border-red-600 rounded-base hover:bg-red-50 dark:text-red-400 dark:border-red-400 dark:hover:bg-red-900/20 transition">
                    Delete
                </button>
            </div>
        </div>

        <!-- Stats Cards Row -->
        @php
            $statusTotals = $campaign->items()
                ->selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status');

            $total = $campaign->items()->count();
            $pending = $statusTotals['pending'] ?? 0;
            $measured = $statusTotals['measured'] ?? 0;
            $designed = $statusTotals['designed'] ?? 0;
            $printed = $statusTotals['printed'] ?? 0;
            $installed = $statusTotals['installed'] ?? 0;
            $rejected = $statusTotals['rejected'] ?? 0;

            $totalItems = $total;
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
            <div
                class="bg-white dark:bg-dark rounded-xl shadow-sm border border-default p-4 transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total</p>
                        <p class="text-2xl font-bold text-heading dark:text-white">{{ $total }}</p>
                    </div>
                    <div class="p-2 bg-primary-100 dark:bg-primary-900/30 rounded-full">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-dark rounded-xl shadow-sm border border-default p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Pending</p>
                        <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $pending }}</p>
                    </div>
                    <div class="p-2 bg-yellow-100 dark:bg-yellow-900/30 rounded-full">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-dark rounded-xl shadow-sm border border-default p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Measured</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $measured }}</p>
                    </div>
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-dark rounded-xl shadow-sm border border-default p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Designed</p>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $designed }}</p>
                    </div>
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-dark rounded-xl shadow-sm border border-default p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Printed</p>
                        <p class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">{{ $printed }}</p>
                    </div>
                    <div class="p-2 bg-cyan-100 dark:bg-cyan-900/30 rounded-full">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-dark rounded-xl shadow-sm border border-default p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Installed</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $installed }}</p>
                    </div>
                    <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-full">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-dark rounded-xl shadow-sm border border-default p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Rejected</p>
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $rejected }}</p>
                    </div>
                    <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-full">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Campaign Info Card (shortened) -->
        <div class="bg-white dark:bg-dark rounded-xl shadow-sm border border-default overflow-hidden">
            <div class="px-6 py-4 border-b border-default flex justify-between items-center">
                <h2 class="text-lg font-semibold text-heading dark:text-white">Campaign Details</h2>
                <form method="GET" action="{{ route('campaigns.export-before-after-pdf', $campaign) }}"
                    class="flex items-center gap-2">

                    <select name="city_id" id="citySelect"
                        class="text-sm border border-gray-300 rounded-lg px-2 py-1 dark:bg-gray-800 dark:text-white">
                        <option value="">Select City</option>

                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">
                                {{ $city->name }}
                            </option>
                        @endforeach

                    </select>

                    <button type="submit" id="exportBtn"
                        class="inline-flex items-center gap-2 text-sm bg-gradient-to-r from-primary-600 to-accent-500 text-white px-3 py-1.5 rounded-lg hover:opacity-90 transition">
                        Export PDF
                    </button>

                </form>
            </div>
            <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4 dark:text-gray-100">
                <div>
                    <p class="text-sm text-gray-500">Client</p>
                    <p class="font-medium">{{ $campaign->client->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Location</p>
                    <p class="font-medium">{{ $campaign->location ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Due Date</p>
                    <p class="font-medium">{{ $campaign->due_date ? $campaign->due_date->format('M d, Y') : '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Created</p>
                    <p class="font-medium">{{ $campaign->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Measurements Section with Bulk Actions -->
        <div class="bg-white dark:bg-dark rounded-xl shadow-sm border border-default overflow-hidden">
            <div class="px-6 py-4 border-b border-default flex flex-wrap justify-between items-center gap-3">
                <h2 class="text-lg font-semibold text-heading dark:text-white">Measurements ({{ $items->total() }})</h2>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('contractor-assignments.index') }}"
                        class="px-3 py-1.5 text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 border border-primary-200 rounded-lg hover:bg-primary-50 transition">
                        Contractor Assignments
                    </a>
                    <a href="{{ route('items.create', $campaign) }}"
                        class="px-3 py-1.5 text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 border border-primary-200 rounded-lg hover:bg-primary-50 transition">+
                        Add Single</a>
                    <button type="button" onclick="openUploadModal()"
                        class="px-3 py-1.5 text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 border border-primary-200 rounded-lg hover:bg-primary-50 transition">+
                        Bulk Excel</button>
                    <a href="{{ route('items.export', $campaign) }}"
                        class="px-3 py-1.5 text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 border border-primary-200 rounded-lg hover:bg-primary-50 transition">Export
                        Excel</a>

                    <!-- Bulk Status Update Dropdown -->
                    <div class="relative inline-block">
                        <button id="bulkActionsBtn"
                            class="px-3 py-1.5 text-sm dark:text-gray-100 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition flex items-center gap-1">
                            Bulk Actions
                            <svg class="w-4 h-4 transition-transform duration-200" id="bulkArrowIcon" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div id="bulkDropdownMenu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-10 border border-default">
                            <div class="py-1">
                                <!-- Select All (local) -->
                                <label
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                    <input type="checkbox" id="selectAllCheckbox" class="mr-2 rounded border-gray-300">
                                    Select All (this page)
                                </label>
                                <div class="border-t border-default my-1"></div>

                                <!-- Bulk actions for selected items -->
                                <div class="px-4 py-1 text-xs font-semibold text-gray-500 uppercase">Selected Items</div>
                                <button data-status="pending"
                                    class="bulk-status-btn w-full text-left px-4 py-2 text-sm text-yellow-600 hover:bg-gray-100 dark:hover:bg-gray-700">Set
                                    Pending</button>
                                <button data-status="measured"
                                    class="bulk-status-btn w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-100 dark:hover:bg-gray-700">Set
                                    Measured</button>
                                <button data-status="designed"
                                    class="bulk-status-btn w-full text-left px-4 py-2 text-sm text-purple-600 hover:bg-gray-100 dark:hover:bg-gray-700">Set
                                    Designed</button>
                                <button data-status="printed"
                                    class="bulk-status-btn w-full text-left px-4 py-2 text-sm text-cyan-600 hover:bg-gray-100 dark:hover:bg-gray-700">Set
                                    Printed</button>
                                <!-- (optional installed/rejected if needed) -->

                                <div class="border-t border-default my-1"></div>

                                <!-- Bulk actions for ALL campaign items -->
                                <div class="px-4 py-1 text-xs font-semibold text-gray-500 uppercase">Entire Campaign</div>
                                <button data-all-status="pending"
                                    class="bulk-all-status-btn w-full text-left px-4 py-2 text-sm text-yellow-600 hover:bg-gray-100 dark:hover:bg-gray-700">Set
                                    All to Pending</button>
                                <button data-all-status="measured"
                                    class="bulk-all-status-btn w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-100 dark:hover:bg-gray-700">Set
                                    All to Measured</button>
                                <button data-all-status="designed"
                                    class="bulk-all-status-btn w-full text-left px-4 py-2 text-sm text-purple-600 hover:bg-gray-100 dark:hover:bg-gray-700">Set
                                    All to Designed</button>
                                <button data-all-status="printed"
                                    class="bulk-all-status-btn w-full text-left px-4 py-2 text-sm text-cyan-600 hover:bg-gray-100 dark:hover:bg-gray-700">Set
                                    All to Printed</button>
                                <button data-all-status="installed"
                                    class="bulk-all-status-btn w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-gray-100 dark:hover:bg-gray-700">Set
                                    All to Installed</button>
                                <button data-all-status="rejected"
                                    class="bulk-all-status-btn w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">Set
                                    All to Rejected</button>
                            </div>
                        </div>
                    </div>

                    <!-- Toggle View Button -->
                    <button id="toggleViewBtn"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition flex items-center gap-1">
                        <svg id="tableViewIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="cardViewIcon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        <span id="viewModeText">Table</span>
                    </button>
                </div>
            </div>

            <!-- Table View -->
            <div id="tableView" class="overflow-x-auto">
                <table class="min-w-full divide-y divide-default">
                    <thead class="bg-neutral-50 dark:bg-neutral-800">
                        <tr>
                            <th class="px-4 py-3 text-left"><input type="checkbox" id="selectAllCheckboxTable"
                                    class="rounded border-gray-300"></th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Shop</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Material</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Dimensions</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Qty/SQM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white">Recorded By</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-body dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-light dark:bg-dark divide-y divide-default">
                        @forelse($items as $item)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition"
                                data-item-id="{{ $item->id }}">
                                <td class="px-4 py-4"><input type="checkbox" class="item-checkbox rounded border-gray-300"
                                        value="{{ $item->id }}"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-heading dark:text-white">
                                    {{ $item->shop->name }}<br>
                                    <span class="text-xs text-body">{{ $item->shop->city->name ?? '' }} -
                                        {{ $item->shop->address ?? '' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">{{ $item->material }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">{{ $item->width }} x
                                    {{ $item->height }} {{ $item->unit }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">{{ $item->quantity }}
                                    / {{ number_format($item->sqm, 2) }} m²</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full
                                                                                                                                                                        @if($item->status === 'installed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                                                                                                                                        @elseif($item->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                                                                                                                                                        @elseif($item->status === 'measured') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                                                                                                                                                        @elseif($item->status === 'designed') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300
                                                                                                                                                                        @elseif($item->status === 'printed') bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300
                                                                                                                                                                        @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 @endif">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                    {{ $item->recordedBy->name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('items.edit', [$campaign, $item]) }}"
                                        class="text-primary-600 hover:text-primary-800 dark:text-primary-400 mr-3">Edit</a>
                                    <a href="{{ route('assets.index', [$campaign, $item]) }}"
                                        class="text-primary-600 hover:text-primary-800 dark:text-primary-400 mr-3">Images</a>
                                    @if($item->status === 'pending')
                                        <button type="button" data-modal-target="delete-item-modal-{{ $item->id }}"
                                            data-modal-toggle="delete-item-modal-{{ $item->id }}"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400">Delete</button>
                                    @endif
                                </td>
                            </tr>
                            <!-- Delete modal for item (keep as before) -->
                            <div id="delete-item-modal-{{ $item->id }}" tabindex="-1"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                    <div class="relative bg-light dark:bg-dark rounded-base shadow border border-default">
                                        <div class="p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-heading dark:text-white">Delete this
                                                measurement?</h3>
                                            <form action="{{ route('items.destroy', [$campaign, $item]) }}" method="POST"
                                                class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="text-white bg-red-600 hover:bg-red-800 rounded-lg px-5 py-2.5">Yes</button>
                                            </form>
                                            <button data-modal-hide="delete-item-modal-{{ $item->id }}"
                                                class="py-2.5 px-5 ml-3 text-sm font-medium bg-light rounded-lg border border-default">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">No measurements yet. <a
                                        href="{{ route('items.create', $campaign) }}" class="text-primary-600 underline">Add
                                        one</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Cards View -->
            <div id="cardsContainer" class="hidden grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 p-6">
                @foreach($items as $item)
                    <div
                        class="dark:text-white bg-white dark:bg-dark rounded-xl shadow-md border border-default overflow-hidden hover:shadow-lg transition">
                        <div
                            class="p-4 border-b border-default bg-gradient-to-r from-primary-50 to-transparent dark:from-primary-900/20">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-heading dark:text-white">{{ $item->shop->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $item->shop->city->name ?? '' }} -
                                        {{ $item->shop->address ?? '' }}
                                    </p>
                                </div>
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full
                                                                                                                        @if($item->status === 'installed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                                                                                        @elseif($item->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                                                                                                        @elseif($item->status === 'measured') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                                                                                                        @elseif($item->status === 'designed') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300
                                                                                                                        @elseif($item->status === 'printed') bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300
                                                                                                                        @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div><span class="text-gray-500">Material:</span> {{ $item->material }}</div>
                                <div><span class="text-gray-500">Dimensions:</span> {{ $item->width }}x{{ $item->height }}
                                    {{ $item->unit }}
                                </div>
                                <div><span class="text-gray-500">Qty:</span> {{ $item->quantity }}</div>
                                <div><span class="text-gray-500">SQM:</span> {{ number_format($item->sqm, 2) }} m²</div>
                            </div>
                            <div class="pt-2 border-t border-default flex justify-between items-center">
                                <span class="text-xs text-gray-500">Recorded by: {{ $item->recordedBy->name ?? '—' }}</span>
                                <div class="flex gap-2">
                                    <a href="{{ route('items.edit', [$campaign, $item]) }}"
                                        class="text-primary-600 hover:text-primary-800 text-sm">Edit</a>
                                    <a href="{{ route('assets.index', [$campaign, $item]) }}"
                                        class="text-primary-600 hover:text-primary-800 text-sm">Images</a>
                                    @if($item->status === 'pending')
                                        <button type="button" data-modal-target="delete-item-modal-{{ $item->id }}"
                                            data-modal-toggle="delete-item-modal-{{ $item->id }}"
                                            class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="px-6 py-4 border-t border-default">
                {{ $items->links() }}
            </div>
        </div>
    </div>

    {{-- Delete Campaign Modal --}}
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

    <div id="uploadModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Upload Excel Files (Measurements)
                    </h3>
                    <button type="button" onclick="closeUploadModal()"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-6">
                    <!-- منطقة اختيار الملفات -->
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-700 dark:bg-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                        to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">XLSX or XLS (Max 5MB each)</p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" accept=".xlsx,.xls" multiple />
                        </label>
                    </div>

                    <!-- قائمة الملفات المختارة مع حالة الرفع -->
                    <div id="file-list-container" class="mt-6 space-y-3 max-h-80 overflow-y-auto dark:text-white">
                        <!-- سيتم إضافة الملفات هنا ديناميكياً -->
                    </div>

                    <!-- أزرار التحكم -->
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="clearAllFiles()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
                            Clear All
                        </button>
                        <button type="button" id="start-upload-btn" onclick="startUpload()"
                            class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                            Upload (0 files)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Store selected files
        let selectedFiles = [];
        let uploadQueue = [];
        let isUploading = false;
        let currentUploadIndex = 0;

        document.getElementById('citySelect').addEventListener('change', function () {
            document.getElementById('exportBtn').disabled = !this.value;
        });

        // Open/Close modal (Flowbite)
        function openUploadModal() {
            const modal = document.getElementById('uploadModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }
        }
        function closeUploadModal() {
            const modal = document.getElementById('uploadModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            }
            // Optionally reset files on close
            // clearAllFiles();
        }

        // Handle file selection
        document.getElementById('dropzone-file').addEventListener('change', function (e) {
            const files = Array.from(e.target.files);
            files.forEach(file => {
                // Check duplicate by name + size
                const exists = selectedFiles.some(f => f.name === file.name && f.size === file.size);
                if (!exists) {
                    selectedFiles.push(file);
                }
            });
            renderFileList();
            e.target.value = ''; // allow re-select same file again
            updateUploadButton();
        });

        // Drag & drop support
        const dropzone = document.querySelector('#dropzone-file').parentElement;
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('border-primary-500', 'bg-primary-50', 'dark:bg-gray-700');
        });
        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-primary-500', 'bg-primary-50', 'dark:bg-gray-700');
        });
        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-primary-500', 'bg-primary-50', 'dark:bg-gray-700');
            const files = Array.from(e.dataTransfer.files).filter(f => f.name.match(/\.(xlsx|xls)$/i));
            files.forEach(file => {
                if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                    selectedFiles.push(file);
                }
            });
            renderFileList();
            updateUploadButton();
        });

        // Render file list with progress bars
        function renderFileList() {
            const container = document.getElementById('file-list-container');
            if (!container) return;
            if (selectedFiles.length === 0) {
                container.innerHTML = '<div class="text-center text-gray-500 dark:text-gray-400 py-4">No files selected</div>';
                return;
            }
            container.innerHTML = '';
            selectedFiles.forEach((file, index) => {
                const fileDiv = document.createElement('div');
                fileDiv.className = 'p-3 border border-gray-200 rounded-lg dark:border-gray-700 bg-gray-50 dark:bg-gray-900';
                fileDiv.id = `file-item-${index}`;
                const fileSize = (file.size / 1024).toFixed(2);
                const status = file.status || 'pending'; // pending, uploading, success, error
                let statusHtml = '';
                if (status === 'uploading') {
                    statusHtml = `
                                                                                            <div class="mt-2">
                                                                                                <div class="flex justify-between text-xs mb-1">
                                                                                                    <span>Uploading...</span>
                                                                                                    <span><span id="progress-percent-${index}">0</span>%</span>
                                                                                                </div>
                                                                                                <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                                                                                    <div id="progress-bar-${index}" class="bg-primary-600 h-2 rounded-full" style="width: 0%"></div>
                                                                                                </div>
                                                                                                <div class="flex justify-between text-xs mt-1 text-gray-500">
                                                                                                    <span id="speed-${index}">0 KB/s</span>
                                                                                                    <span id="eta-${index}">--</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        `;
                } else if (status === 'success') {
                    statusHtml = `<div class="mt-1 text-green-600 dark:text-green-400 text-sm">✓ Uploaded successfully</div>`;
                } else if (status === 'error') {
                    statusHtml = `<div class="mt-1 text-red-600 dark:text-red-400 text-sm">✗ Failed: <span id="error-msg-${index}"></span></div>`;
                } else {
                    statusHtml = `<div class="mt-1 text-gray-500 text-sm">Pending</div>`;
                }

                fileDiv.innerHTML = `
                                                                                        <div class="flex justify-between items-start">
                                                                                            <div class="flex-1">
                                                                                                <p class="font-medium truncate" title="${file.name}">${file.name}</p>
                                                                                                <p class="text-xs text-gray-500">${fileSize} KB</p>
                                                                                                ${statusHtml}
                                                                                            </div>
                                                                                            <button type="button" onclick="removeFile(${index})" class="text-red-600 hover:text-red-800 dark:text-red-400 ml-2">
                                                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                                            </button>
                                                                                        </div>
                                                                                    `;
                container.appendChild(fileDiv);
            });
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            renderFileList();
            updateUploadButton();
        }

        function clearAllFiles() {
            selectedFiles = [];
            renderFileList();
            updateUploadButton();
        }

        function updateUploadButton() {
            const btn = document.getElementById('start-upload-btn');
            if (btn) {
                const count = selectedFiles.length;
                btn.innerText = `Upload (${count} file${count !== 1 ? 's' : ''})`;
                btn.disabled = count === 0 || isUploading;
            }
        }

        // Upload files one by one
        async function startUpload() {
            if (selectedFiles.length === 0 || isUploading) return;
            isUploading = true;
            const btn = document.getElementById('start-upload-btn');
            btn.disabled = true;
            btn.innerText = 'Uploading...';

            // Reset statuses
            selectedFiles.forEach(f => delete f.status);
            renderFileList();

            // Upload sequentially
            for (let i = 0; i < selectedFiles.length; i++) {
                await uploadSingleFile(i);
            }

            isUploading = false;
            btn.disabled = false;
            btn.innerText = `Upload (${selectedFiles.length} file${selectedFiles.length !== 1 ? 's' : ''})`;
            // Optionally show final summary
            const successCount = selectedFiles.filter(f => f.status === 'success').length;
            const errorCount = selectedFiles.filter(f => f.status === 'error').length;
            if (successCount > 0 || errorCount > 0) {
                // alert(`Upload completed: ${successCount} succeeded, ${errorCount} failed.`);
                window.location.reload();
                if (successCount === selectedFiles.length) {
                } else {

                }
            }
        }

        function uploadSingleFile(index) {
            return new Promise((resolve, reject) => {
                const file = selectedFiles[index];
                if (!file) return resolve();
                file.status = 'uploading';
                renderFileList(); // re-render to show progress bars

                const xhr = new XMLHttpRequest();
                const formData = new FormData();
                formData.append('files[]', file);
                // Append campaign ID via route parameter; we'll use the URL from the form action
                const actionUrl = '{{ route("items.import", $campaign) }}';
                xhr.open('POST', actionUrl, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                // Progress event
                let startTime = Date.now();
                let lastLoaded = 0;
                xhr.upload.addEventListener('progress', (e) => {
                    if (e.lengthComputable) {
                        const percent = Math.round((e.loaded / e.total) * 100);
                        const progressBar = document.getElementById(`progress-bar-${index}`);
                        const percentSpan = document.getElementById(`progress-percent-${index}`);
                        if (progressBar) progressBar.style.width = `${percent}%`;
                        if (percentSpan) percentSpan.innerText = percent;

                        // Calculate speed and ETA
                        const now = Date.now();
                        const elapsed = (now - startTime) / 1000; // seconds
                        const speed = (e.loaded - lastLoaded) / elapsed; // bytes per second
                        lastLoaded = e.loaded;
                        startTime = now;
                        const speedKB = (speed / 1024).toFixed(2);
                        const speedSpan = document.getElementById(`speed-${index}`);
                        if (speedSpan) speedSpan.innerText = `${speedKB} KB/s`;

                        if (speed > 0) {
                            const remainingBytes = e.total - e.loaded;
                            const etaSec = remainingBytes / speed;
                            const etaSpan = document.getElementById(`eta-${index}`);
                            if (etaSpan) etaSpan.innerText = `ETA: ${etaSec.toFixed(1)}s`;
                        }
                    }
                });

                xhr.onload = () => {
                    if (xhr.status === 200 || xhr.status === 302) {
                        file.status = 'success';
                        renderFileList();
                        resolve();
                    } else {
                        let errorMsg = `HTTP ${xhr.status}`;
                        try {
                            const json = JSON.parse(xhr.responseText);
                            errorMsg = json.message || errorMsg;
                        } catch (e) { }
                        file.status = 'error';
                        file.errorMsg = errorMsg;
                        renderFileList();
                        const errorSpan = document.getElementById(`error-msg-${index}`);
                        if (errorSpan) errorSpan.innerText = errorMsg;
                        resolve(); // continue with next file
                    }
                };
                xhr.onerror = () => {
                    file.status = 'error';
                    file.errorMsg = 'Network error';
                    renderFileList();
                    resolve();
                };
                xhr.send(formData);
            });
        }

        // Close modal on outside click (optional)
        window.onclick = function (event) {
            const modal = document.getElementById('uploadModal');
            if (event.target === modal) closeUploadModal();
        }
        // ========================
        // Bulk Actions Dropdown & Select All
        // ========================
        document.addEventListener('DOMContentLoaded', function () {
            // --- Dropdown toggle logic ---
            const bulkBtn = document.getElementById('bulkActionsBtn');
            const bulkMenu = document.getElementById('bulkDropdownMenu');
            const bulkArrow = document.getElementById('bulkArrowIcon');

            if (bulkBtn && bulkMenu) {
                // Toggle dropdown when button is clicked
                bulkBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isHidden = bulkMenu.classList.contains('hidden');
                    if (isHidden) {
                        bulkMenu.classList.remove('hidden');
                        if (bulkArrow) bulkArrow.style.transform = 'rotate(180deg)';
                    } else {
                        bulkMenu.classList.add('hidden');
                        if (bulkArrow) bulkArrow.style.transform = 'rotate(0deg)';
                    }
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function (e) {
                    if (!bulkBtn.contains(e.target) && !bulkMenu.contains(e.target)) {
                        bulkMenu.classList.add('hidden');
                        if (bulkArrow) bulkArrow.style.transform = 'rotate(0deg)';
                    }
                });
            }

            // --- Select All logic (unify both checkboxes) ---
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const selectAllTable = document.getElementById('selectAllCheckboxTable');
            const selectAllDropdown = document.getElementById('selectAllCheckbox');

            function updateSelectAllCheckboxes() {
                const allChecked = checkboxes.length > 0 && Array.from(checkboxes).every(cb => cb.checked);
                if (selectAllTable) selectAllTable.checked = allChecked;
                if (selectAllDropdown) selectAllDropdown.checked = allChecked;
            }

            function setAllCheckboxes(checked) {
                checkboxes.forEach(cb => cb.checked = checked);
                updateSelectAllCheckboxes();
            }

            if (selectAllTable) {
                selectAllTable.addEventListener('change', (e) => setAllCheckboxes(e.target.checked));
            }
            if (selectAllDropdown) {
                selectAllDropdown.addEventListener('change', (e) => setAllCheckboxes(e.target.checked));
            }
            checkboxes.forEach(cb => cb.addEventListener('change', updateSelectAllCheckboxes));

            // Bulk update ALL campaign items (entire campaign)
            const bulkAllBtns = document.querySelectorAll('.bulk-all-status-btn');
            const totalItemsCount = {{ $totalItems }};

            bulkAllBtns.forEach(btn => {
                btn.addEventListener('click', async function (e) {
                    const status = this.getAttribute('data-all-status');
                    const confirmMsg = `⚠️ WARNING: You are about to update ALL ${totalItemsCount} items in this campaign to "${status}".\n\nThis action cannot be undone. Are you absolutely sure?`;

                    if (!confirm(confirmMsg)) return;

                    const formData = new FormData();
                    formData.append('status', status);

                    try {
                        const response = await fetch('{{ route("items.bulk-update-all", $campaign) }}', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: formData
                        });
                        const data = await response.json();
                        if (data.success) {
                            alert(`Successfully updated all ${totalItemsCount} items to "${status}".`);
                            window.location.reload();
                        } else {
                            alert('Error updating all items. Please try again.');
                        }
                    } catch (error) {
                        console.log(error);

                        alert('Network error. Please check your connection.');
                    }
                });
            });
            // --- Bulk Status Update logic ---
            const bulkStatusBtns = document.querySelectorAll('.bulk-status-btn');
            bulkStatusBtns.forEach(btn => {
                btn.addEventListener('click', async function (e) {
                    const status = this.getAttribute('data-status');
                    const selectedIds = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
                    if (selectedIds.length === 0) {
                        alert('Please select at least one item.');
                        return;
                    }
                    if (!confirm(`Update ${selectedIds.length} item(s) to "${status}"?`)) return;

                    const formData = new FormData();
                    formData.append('status', status);
                    selectedIds.forEach(id => formData.append('item_ids[]', id));

                    try {
                        const response = await fetch('{{ route("items.bulk-status", $campaign) }}', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: formData
                        });
                        const data = await response.json();
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('Error updating statuses.');
                        }
                    } catch (error) {
                        alert('Network error.');
                    }
                });
            });
        });

        // Toggle between Table and Cards view
        const toggleBtn = document.getElementById('toggleViewBtn');
        const tableView = document.getElementById('tableView');
        const cardsContainer = document.getElementById('cardsContainer');
        const tableViewIcon = document.getElementById('tableViewIcon');
        const cardViewIcon = document.getElementById('cardViewIcon');
        const viewModeText = document.getElementById('viewModeText');

        // Load saved preference
        const savedView = localStorage.getItem('measurements_view') || 'table';

        function setView(view) {
            if (view === 'cards') {
                tableView.classList.add('hidden');
                cardsContainer.classList.remove('hidden');
                cardsContainer.classList.add('grid');
                tableViewIcon.classList.add('hidden');
                cardViewIcon.classList.remove('hidden');
                viewModeText.innerText = 'Cards';
                localStorage.setItem('measurements_view', 'cards');
            } else {
                tableView.classList.remove('hidden');
                cardsContainer.classList.add('hidden');
                cardsContainer.classList.remove('grid');
                tableViewIcon.classList.remove('hidden');
                cardViewIcon.classList.add('hidden');
                viewModeText.innerText = 'Table';
                localStorage.setItem('measurements_view', 'table');
            }
        }

        toggleBtn.addEventListener('click', () => {
            const current = localStorage.getItem('measurements_view') === 'cards' ? 'table' : 'cards';
            setView(current);
        });

        // Initialize view on page load
        setView(savedView);
    </script>
@endpush
