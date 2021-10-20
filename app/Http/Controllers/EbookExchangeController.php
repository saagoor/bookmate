<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\EbookExchange;
use Illuminate\Http\Request;

class EbookExchangeController extends Controller
{
    public function index()
    {
        $ebooks = EbookExchange::search()
            ->whereNull('ebook_exchange_id')
            ->withCount('offers')
            ->paginate(5);
        return view('ebooks.index', compact('ebooks'));
    }

    public function show(EbookExchange $ebook)
    {
        $similar_books = Book::where('category', 'like', "%{$ebook->book->category}%")
            ->take(4)
            ->with(['writers', 'translators'])
            ->get();

        return view('ebooks.show', [
            'exchange'  => $ebook,
            'similar_books' => $similar_books,
        ]);
    }
}
