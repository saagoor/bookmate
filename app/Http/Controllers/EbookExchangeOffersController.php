<?php

namespace App\Http\Controllers;

use App\Models\EbookExchange;
use Illuminate\Http\Request;

class EbookExchangeOffersController extends Controller
{
    public function index(EbookExchange $ebook)
    {
        return $ebook->offers;
    }

    public function store(Request $request, EbookExchange $ebook)
    {
        $request->validate([
            'book_id'   => 'required|integer|exists:books,id',
            'ebook'   => 'required|file|mimes:pdf,epub',
        ]);

        $ebook->offers()->create([
           'user_id'    => $request->user()->id,
           'book_id'    => $request->book_id,
            'ebook'     => $request->ebook->store('ebooks'),
        ]);

        return back()->with('success', 'Your offer has been sent.');
    }
}
