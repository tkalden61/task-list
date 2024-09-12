@extends('layout.app')

@section('title', 'the list of tasks')

@section('content')

    <div>
        <div>
            <a href="{{ route('tasks.create') }}">Create Task</a>
        </div>

        {{-- @if (count($tasks)) --}}
        @forelse($tasks as $task)
            <div>
                <a href="{{ route('tasks.show', ['task' => $task->id]) }}">{{ $task->title }}</a>
            </div>
        @empty
            No tasks found.
        @endforelse

        @if ($tasks->count())
            {{ $tasks->links() }}
        @endif

        {{-- @endif --}}
    </div>




@endsection
