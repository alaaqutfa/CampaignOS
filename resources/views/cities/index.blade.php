@extends('layouts.app')

@section('title', 'Cities')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-heading dark:text-white">Cities</h1>
                <p class="text-body dark:text-neutral-400 mt-1">Manage cities for your company</p>
            </div>
            <button data-modal-target="add-city-modal" data-modal-toggle="add-city-modal"
                class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 transition">
                + Add City
            </button>
        </div>

        <div class="bg-light dark:bg-dark rounded-base shadow-xs border border-default overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-default">
                    <thead class="bg-neutral-50 dark:bg-neutral-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-body dark:text-white uppercase tracking-wider">Shops
                                Count</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-body dark:text-white uppercase tracking-wider">Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-light dark:bg-dark divide-y divide-default">
                        @forelse($cities as $city)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-heading dark:text-white">
                                    {{ $city->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-body dark:text-white">
                                    {{ $city->shops_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <button data-modal-target="edit-city-modal-{{ $city->id }}"
                                        data-modal-toggle="edit-city-modal-{{ $city->id }}"
                                        class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 mr-3">
                                        Edit
                                    </button>
                                    <button type="button" data-modal-target="delete-city-modal-{{ $city->id }}"
                                        data-modal-toggle="delete-city-modal-{{ $city->id }}"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-body">
                                    No cities found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Add City Modal --}}
    <div id="add-city-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-light dark:bg-dark rounded-base shadow border border-default">
                <div class="flex items-center justify-between p-5 border-b border-default rounded-t">
                    <h3 class="text-lg font-semibold text-heading dark:text-white">Add New City</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="add-city-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('cities.store') }}" method="POST">
                    @csrf
                    <div class="p-5">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-heading dark:text-white mb-1">City Name
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" required
                                class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                    </div>
                    <div class="flex items-center justify-end p-5 border-t border-default rounded-b">
                        <button data-modal-hide="add-city-modal" type="button"
                            class="px-4 py-2 text-sm font-medium text-heading bg-light border border-default rounded-base hover:bg-neutral-100 dark:hover:bg-neutral-800 mr-2">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit & Delete Modals (لازم نسوي لكل مدينة) --}}
    @foreach($cities as $city)
        <div id="edit-city-modal-{{ $city->id }}" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <div class="relative bg-light dark:bg-dark rounded-base shadow border border-default">
                    <div class="flex items-center justify-between p-5 border-b border-default rounded-t">
                        <h3 class="text-lg font-semibold text-heading dark:text-white">Edit City</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="edit-city-modal-{{ $city->id }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('cities.update', $city) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="p-5">
                            <div class="mb-4">
                                <label for="name-{{ $city->id }}"
                                    class="block text-sm font-medium text-heading dark:text-white mb-1">City Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name-{{ $city->id }}" value="{{ $city->name }}" required
                                    class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                        </div>
                        <div class="flex items-center justify-end p-5 border-t border-default rounded-b">
                            <button data-modal-hide="edit-city-modal-{{ $city->id }}" type="button"
                                class="px-4 py-2 text-sm font-medium text-heading bg-light border border-default rounded-base hover:bg-neutral-100 dark:hover:bg-neutral-800 mr-2">Cancel</button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="delete-city-modal-{{ $city->id }}" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <div class="relative bg-light dark:bg-dark rounded-base shadow border border-default">
                    <div class="p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-heading dark:text-white">Are you sure you want to delete
                            "{{ $city->name }}"?</h3>
                        <form action="{{ route('cities.destroy', $city) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-base text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, delete
                            </button>
                        </form>
                        <button data-modal-hide="delete-city-modal-{{ $city->id }}" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-heading focus:outline-none bg-light rounded-base border border-default hover:bg-neutral-100 dark:hover:bg-neutral-800">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
