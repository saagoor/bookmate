<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;

class ExchangeOfferController extends Controller
{
    public function store(Request $request, Exchange $exchange)
    {
        $offer = $request->validate([
            'offered_book_id'   => 'required|exists:books,id',
            'book_condition'    => 'required',
            'book_edition'       => 'required',
        ]);

        $offer['user_id'] = $request->user()->id;

        $exchange->offers()->create($offer);

        return back()->with('success', 'Your exchange offer has been sent.');
    }
}
