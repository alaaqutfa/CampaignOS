@extends('layouts.app')

@section('title', 'Contractor Assignments')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Contractors</h1>
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Assigned Regions</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($contractors as $contractor)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $contractor->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $contractor->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $contractor->getRoleNames()->first() }}</td>
                    <td class="px-6 py-4">
                        @foreach($contractor->assignedRegions as $region)
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1 mb-1">
                                {{ $region->city->name }} - {{ $region->name }} ({{ $region->pivot->assignment_type }})
                            </span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <a href="{{ route('contractor-assignments.edit', $contractor) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">Edit Regions</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
