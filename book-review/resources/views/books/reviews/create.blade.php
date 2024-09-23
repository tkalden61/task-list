@extends('layouts.app')

@section('content')
    <h1 class="mb-10 text-2xl">Add Review for {{ $book->title }}</h1>

    <form method="POST" action="{{ route('books.reviews.store', $book) }}">
        @csrf
        <label for="review">Review</label>
        <textarea id="review" name="review" required class="mb-4 input"></textarea>

        <label for="rating">Rating</label>
        <select name="rating" id="rating" class="mb-4 input" required>
            <option value="">select a Rating</option>
            @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>

        <button type="submit" class="btn"> Add Review </button>
    </form>
@endsection
