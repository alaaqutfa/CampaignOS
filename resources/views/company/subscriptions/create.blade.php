@extends('layouts.app')

@section('title', 'Request Subscription')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Request a New Subscription</h1>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form action="{{ route('company.subscriptions.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Choose a Plan</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($plans as $plan)
                            <label class="border rounded-lg p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                <input type="radio" name="plan_id" value="{{ $plan->id }}" class="mr-2" required>
                                <strong>{{ $plan->name }}</strong> – {{ $plan->price }} $ / {{ $plan->billing_cycle }}
                                @if($plan->features)
                                    <ul class="text-sm text-gray-500 mt-1">
                                        @foreach($plan->features as $feature)
                                            <li>• {{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </label>
                        @endforeach
                    </div>
                    @error('plan_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('company.subscriptions.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">Cancel</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
@endsection
