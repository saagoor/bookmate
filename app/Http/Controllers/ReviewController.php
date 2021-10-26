<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|between:1,5',
            'text' => 'required',
            'reviewable_id' => 'required|integer',
            'reviewable_type'   => 'required',
        ]);

        Review::updateOrCreate(['user_id' => $request->user()->id], $validated);

        return back()->with('success', 'Your review has been posted.');
    }
}
