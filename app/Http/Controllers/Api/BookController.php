<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BookIndexRequest;
use App\Http\Requests\Api\StoreBookRequest;
use App\Http\Requests\Api\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(BookIndexRequest $request)
    {
        $validated = $request->validated();

        $query = Book::with('genres')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if (!empty($validated['keyword'])) {
            $keyword = $validated['keyword'];

            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('author', 'like', "%{$keyword}%");
            });
        }

        if (!empty($validated['genre'])) {
            $genreId = $validated['genre'];

            $query->whereHas('genres', function ($q) use ($genreId) {
                $q->where('genres.id', $genreId);
            });
        }

        $query->latest();

        $perPage = $validated['per_page'] ?? 10;

        $books = $query
            ->paginate($perPage)
            ->withQueryString();

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

    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        $book = DB::transaction(function () use ($validated) {

            $book = Book::create([
                'user_id' => $validated['user_id'],
                'title' => $validated['title'],
                'author' => $validated['author'],
                'isbn' => $validated['isbn'],
                'published_date' => $validated['published_date'],
                'description' => $validated['description'] ?? null,
                'image_url' => $validated['image_url'] ?? null,
            ]);

            $genreIds = $validated['genres'];

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

    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $book) {

            $book->update([
                'title' => $validated['title'],
                'author' => $validated['author'],
                'isbn' => $validated['isbn'],
                'published_date' => $validated['published_date'],
                'description' => $validated['description'] ?? null,
                'image_url' => $validated['image_url'] ?? null,
            ]);

            $genreIds = $validated['genres'];

            $book->genres()->sync($genreIds);
        });

        $book->load('genres');
        $book->loadAvg('reviews', 'rating');
        $book->loadCount('reviews');

        return new BookResource($book);
    }

    public function destroy(Book $book)
    {
        DB::transaction(function () use ($book) {
            $reviewIds = $book->reviews()->pluck('id');

            DB::table('review_like')
                ->whereIn('review_id', $reviewIds)
                ->delete();

            $book->reviews()->delete();

            DB::table('favorites')
                ->where('book_id', $book->id)
                ->delete();

            $book->genres()->detach();

            $book->delete();
        });

        return response()->noContent();
    }
}
