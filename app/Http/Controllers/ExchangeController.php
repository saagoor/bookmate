<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Exchange;
use App\Models\ExchangeOffer;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $exchanges = Exchange::search()->paginate(5);

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
            'previews'      => 'required|exclude',
            'previews.*'      => 'required|image',
        ]);

        $exchange = $request->user()->exchanges()->create($exchangeData);

        if ($request->hasFile('previews')) {
            $previews = [];
            foreach ($request->previews as $preview) {
                $previews[]['image'] = $preview->store('exchanges');
            }
            $exchange->previews()->createMany($previews);
        }

        return redirect()->route('exchanges.show', $exchange->id)->with('succes', 'Your exchange request has been posted. Please for offers from others.');
    }

    public function show(Exchange $exchange)
    {
        $similar_books = Book::where('category', 'like', "%{$exchange->book->category}%")
            ->take(6)
            ->with(['writers', 'translators'])->get();
        return view('exchanges.show', compact('exchange', 'similar_books'));
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
