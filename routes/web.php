<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

Route::middleware('auth')->group(function () {
  Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
  Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
  Route::get('/genres/create', [GenreController::class, 'create'])->name('genres.create');
  Route::post('/genres', [GenreController::class, 'store'])->name('genres.store');
  Route::get('/genres/{genre}', [GenreController::class, 'show'])->name('genres.show');
  Route::get('/genres/{genre}/edit', [GenreController::class, 'edit'])->name('genres.edit');
  Route::put('/genres/{genre}', [GenreController::class, 'update'])->name('genres.update');
  Route::delete('/genres/{genre}', [GenreController::class, 'destroy'])->name('genres.destroy');
});
