@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Tasks</h1>
    @foreach($tasks as $task)
        <div>Campaign: {{ $task->campaign->title }} - Shop: {{ $task->shop->name }}</div>
        @if($task->status == 'pending')
            @if(auth()->user()->hasRole('measurer'))
                <a href="{{ route('contractor.measurement', $task) }}">Start Measurement</a>
            @elseif(auth()->user()->hasRole('installer') && $task->status == 'printed')
                <a href="{{ route('contractor.install', $task) }}">Start Installation</a>
            @endif
        @endif
    @endforeach
</div>
@endsection
