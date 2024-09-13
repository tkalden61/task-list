@extends('layout.app')

@section('title', $task->title)


@section('content')
    <div class="mb-4">
        <a href="{{ route('tasks.index') }}" class="link"> ← Go back to the task list!</a>
    </div>
    <p class="mb-4 text-slate-700">{{ $task->description }}</p>

    @if ($task->long_description)
        <p class="mb-4 text-slate-700">{{ $task->long_description }}</p>
    @endif

    <p class="mb-4 text-sm text-slate-500">created {{ $task->created_at->diffForHumans() }} · updated {{ $task->updated_at->diffForHumans() }}</p>

    @if($task->completed)
        <span class="font-medium text-green-500">completed</span>
    @else
        <span class="font-medium text-red-500">not completed</span>
    @endif

    <div class="flex gap-2 mt-4">
        <a href="{{ route('tasks.edit', ['task' => $task]) }}"
            class="btn">Edit </a>

        <form method="Post" action="{{ route('tasks.toggle-completed', ['task' => $task]) }}">
            @csrf
            @method('put')
            <button type="submit" class="btn">
                Mark as {{ $task->completed ? 'not completed' : 'completed' }}
            </button>
        </form>


        <form action="{{ route('tasks.destroy', ['task' => $task]) }}" method="Post">
            @csrf
            @method('delete')
            <button type="submit" class="btn">Delete Task</button>
        </form>
    </div>

@endsection
