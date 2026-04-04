@extends('layouts.app')

@section('title', 'Clients')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1
                    class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-accent-400 bg-clip-text text-transparent">
                    Clients
                </h1>
                <p class="text-body dark:text-neutral-400 mt-1">Manage your clients and their portal access</p>
            </div>
            <a href="{{ route('clients.create') }}"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-base hover:bg-blue-700 transition shadow-sm inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Client
            </a>
        </div>

        <!-- Stats Cards -->
        @php
            $total = $clients->count();
            $withEmail = $clients->filter(fn($c) => $c->email)->count();
            $withPhone = $clients->filter(fn($c) => $c->phone)->count();
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-dark rounded-xl shadow-sm border border-default p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Total Clients</p>
                        <p class="text-2xl font-bold dark:text-white">{{ $total }}</p>
                    </div>
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-full"><svg
                            class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                stroke="currentColor" />
                        </svg></div>
                </div>
            </div>
            <div class="bg-white dark:bg-dark rounded-xl shadow-sm border border-default p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">With Email</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $withEmail }}</p>
                    </div>
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-full"><svg class="w-5 h-5 text-blue-600"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                stroke="currentColor" />
                        </svg></div>
                </div>
            </div>
            <div class="bg-white dark:bg-dark rounded-xl shadow-sm border border-default p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">With Phone</p>
                        <p class="text-2xl font-bold text-green-600">{{ $withPhone }}</p>
                    </div>
                    <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-full"><svg class="w-5 h-5 text-green-600"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                stroke="currentColor" />
                        </svg></div>
                </div>
            </div>
        </div>

        <!-- Clients Grid (Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($clients as $client)
                <div
                    class="bg-white dark:bg-dark rounded-xl shadow-md border border-default overflow-hidden hover:shadow-lg transition">
                    <div
                        class="p-5 border-b border-default bg-gradient-to-r from-blue-50 to-transparent dark:from-blue-900/20">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg text-heading dark:text-white">{{ $client->name }}</h3>
                                @if($client->email)
                                <p class="text-sm text-gray-500">{{ $client->email }}</p>@endif
                            </div>
                            <span
                                class="px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-700">
                                {{ $client->campaigns_count ?? 0 }}
                                campaigns
                            </span>
                        </div>
                    </div>
                    <div class="p-5 space-y-3">
                        @if($client->phone)
                            <div class="flex items-center gap-2 text-sm"><svg class="w-4 h-4 text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                        stroke="currentColor" />
                        </svg><span>{{ $client->phone }}</span></div>@endif
                        @if($client->address)
                            <div class="flex items-center gap-2 text-sm"><svg class="w-4 h-4 text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                        stroke="currentColor" />
                                    <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke="currentColor" />
                        </svg><span class="truncate">{{ $client->address }}</span></div>@endif
                        <div class="pt-2 flex justify-between items-center">
                            <a href="{{ route('client.campaigns', $client->access_token) }}" target="_blank"
                                class="text-blue-600 hover:text-blue-800 text-sm inline-flex items-center gap-1">Portal
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                        stroke="currentColor" />
                                </svg></a>
                            <div class="flex gap-3">
                                <a href="{{ route('clients.edit', $client) }}"
                                    class="text-blue-600 hover:text-blue-800">Edit</a>
                                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Delete this client?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">No clients yet. <a
                        href="{{ route('clients.create') }}" class="text-blue-600 underline">Add one</a></div>
            @endforelse
        </div>
    </div>
@endsection
