<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewLikeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index'])->name('books.index');

Route::middleware('auth')->group(function () {
  Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
  Route::post('/books', [BookController::class, 'store'])->name('books.store');
  Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
  Route::get('/genres/create', [GenreController::class, 'create'])->name('genres.create');
  Route::post('/genres', [GenreController::class, 'store'])->name('genres.store');
  Route::get('/genres/{genre}', [GenreController::class, 'show'])->name('genres.show');
  Route::get('/genres/{genre}/edit', [GenreController::class, 'edit'])->name('genres.edit');
  Route::put('/genres/{genre}', [GenreController::class, 'update'])->name('genres.update');
  Route::delete('/genres/{genre}', [GenreController::class, 'destroy'])->name('genres.destroy');
  Route::post('/books/{book}/reviews',[ReviewController::class, 'store'])->name('reviews.store');
  Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});

Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
