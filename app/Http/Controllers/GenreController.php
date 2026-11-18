<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::query()
            ->withCount('books')
            ->orderBy('name')
            ->get();

        return view('genres.index', compact('genres'));
    }

    public function show(Genre $genre)
    {
        $books = $genre->books()
            ->with('genres')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('genres.show', compact('genre', 'books'));
    }

    public function create()
    {
        return view('genres.create');
    }

    public function store(StoreGenreRequest $request)
    {
        Genre::create(
            $request->validated()
        );

        return redirect()
            ->route('genres.index')
            ->with('success', 'ジャンルを作成しました。');
    }

    public function edit(Genre $genre)
    {
        return view('genres.edit', compact('genre'));
    }

    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        $genre->update([
            'name' => $request->validated()['name'],
        ]);

        return redirect()
            ->route('genres.index')
            ->with('success', 'ジャンルを更新しました。');
    }

    public function destroy(Genre $genre)
    {
        if ($genre->books()->exists()) {
            return redirect()
                ->route('genres.index')
                ->with('error', 'このジャンルには書籍が紐付いているため削除できません。');
        }

        $genre->delete();

        return redirect()
            ->route('genres.index')
            ->with('success', 'ジャンルを削除しました。');
    }
}
