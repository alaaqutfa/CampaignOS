@extends('layouts.app')

@section('title', 'Add Measurement')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-heading dark:text-white">Add Measurement</h1>
                <p class="text-body dark:text-neutral-400 mt-1">Campaign: {{ $campaign->title }}</p>
            </div>

            <form action="{{ route('items.store', $campaign) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="shop_id" class="block text-sm font-medium text-heading dark:text-white mb-1">Shop <span
                            class="text-red-500">*</span></label>
                    <select name="shop_id" id="shop_id" required
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Select a shop</option>
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}" {{ old('shop_id') == $shop->id ? 'selected' : '' }}>
                                {{ $shop->name }} ({{ $shop->city->name ?? 'No city' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="assigned_measurer_id" class="block text-sm font-medium text-heading dark:text-white mb-1">Assigned Measurer</label>
                        <select name="assigned_measurer_id" id="assigned_measurer_id"
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">None</option>
                            @foreach($measurers as $measurer)
                                <option value="{{ $measurer->id }}" {{ old('assigned_measurer_id') == $measurer->id ? 'selected' : '' }}>
                                    {{ $measurer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="assigned_installer_id" class="block text-sm font-medium text-heading dark:text-white mb-1">Assigned Installer</label>
                        <select name="assigned_installer_id" id="assigned_installer_id"
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">None</option>
                            @foreach($installers as $installer)
                                <option value="{{ $installer->id }}" {{ old('assigned_installer_id') == $installer->id ? 'selected' : '' }}>
                                    {{ $installer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="material" class="block text-sm font-medium text-heading dark:text-white mb-1">Material
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="material" id="material" value="{{ old('material') }}" required
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-heading dark:text-white mb-1">Quantity
                            <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" required min="1"
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="width" class="block text-sm font-medium text-heading dark:text-white mb-1">Width <span
                                class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="width" id="width" value="{{ old('width') }}" required
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="height" class="block text-sm font-medium text-heading dark:text-white mb-1">Height <span
                                class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="height" id="height" value="{{ old('height') }}" required
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="unit" class="block text-sm font-medium text-heading dark:text-white mb-1">Unit <span
                                class="text-red-500">*</span></label>
                        <select name="unit" id="unit" required
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="cm" {{ old('unit') == 'cm' ? 'selected' : '' }}>cm</option>
                            <option value="inch" {{ old('unit') == 'inch' ? 'selected' : '' }}>inch</option>
                            <option value="pixel" {{ old('unit') == 'pixel' ? 'selected' : '' }}>pixel</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="text" class="block text-sm font-medium text-heading dark:text-white mb-1">Text
                        (Arabic)</label>
                    <input type="text" name="text" id="text" value="{{ old('text') }}"
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-heading dark:text-white mb-1">Notes</label>
                    <textarea name="notes" id="notes" rows="2"
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('notes') }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('campaigns.show', $campaign) }}"
                        class="px-4 py-2 text-sm font-medium text-heading bg-light border border-default rounded-base hover:bg-neutral-100 dark:hover:bg-neutral-800 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                        Save Measurement
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
