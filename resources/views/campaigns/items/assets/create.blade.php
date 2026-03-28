@extends('layouts.app')

@section('title', 'Upload Image')

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-heading dark:text-white">Upload Image</h1>
                <p class="text-body dark:text-neutral-400 mt-1">
                    Campaign: {{ $campaign->title }}<br>
                    Measurement: {{ $item->shop->name }} - {{ $item->width }}x{{ $item->height }}
                </p>
            </div>

            <form action="{{ route('assets.store', [$campaign, $item]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-heading dark:text-white mb-1">Image Type <span
                            class="text-red-500">*</span></label>
                    <select name="type" id="type" required
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="before">Before Installation</option>
                        <option value="after">After Installation</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-heading dark:text-white mb-1">Image <span
                            class="text-red-500">*</span></label>
                    <input type="file" name="image" id="image" accept="image/*" required
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <p class="text-xs text-body mt-1">Max size: 10MB. Supported formats: JPG, PNG, GIF, etc.</p>
                </div>

                <div class="mb-6">
                    <label for="captured_at" class="block text-sm font-medium text-heading dark:text-white mb-1">Captured
                        Date/Time</label>
                    <input type="datetime-local" name="captured_at" id="captured_at" value="{{ old('captured_at') }}"
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('assets.index', [$campaign, $item]) }}"
                        class="px-4 py-2 text-sm font-medium text-heading bg-light border border-default rounded-base hover:bg-neutral-100 dark:hover:bg-neutral-800 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
