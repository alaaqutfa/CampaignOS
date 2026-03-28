@extends('layouts.app')

@section('title', 'Subscription Details')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Subscription #{{ $subscription->id }}</h1>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div><strong>Company:</strong> {{ $subscription->company->name }}</div>
                <div><strong>Plan:</strong> {{ $subscription->plan->name }} ({{ $subscription->plan->billing_cycle }})</div>
                <div><strong>Price:</strong> {{ $subscription->plan->price }} SAR</div>
                <div><strong>Status:</strong> <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $subscription->status === 'active' ? 'green' : ($subscription->status === 'pending' ? 'yellow' : 'red') }}-100 text-{{ $subscription->status === 'active' ? 'green' : ($subscription->status === 'pending' ? 'yellow' : 'red') }}-800">{{ ucfirst($subscription->status) }}</span>
                </div>
                <div><strong>Start Date:</strong>
                    {{ $subscription->start_date ? $subscription->start_date->format('Y-m-d') : '-' }}</div>
                <div><strong>End Date:</strong>
                    {{ $subscription->end_date ? $subscription->end_date->format('Y-m-d') : '-' }}</div>
                <div><strong>Auto Renew:</strong> {{ $subscription->auto_renew ? 'Yes' : 'No' }}</div>
                <div><strong>Requested At:</strong> {{ $subscription->created_at->format('Y-m-d H:i') }}</div>
            </div>

            @if($subscription->status === 'pending')
                <form action="{{ route('super-admin.subscriptions.update', $subscription) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="active">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Activate
                        Subscription</button>
                </form>
            @endif

            <div class="mt-6">
                <a href="{{ route('super-admin.subscriptions.index') }}" class="text-blue-600 hover:underline">Back to
                    list</a>
            </div>
        </div>
    </div>
@endsection
