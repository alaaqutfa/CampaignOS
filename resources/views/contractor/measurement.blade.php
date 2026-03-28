@extends('layouts.app')

@section('title', 'Record Measurement')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Record Measurement</h1>
            <p class="mb-4"><strong>Campaign:</strong> {{ $item->campaign->title }}</p>
            <p class="mb-4"><strong>Shop:</strong> {{ $item->shop->name }} - {{ $item->shop->address }}</p>

            <form action="{{ route('contractor.measurement.store', $item) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="width" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Width</label>
                        <input type="number" step="0.01" name="width" id="width" required
                            value="{{ old('width', $item->width) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label for="height"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Height</label>
                        <input type="number" step="0.01" name="height" id="height" required
                            value="{{ old('height', $item->height) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit</label>
                        <select name="unit" id="unit" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                            <option value="cm" {{ old('unit', $item->unit) == 'cm' ? 'selected' : '' }}>cm</option>
                            <option value="inch" {{ old('unit', $item->unit) == 'inch' ? 'selected' : '' }}>inch</option>
                            <option value="pixel" {{ old('unit', $item->unit) == 'pixel' ? 'selected' : '' }}>pixel</option>
                        </select>
                    </div>
                    <div>
                        <label for="material"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Material</label>
                        <input type="text" name="material" id="material" required
                            value="{{ old('material', $item->material) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label for="quantity"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                        <input type="number" name="quantity" id="quantity" required
                            value="{{ old('quantity', $item->quantity) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div class="md:col-span-2">
                        <label for="text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Text
                            (optional)</label>
                        <textarea name="text" id="text" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">{{ old('text', $item->text) }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Before
                            Image</label>
                        <input type="file" name="image" id="image" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <a href="{{ route('contractor.dashboard') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save
                        Measurement</button>
                </div>
            </form>
        </div>
    </div>
@endsection
