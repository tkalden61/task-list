@extends('layout.app')

@section('title', $task->title)


@section('content')
    <p>{{ $task->description }}</p>

    @if ($task->long_description)
        <p>{{ $task->long_description }}</p>
    @endif

    <p>{{ $task->created_at }}</p>
    <p>{{ $task->updated_at }}</p>

    <div>
        <a href="{{ route('tasks.edit', ['task' => $task]) }}">Edit </a>
    </div>

    <div>
        <form method="Post" action="{{ route('tasks.toggle-completed', ['task' => $task]) }}">
            @csrf
            @method('put')
            <button type="submit">
                Mark as {{ $task->completed ? 'not completed' : 'completed' }}
            </button>
        </form>
    </div>

    <form action="{{ route('tasks.destroy', ['task' => $task]) }}" method="Post">
        @csrf
        @method('delete')
        <button type="submit">Delete Task</button>
    </form>

@endsection
