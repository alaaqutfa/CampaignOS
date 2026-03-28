@extends('layouts.app')

@section('title', 'Measurement Images')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-heading dark:text-white">Measurement Images</h1>
                <p class="text-body dark:text-neutral-400 mt-1">
                    Campaign: <a href="{{ route('campaigns.show', $campaign) }}"
                        class="text-primary-600 hover:underline">{{ $campaign->title }}</a><br>
                    Shop: {{ $item->shop->name }} - Dimensions: {{ $item->width }}x{{ $item->height }} {{ $item->unit }}
                </p>
            </div>
            <div>
                <a href="{{ route('assets.create', [$campaign, $item]) }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 transition">
                    + Upload Image
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($item->assets as $asset)
                <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default overflow-hidden">
                    <div class="relative">
                        <img src="{{ Storage::url($asset->file_path) }}" alt="Measurement Image"
                            class="w-full h-64 object-cover">
                        <div class="absolute top-2 left-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($asset->type === 'before') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                    @else bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 @endif">
                                {{ ucfirst($asset->type) }}
                            </span>
                        </div>
                        <div class="absolute top-2 right-2">
                            <button type="button" data-modal-target="delete-asset-modal-{{ $asset->id }}"
                                data-modal-toggle="delete-asset-modal-{{ $asset->id }}"
                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 bg-light dark:bg-dark rounded-full p-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-body">Uploaded by: {{ $asset->uploadedBy->name }}</p>
                        <p class="text-sm text-body">Captured at:
                            {{ $asset->captured_at ? $asset->captured_at->format('M d, Y H:i') : '—' }}</p>
                        <p class="text-sm text-body">Size: {{ number_format($asset->size / 1024, 2) }} KB</p>
                    </div>
                </div>

                {{-- Delete Asset Modal --}}
                <div id="delete-asset-modal-{{ $asset->id }}" tabindex="-1"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                        <div class="relative bg-light dark:bg-dark rounded-base shadow border border-default">
                            <div class="p-5 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-heading dark:text-white">Are you sure you want to
                                    delete this image?</h3>
                                <form action="{{ route('assets.destroy', [$campaign, $item, $asset]) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-base text-sm inline-flex items-center px-5 py-2.5 text-center">
                                        Yes, delete
                                    </button>
                                </form>
                                <button data-modal-hide="delete-asset-modal-{{ $asset->id }}" type="button"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-heading focus:outline-none bg-light rounded-base border border-default hover:bg-neutral-100 dark:hover:bg-neutral-800">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($item->assets->count() === 0)
            <div class="text-center py-12 bg-light dark:bg-dark rounded-base border border-default">
                <p class="text-body">No images uploaded yet.</p>
                <a href="{{ route('assets.create', [$campaign, $item]) }}"
                    class="text-primary-600 hover:underline">Upload first image</a>
            </div>
        @endif
    </div>
@endsection
