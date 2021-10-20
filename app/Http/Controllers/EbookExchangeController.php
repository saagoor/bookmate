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

    public function create()
    {
        return view('ebooks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id'   => 'required|integer|exists:books,id',
            'expected_book_id'   => 'nullable|integer|exists:books,id',
            'ebook'     => 'required|file|mimes:pdf,epub',
            'book_edition'  => 'nullable|integer|min:0',
        ]);
        $exchange = EbookExchange::create([
            'user_id'   => $request->user()->id,
            'book_id'   => $request->book_id,
            'expected_book_id'   => $request->expected_book_id,
            'ebook'     => $request->ebook->store('ebooks'),
            'book_edition'   => $request->book_edition,
        ]);
        return redirect()
            ->route('ebooks.show', $exchange)
            ->with('success', 'Your eBook exchange request has been posted.');
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
