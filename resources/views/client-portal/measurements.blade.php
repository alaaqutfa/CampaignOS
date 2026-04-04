@extends('landing.app')

@section('title', 'Measurements')

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    {{-- <style>
        /* تخصيص المظهر ليتناسب مع الدارك مود */
        .select2-container--bootstrap-5 .select2-selection {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
            color: #f3f4f6 !important;
        }

        .dark .select2-dropdown {
            background-color: #1f2937;
            border-color: #374151;
        }

        .dark .select2-results__option {
            color: #f3f4f6;
        }

        .dark .select2-results__option--highlighted {
            background-color: #3b82f6;
        }

        html.dark .select2-search__field {
            background-color: #374151;
            border-color: #4b5563;
            color: white;
        }
    </style> --}}
@endpush

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8 dark:text-white">
        <div class="mb-6">
            <a href="{{ route('client.campaigns', $client->access_token) }}"
                class="text-blue-600 hover:underline inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7" stroke="currentColor" />
                </svg> Back to campaigns
            </a>
            <h1 class="text-2xl font-bold mt-2">
                @if($campaign)
                    {{ $campaign->title }} – Measurements
                @else
                    All Measurements
                @endif
            </h1>
        </div>

        <!-- Filter Bar with Select2 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
            <form method="GET" action="{{ route('client.measurements', $client->access_token) }}"
                class="flex flex-wrap gap-3 items-end">
                <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">

                <!-- City Filter -->
                <div class="flex-1 min-w-[180px] dark:text-white">
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">City</label>
                    <select name="city_id" id="city-select" class="w-full">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Shop Filter -->
                <div class="flex-1 min-w-[180px] dark:text-white">
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Shop</label>
                    <select name="shop_id" id="shop-select" class="w-full">
                        <option value="">All Shops</option>
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}" {{ request('shop_id') == $shop->id ? 'selected' : '' }}>
                                {{ $shop->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter (no search needed) -->
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Status</label>
                    <select name="status" class="w-full border rounded px-3 py-2 dark:bg-gray-700">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
                    <a href="{{ route('client.measurements', [$client->access_token, 'campaign_id' => $campaign->id]) }}"
                        class="ml-2 text-gray-600 dark:text-gray-400 hover:underline">Reset</a>
                </div>
            </form>
        </div>

        @if($items->isEmpty())
            <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-xl shadow">No measurements found for this campaign.
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($items as $item)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-default overflow-hidden">
                        <div class="p-4 border-b bg-gray-50 dark:bg-gray-700/50">
                            <h3 class="font-bold">{{ $item->shop->name }} -
                                {{ $item->shop->region->name }},{{ $item->shop->city->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $item->material }} | {{ $item->width }}x{{ $item->height }} cm |
                                Qty: {{ $item->quantity }}</p>
                        </div>
                        <div class="p-4">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <!-- Before Image -->
                                <div class="flex-1 text-center">
                                    <div class="text-sm font-medium text-gray-600 dark:text-gray-100 mb-2">Before Installation</div>
                                    @php $before = $item->assets->where('type', 'before')->first(); @endphp
                                    @if($before)
                                        <img src="{{ asset('storage/' . $before->file_path) }}"
                                            class="w-full h-48 object-cover rounded-lg border shadow-sm" alt="Before">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                            No image</div>
                                    @endif
                                </div>
                                <!-- After Image -->
                                <div class="flex-1 text-center">
                                    <div class="text-sm font-medium text-gray-600 dark:text-gray-100 mb-2">After Installation</div>
                                    @php $after = $item->assets->where('type', 'after')->first(); @endphp
                                    @if($after)
                                        <img src="{{ asset('storage/' . $after->file_path) }}"
                                            class="w-full h-48 object-cover rounded-lg border shadow-sm" alt="After">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                            Not yet installed</div>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-3 text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                                                                    @if($item->status === 'installed') bg-green-100 text-green-800
                                                                                                    @elseif($item->status === 'rejected') bg-red-100 text-red-800
                                                                                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $items->links() }}</div>
        @endif
    </div>
@endsection

@push('scripts')
    <!-- jQuery first, then Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize Select2 for city and shop selects
            $('#city-select, #shop-select').select2({
                theme: 'bootstrap-5',
                width: 'resolve',
                placeholder: 'Search...',
                allowClear: true,
                dropdownAutoWidth: true
            });

            // Force re-evaluation of width after initialization
            $('#city-select, #shop-select').on('select2:open', function () {
                setTimeout(() => {
                    document.querySelectorAll('.select2-container').forEach(el => el.style.width = '100%');
                }, 10);
            });
        });
    </script>
@endpush
