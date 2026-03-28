@extends('layouts.app')

@section('title', 'Plans')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-heading dark:text-white">Plans</h1>
                <p class="text-body dark:text-gray-400 mt-1">Manage subscription plans for companies</p>
            </div>
            <a href="{{ route('super-admin.plans.create') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-base text-white bg-primary-600 hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Plan
            </a>
        </div>

        <!-- Plans Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($plans as $plan)
                <div
                    class="bg-light dark:bg-dark rounded-base shadow-xs border border-default overflow-hidden hover:shadow-md transition">
                    <!-- Plan Header -->
                    <div class="p-5 border-b border-default">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-heading dark:text-white">{{ $plan->name }}</h3>
                                <p class="text-sm text-body dark:text-white mt-1">
                                    {{ $plan->billing_cycle === 'monthly' ? 'Monthly' : 'Yearly' }} billing
                                </p>
                            </div>
                            <span
                                class="px-2 py-1 text-xs font-medium rounded-full {{ $plan->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                                {{ $plan->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div class="mt-3">
                            <span
                                class="text-3xl font-bold text-heading dark:text-white">${{ number_format($plan->price, 2) }}</span>
                            <span class="text-body dark:text-white">/{{ $plan->billing_cycle === 'monthly' ? 'month' : 'year' }}</span>
                        </div>
                    </div>

                    <!-- Plan Details -->
                    <div class="p-5 space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-body dark:text-white">User limit</span>
                            <span class="font-medium text-heading dark:text-white">{{ $plan->user_limit ?: 'Unlimited' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-body dark:text-white">Campaign limit</span>
                            <span
                                class="font-medium text-heading dark:text-white">{{ $plan->campaign_limit ?: 'Unlimited' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-body dark:text-white">Storage limit</span>
                            <span
                                class="font-medium text-heading dark:text-white">{{ $plan->storage_limit ? $plan->storage_limit . ' MB' : 'Unlimited' }}</span>
                        </div>

                        @if($plan->features && count($plan->features) > 0)
                            <div class="pt-3">
                                <p class="text-sm font-medium text-heading dark:text-white mb-2">Features</p>
                                <ul class="space-y-1">
                                    @foreach($plan->features as $feature)
                                        <li class="flex items-center text-sm text-body dark:text-white">
                                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="p-5 border-t border-default flex justify-between">
                        <a href="{{ route('super-admin.plans.edit', $plan) }}"
                            class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 transition">
                            Edit
                        </a>
                        <button type="button" data-modal-target="delete-modal-{{ $plan->id }}"
                            data-modal-toggle="delete-modal-{{ $plan->id }}"
                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition">
                            Delete
                        </button>
                    </div>

                    <!-- Delete Modal -->
                    <div id="delete-modal-{{ $plan->id }}" tabindex="-1"
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
                                        delete "{{ $plan->name }}"?</h3>
                                    <form action="{{ route('super-admin.plans.destroy', $plan) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-base text-sm inline-flex items-center px-5 py-2.5 text-center">
                                            Yes, delete
                                        </button>
                                    </form>
                                    <button data-modal-hide="delete-modal-{{ $plan->id }}" type="button"
                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-heading focus:outline-none bg-light rounded-base border border-default hover:bg-neutral-100 dark:hover:bg-neutral-800 focus:z-10 focus:ring-4 focus:ring-neutral-300 dark:focus:ring-neutral-700">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-body">
                    No plans found.
                    <a href="{{ route('super-admin.plans.create') }}"
                        class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 underline">Create
                        one</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($plans->hasPages())
            <div class="mt-6">
                {{ $plans->links() }}
            </div>
        @endif
    </div>
@endsection
