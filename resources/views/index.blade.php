@extends('layout.app')

@section('title', 'the list of tasks')

@section('content')

    <div>
        <nav class="mb-4">
            <a href="{{ route('tasks.create') }}" class="link">Create Task</a>
        </nav>

        {{-- @if (count($tasks)) --}}
        @forelse($tasks as $task)
            <div>
                <a  href="{{ route('tasks.show', ['task' => $task->id]) }}"
                    @class(['font-bold', 'line-through' => $task->completed])>{{ $task->title }}</a>
            </div>
        @empty
            No tasks found.
        @endforelse

        @if ($tasks->count())
            <nav class="mt-4">
                {{ $tasks->links() }}
            </nav>
        @endif

        {{-- @endif --}}
    </div>




@endsection
