@extends('layouts.app')

@section('title', 'Subscriptions')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Subscription Requests</h1>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Company</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Plan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Requested At</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($subscriptions as $sub)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $sub->company->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $sub->plan->name }} ({{ $sub->plan->billing_cycle }})
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $sub->status === 'active' ? 'green' : ($sub->status === 'pending' ? 'yellow' : 'red') }}-100 text-{{ $sub->status === 'active' ? 'green' : ($sub->status === 'pending' ? 'yellow' : 'red') }}-800">
                                    {{ ucfirst($sub->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $sub->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('super-admin.subscriptions.show', $sub) }}"
                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-3">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $subscriptions->links() }}
    </div>
@endsection
