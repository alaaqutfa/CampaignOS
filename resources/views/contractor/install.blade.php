@extends('layouts.app')

@section('title', 'Record Installation')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Record Installation</h1>
            <p class="mb-4"><strong>Campaign:</strong> {{ $item->campaign->title }}</p>
            <p class="mb-4"><strong>Shop:</strong> {{ $item->shop->name }} - {{ $item->shop->address }}</p>

            <form action="{{ route('contractor.install.store', $item) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <div class="mt-2">
                        <label class="inline-flex items-center mr-4">
                            <input type="radio" name="status" value="installed" class="form-radio text-green-600" {{ old('status') == 'installed' ? 'checked' : '' }}>
                            <span class="ml-2">Installed</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="failed" class="form-radio text-red-600" {{ old('status') == 'failed' ? 'checked' : '' }}>
                            <span class="ml-2">Failed</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4" id="failure-reason-group" style="display: none;">
                    <label for="failure_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason
                        for Failure</label>
                    <textarea name="failure_reason" id="failure_reason" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">{{ old('failure_reason') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="before_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Before
                            Image</label>
                        <input type="file" name="before_image" id="before_image" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div>
                        <label for="after_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">After
                            Image</label>
                        <input type="file" name="after_image" id="after_image" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <a href="{{ route('contractor.dashboard') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">Cancel</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle failure reason field based on status selection
        const statusRadios = document.querySelectorAll('input[name="status"]');
        const failureGroup = document.getElementById('failure-reason-group');
        statusRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                failureGroup.style.display = this.value === 'failed' ? 'block' : 'none';
            });
        });
        // Initialize
        if (document.querySelector('input[name="status"]:checked')?.value === 'failed') {
            failureGroup.style.display = 'block';
        }
    </script>
@endsection
