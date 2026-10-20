<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::orderBy('id')->get();
        $books = Book::orderBy('id')->get();

        // 各書籍に投稿するレビュー数。
        // 先頭10冊は3件ずつ、11冊目は2件で合計32件。
        $reviewCounts = [
            3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2,
        ];

        $comments = [
            'とても読みやすく、参考になりました。',
            '内容が分かりやすく、勉強になりました。',
            '何度も読み返したくなる一冊です。',
            '新しい視点を得ることができました。',
            '期待通りの内容で満足しています。',
        ];

        foreach ($books->take(11)->values() as $index => $book) {
            for ($i = 0; $i < $reviewCounts[$index]; $i++) {
                // 5人のユーザーを順番に割り当てる
                $user = $users[($index + $i) % $users->count()];

                Review::create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'rating' => 3 + (($index + $i) % 3),
                    'comment' => $comments[($index + $i) % count($comments)],
                ]);
            }
        }
    }
}
