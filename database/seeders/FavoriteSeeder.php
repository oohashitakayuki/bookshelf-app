<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::orderBy('id')->get();
        $books = Book::orderBy('id')->get();

        foreach ($users->take(5) as $user) {
            // ユーザーごとに異なる3〜5冊を選択
            $favoriteCount = 3 + (($user->id - 1) % 3);

            $favoriteBookIds = $books
                ->shuffle()
                ->take($favoriteCount)
                ->pluck('id')
                ->all();

            // 既存のお気に入りを維持しながら追加
            $user->favoriteBooks()
                ->syncWithoutDetaching($favoriteBookIds);
        }
    }
}
