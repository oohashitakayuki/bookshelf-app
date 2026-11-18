<?php

namespace App\Http\Controllers;

use App\Models\Book;

class RankingController extends Controller
{
    public function index()
    {
        $rankedBooks = Book::query()
            ->with('genres')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->has('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->orderBy('id')
            ->limit(10)
            ->get();

        return view('ranking.index', compact('rankedBooks'));
    }
}
