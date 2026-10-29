<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $books = auth()->user()
            ->favoriteBooks()
            ->with('genres')
            ->orderByDesc('favorites.created_at')
            ->paginate(10);

        return view('favorites.index', compact('books'));
    }

    public function toggle(Book $book)
    {
        auth()->user()->favoriteBooks()->toggle($book->id);

        return direct()->back();
    }
}
