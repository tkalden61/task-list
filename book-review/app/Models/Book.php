<?php

namespace App\Models;

use DateRangeError;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function scopeTitle(Builder $query, String $title): Builder
    {
        return $query->where('title', 'LIKE', '%'. $title . '%');
    }

    public function scopeWithReviewsCount(Builder $query, $from = null, $to = null ): Builder | QueryBuilder
    {
        return $query->withCount([
            'reviews' => fn(Builder $q) => $this->DateRangeFilter($q, $from, $to)
        ]);
    }

    public function scopeWithAvgRating(Builder $query, $from = null, $to = null ): Builder | QueryBuilder
    {
        return $query->withAvg([
            'reviews' => fn(Builder $q) => $this->DateRangeFilter($q, $from, $to)
        ], 'rating');
    }

    public function scopePopular(Builder $query, $from = null, $to = null ): Builder | QueryBuilder
    {
        return $query->WithReviewsCount()
            ->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated(Builder $query, $from=null, $to=null): Builder | QueryBuilder {
        return $query->WithAvgRating()
            ->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeMinReviews(Builder $query, int $minReviews): Builder | QueryBuilder
    {
        return $query->having('reviews_count', '>=', $minReviews);
    }

    private function dateRangeFilter(Builder $query, $from = null, $to = null) {
        if($from && !$to) {
            $query->where('created_at', '>=', $from );
        }
        else if(!$from && $to) {
            $query->where('created_at', '<=', $to);
        }else if($from && $to ) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }

    public function scopePopularLastMonth(Builder $query): Builder {
        return $query->popular(now()->subMonth(), now())
            ->highestRated(now()->subMonth(), now())
            ->minReviews(2);
    }

    public function scopePopularLast6Months(Builder $query): Builder {
        return $query->popular(now()->subMonths(6), now())
            ->highestRated(now()->subMonths(6), now())
            ->minReviews(5);
    }

    public function scopeHighestRatedLastMonth(Builder $query): Builder {
        return $query->highestRated(now()->submonth(), now())
            ->popular(now()->subMonth(), now())
            ->minReviews(2);
    }

    public function scopeHighestRatedLast6Months(Builder $query): Builder {
        return $query->highestRated(now()->submonths(6), now())
            ->popular(now()->subMonths(6), now())
            ->minReviews(5);
    }

    protected static function booted()
    {
        static::updated(
            fn(Book $book) =>
                cache()->
                forget('book:' . $book->id)
            );
        static::deleted(
            fn(Book $book) =>
                cache()->
                forget('book:' . $book->id)
            );
    }

}

