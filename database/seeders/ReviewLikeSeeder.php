<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::orderBy('id')->get();
        $reviews = Review::with('user')
            ->orderBy('id')
            ->get();

        foreach ($reviews as $review) {
            // 自分のレビューにはいいねできない
            $eligibleUsers = $users
                ->where('id', '!=', $review->user_id)
                ->shuffle();

            // 0〜3人を選択（対象ユーザー数を超えない）
            $likeCount = min(
                $review->id % 4,
                $eligibleUsers->count()
            );

            $likedUserIds = $eligibleUsers
                ->take($likeCount)
                ->pluck('id')
                ->all();

            // 既存のいいねを解除せずに追加
            $review->likedByUsers()
                ->syncWithoutDetaching($likedUserIds);
        }
    }
}
