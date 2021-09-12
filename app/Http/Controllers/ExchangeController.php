<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\ExchangeOffer;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $exchanges = $this->search(Exchange::class)->paginate(5);
        $exchanges->load(['user', 'book.writers', 'book.translators']);
        return view('exchanges.index', compact('exchanges'));
    }

    public function create()
    {
        return view('exchanges.create');
    }

    public function store(Request $request)
    {
        $exchangeData = $request->validate([
            'book_id'  => 'required|integer',
            'book_condition' => 'required',
            'expected_book_id'  => 'nullable|integer',
            'description'   => 'nullable',
        ]);

        $exchange = $request->user()->exchanges()->create($exchangeData);

        return redirect()->route('exchanges.show', $exchange->id)->with('succes', 'Your exchange request has been posted. Please for offers from others.');
    }

    public function show(Exchange $exchange)
    {

        return view('exchanges.show', compact('exchange'));
    }

    public function offers(Exchange $exchange)
    {
        return view('exchanges.offers', compact('exchange'));
    }

    public function acceptOffer(Exchange $exchange, ExchangeOffer $offer)
    {
        if ($exchange->id == $offer->exchange_id) {
            $exchange->accepted_offer_id = $offer->id;
            return $exchange->save();
        }
        return false;
    }
}
