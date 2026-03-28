@extends('layouts.app')

@section('title', 'Edit Campaign')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-heading dark:text-white">Edit Campaign</h1>
                <p class="text-body dark:text-neutral-400 mt-1">Update campaign details</p>
            </div>

            <form action="{{ route('campaigns.update', $campaign) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-heading dark:text-white mb-1">Campaign Title
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $campaign->title) }}" required
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Client Name -->
                <div class="mb-4">
                    <label for="client_name" class="block text-sm font-medium text-heading dark:text-white mb-1">Client
                        Name</label>
                    <input type="text" name="client_name" id="client_name"
                        value="{{ old('client_name', $campaign->client_name) }}"
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <!-- Location -->
                <div class="mb-4">
                    <label for="location"
                        class="block text-sm font-medium text-heading dark:text-white mb-1">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $campaign->location) }}"
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-heading dark:text-white mb-1">Status</label>
                    <select name="status" id="status"
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="draft" {{ old('status', $campaign->status) == 'draft' ? 'selected' : '' }}>Draft
                        </option>
                        <option value="active" {{ old('status', $campaign->status) == 'active' ? 'selected' : '' }}>Active
                        </option>
                        <option value="completed" {{ old('status', $campaign->status) == 'completed' ? 'selected' : '' }}>
                            Completed</option>
                        <option value="archived" {{ old('status', $campaign->status) == 'archived' ? 'selected' : '' }}>
                            Archived</option>
                    </select>
                </div>

                <!-- Priority -->
                <div class="mb-4">
                    <label for="priority"
                        class="block text-sm font-medium text-heading dark:text-white mb-1">Priority</label>
                    <select name="priority" id="priority"
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="low" {{ old('priority', $campaign->priority) == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', $campaign->priority) == 'medium' ? 'selected' : '' }}>Medium
                        </option>
                        <option value="high" {{ old('priority', $campaign->priority) == 'high' ? 'selected' : '' }}>High
                        </option>
                    </select>
                </div>

                <!-- Due Date -->
                <div class="mb-6">
                    <label for="due_date" class="block text-sm font-medium text-heading dark:text-white mb-1">Due
                        Date</label>
                    <input type="date" name="due_date" id="due_date"
                        value="{{ old('due_date', $campaign->due_date ? $campaign->due_date->format('Y-m-d') : '') }}"
                        class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('campaigns.index') }}"
                        class="px-4 py-2 text-sm font-medium text-heading bg-light border border-default rounded-base hover:bg-neutral-100 dark:hover:bg-neutral-800 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                        Update Campaign
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
