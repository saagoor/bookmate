<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'rating' => 'required|between:1,5',
            'text' => 'required',
        ]);
        $book->reviews()->updateOrCreate(
            ['user_id' => $request->user()->id], [
            'rating' => $request->rating,
            'text' => $request->text,
        ]);
        return back()->with('success', 'Your review has been posted.');
    }
}
