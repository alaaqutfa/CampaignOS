@extends('layouts.app')

@section('title', 'My Subscriptions')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold  dark:text-white">Subscription History</h1>
            <a href="{{ route('company.subscriptions.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white  font-bold py-2 px-4 rounded">Request New Subscription</a>
        </div>

        @if($activeSubscription)
            <div class="bg-green-100 border border-green-400 text-green-700px-4 py-3 rounded mb-6">
                <strong>Active Subscription:</strong> {{ $activeSubscription->plan->name }}
                ({{ $activeSubscription->plan->billing_cycle }}) – Valid until
                {{ $activeSubscription->end_date ? $activeSubscription->end_date->format('Y-m-d') : 'Indefinite' }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Plan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Price
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Start
                            Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">End
                            Date</th>
                        <th class="px-6 py-3 text-right dark:text-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $sub)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap  dark:text-gray-200">
                                {{ $sub->plan->name }} ({{ $sub->plan->billing_cycle }})
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap  dark:text-gray-200">{{ $sub->plan->price }} $</td>
                            <td class="px-6 py-4 whitespace-nowrap  dark:text-gray-200">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $sub->status === 'active' ? 'green' : ($sub->status === 'pending' ? 'yellow' : 'red') }}-100 text-{{ $sub->status === 'active' ? 'green' : ($sub->status === 'pending' ? 'yellow' : 'red') }}-800">
                                    {{ ucfirst($sub->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap  dark:text-gray-200">
                                {{ $sub->start_date ? $sub->start_date->format('Y-m-d') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap  dark:text-gray-200">
                                {{ $sub->end_date ? $sub->end_date->format('Y-m-d') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('company.subscriptions.show', $sub) }}"
                                    class="text-blue-600 hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4  dark:text-gray-200">No subscriptions yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
