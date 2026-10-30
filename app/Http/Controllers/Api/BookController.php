<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with('genres')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->paginate(20);

        return BookResource::collection($books);
    }

    public function show(Book $book)
    {
        $book->load([
            'genres',
            'reviews.user',
        ]);

        $book->loadAvg('reviews', 'rating');
        $book->loadCount('reviews');

        return new BookResource($book);
    }

    public function store(Request $request)
    {
        $book = DB::transaction(function () use ($request) {
            $book = Book::create([
                'user_id' => $request->input('user_id'),
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'isbn' => $request->input('isbn'),
                'published_date' => $request->input('published_date'),
                'description' => $request->input('description'),
                'image_url' => $request->input('image_url'),
            ]);

            $genreIds = $request->input('genres', []);

            $book->genres()->sync($genreIds);

            $book->load('genres');

            return $book;
        });

        $book->loadAvg('reviews', 'rating');
        $book->loadCount('reviews');

        return (new BookResource($book))
            ->response()
            ->setStatusCode(201);
    }

    public function update(Request $request, Book $book)
    {
        DB::transaction(function () use ($request, $book) {
            $book->update([
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'isbn' => $request->input('isbn'),
                'published_date' => $request->input('published_date'),
                'description' => $request->input('description'),
                'image_url' => $request->input('image_url'),
            ]);

            $genreIds = $request->input('genres', []);

            $book->genres()->sync($genreIds);
        });

        $book->load('genres');
        $book->loadAvg('reviews', 'rating');
        $book->loadCount('reviews');

        return new BookResource($book);
    }
}
