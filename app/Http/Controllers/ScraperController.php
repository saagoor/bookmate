<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\BookScraper;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function searchBook(Request $request)
    {
        // BookScraper::url($request->url)->get();
    }

    public function bookPrice(Book $book)
    {
        return BookScraper::url('search')
            ->params(['term' => $book->name])
            ->get()
            ->price();
    }
}
