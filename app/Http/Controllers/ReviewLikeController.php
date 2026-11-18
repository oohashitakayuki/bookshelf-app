<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\RedirectResponse;

class ReviewLikeController extends Controller
{
    public function toggle(Review $review): RedirectResponse
    {
        $user = auth()->user();

        $result = $user->likedReviews()->toggle($review->id);

        if (! empty($result['attached'])) {
            return back()->with('success', 'レビューにいいねしました。');
        }

        return back()->with('success', 'レビューのいいねを解除しました。');
    }
}
