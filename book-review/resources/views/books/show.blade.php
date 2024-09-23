@extends('layouts.app')

@section('content')
  <div class="mb-4">
    <h1 class="mb-2 text-2xl">{{ $book->title }}</h1>

    <div class="book-info">
      <div class="mb-4 text-lg font-semibold book-author">by {{ $book->author }}</div>
      <div class="flex items-center book-rating">
        <div class="mr-2 text-sm font-medium text-slate-700">
          {{-- {{ number_format($book->reviews_avg_rating, 1) }} --}}
          <x-star-rating :rating="$book->reviews_avg_rating" />
        </div>
        <span class="text-sm text-gray-500 book-review-count">
          {{ $book->reviews_count }} {{ Str::plural('review', 5) }}
        </span>
      </div>
    </div>
  </div>

  <div class="mb-4">
    <a href="{{ route('books.reviews.create', $book)}}" class="reset-link">
        Add a review!
    </a>
  </div>

  <div>
    <h2 class="mb-4 text-xl font-semibold">Reviews</h2>
    <ul>
      @forelse ($book->reviews as $review)
        <li class="mb-4 book-item">
          <div>
            <div class="flex items-center justify-between mb-2">
              <div class="font-semibold">
                {{-- {{ $review->rating }} --}}
                <x-star-rating :rating="$review->rating" />
              </div>
              <div class="book-review-count">
                {{ $review->created_at->format('M j, Y') }}</div>
            </div>
            <p class="text-gray-700">{{ $review->review }}</p>
          </div>
        </li>
      @empty
        <li class="mb-4">
          <div class="empty-book-item">
            <p class="text-lg font-semibold empty-text">No reviews yet</p>
          </div>
        </li>
      @endforelse
    </ul>
  </div>
@endsection
