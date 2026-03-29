@extends('layouts.app')

@section('title', 'Assign Regions to ' . $contractor->name)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Assign Regions to {{ $contractor->name }}</h1>
    <form action="{{ route('contractor-assignments.update', $contractor) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Regions</label>
                <div class="space-y-2">
                    @foreach($regions as $region)
                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="regions[]" value="{{ $region->id }}"
                                    {{ in_array($region->id, $assignedRegions) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $region->city->name }} - {{ $region->name }}</span>
                            </label>
                            <select name="assignment_types[{{ $region->id }}]" class="ml-4 text-sm border-gray-300 rounded-md">
                                <option value="measure" {{ ($assignmentTypes[$region->id] ?? '') == 'measure' ? 'selected' : '' }}>Measure</option>
                                <option value="install" {{ ($assignmentTypes[$region->id] ?? '') == 'install' ? 'selected' : '' }}>Install</option>
                                <option value="both" {{ ($assignmentTypes[$region->id] ?? '') == 'both' ? 'selected' : '' }}>Both</option>
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-end">
                <a href="{{ route('contractor-assignments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">Cancel</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save Assignments</button>
            </div>
        </div>
    </form>
</div>
@endsection
