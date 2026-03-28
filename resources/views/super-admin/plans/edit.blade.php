@extends('layouts.app')

@section('title', 'Edit Plan')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-heading dark:text-white">Edit Plan</h1>
                <p class="text-body dark:text-gray-400 mt-1">Update subscription plan details</p>
            </div>

            <form action="{{ route('super-admin.plans.update', $plan) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-heading dark:text-white mb-1">Plan Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}" required
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price and Billing Cycle -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-heading dark:text-white mb-1">Price <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-body">$</span>
                            <input type="number" name="price" id="price" value="{{ old('price', $plan->price) }}"
                                step="0.01" min="0" required
                                class="w-full pl-7 pr-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('price') border-red-500 @enderror">
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="billing_cycle"
                            class="block text-sm font-medium text-heading dark:text-white mb-1">Billing Cycle <span
                                class="text-red-500">*</span></label>
                        <select name="billing_cycle" id="billing_cycle" required
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('billing_cycle') border-red-500 @enderror">
                            <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ old('billing_cycle', $plan->billing_cycle) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                        @error('billing_cycle')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Limits -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="user_limit" class="block text-sm font-medium text-heading dark:text-white mb-1">User
                            Limit</label>
                        <input type="number" name="user_limit" id="user_limit"
                            value="{{ old('user_limit', $plan->user_limit) }}" min="0"
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <p class="mt-1 text-xs text-body">Leave empty for unlimited</p>
                    </div>
                    <div>
                        <label for="campaign_limit"
                            class="block text-sm font-medium text-heading dark:text-white mb-1">Campaign Limit</label>
                        <input type="number" name="campaign_limit" id="campaign_limit"
                            value="{{ old('campaign_limit', $plan->campaign_limit) }}" min="0"
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <p class="mt-1 text-xs text-body">Leave empty for unlimited</p>
                    </div>
                    <div>
                        <label for="storage_limit"
                            class="block text-sm font-medium text-heading dark:text-white mb-1">Storage Limit (MB)</label>
                        <input type="number" name="storage_limit" id="storage_limit"
                            value="{{ old('storage_limit', $plan->storage_limit) }}" min="0"
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <p class="mt-1 text-xs text-body">Leave empty for unlimited</p>
                    </div>
                </div>

                <!-- Features -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-heading dark:text-white mb-1">Features</label>
                    <div id="features-container" class="space-y-2">
                        @php $features = old('features', $plan->features ?? []); @endphp
                        @if(count($features))
                            @foreach($features as $index => $feature)
                                <div class="flex items-center gap-2 feature-item">
                                    <input type="text" name="features[]" value="{{ $feature }}"
                                        class="flex-1 px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="Enter feature">
                                    <button type="button"
                                        class="remove-feature text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center gap-2 feature-item">
                                <input type="text" name="features[]"
                                    class="flex-1 px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="Enter feature">
                                <button type="button"
                                    class="remove-feature text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-feature"
                        class="mt-2 text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Feature
                    </button>
                    @error('features')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Popular Status -->
                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_popular" value="1" {{ old('is_popular', $plan->is_popular) ? 'checked' : '' }} class="rounded border-default text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-heading dark:text-white">Popular</span>
                    </label>
                </div>

                <!-- Active Status -->
                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }} class="rounded border-default text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-heading dark:text-white">Active</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('super-admin.plans.index') }}"
                        class="px-4 py-2 text-sm font-medium text-heading bg-light border border-default rounded-base hover:bg-neutral-100 dark:hover:bg-neutral-800 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                        Update Plan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('add-feature').addEventListener('click', function () {
                const container = document.getElementById('features-container');
                const newItem = document.createElement('div');
                newItem.className = 'flex items-center gap-2 feature-item';
                newItem.innerHTML = `
                    <input type="text" name="features[]" class="flex-1 px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Enter feature">
                    <button type="button" class="remove-feature text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                `;
                container.appendChild(newItem);
                attachRemoveEvent(newItem.querySelector('.remove-feature'));
            });

            function attachRemoveEvent(button) {
                button.addEventListener('click', function () {
                    this.closest('.feature-item').remove();
                });
            }

            document.querySelectorAll('.remove-feature').forEach(btn => {
                attachRemoveEvent(btn);
            });
        </script>
    @endpush
@endsection
