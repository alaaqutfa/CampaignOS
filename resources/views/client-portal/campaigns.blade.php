@extends('landing.app')

@section('title', 'My Campaigns')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-primary-600 to-accent-400 bg-clip-text text-transparent">
                Welcome, {{ $client->name }}</h1>
            <p class="text-gray-500 mt-2">Select a campaign to view your measurements</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($campaigns as $campaign)
                <a href="{{ route('client.measurements', ['token' => $client->access_token, 'campaign_id' => $campaign->id]) }}"
                    class="block group">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-default overflow-hidden hover:shadow-lg transition hover:border-primary-300">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-semibold text-heading dark:text-white group-hover:text-primary-600">
                                    {{ $campaign->title }}</h2>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 5l7 7-7 7" stroke="currentColor" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">{{ $campaign->client_name ?? $client->name }}</p>
                            @if($campaign->due_date)
                                <p class="text-xs text-gray-400 mt-1">Due:
                            {{ \Carbon\Carbon::parse($campaign->due_date)->format('M d, Y') }}</p>@endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">No campaigns available at this time.</div>
            @endforelse
        </div>
    </div>
@endsection
