<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExchangeRequest;
use App\Models\Book;
use App\Models\Conversation;
use App\Models\Exchange;
use App\Models\Message;
use Exception;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $exchanges = Exchange::search()
            ->whereNull('exchange_id')
            ->withCount('offers')
            ->paginate(5);

        return view('exchanges.index', compact('exchanges'));
    }

    public function create()
    {
        return view('exchanges.create');
    }

    public function store(ExchangeRequest $request)
    {
        $exchange = Exchange::saveFromRequest($request);
        return redirect()->route('exchanges.show', $exchange->id)->with('succes', 'Your exchange request has been posted. Please for offers from others.');
    }

    public function show(Exchange $exchange)
    {
        $similar_books = Book::where('category', 'like', "%{$exchange->book->category}%")
            ->take(4)
            ->with(['writers', 'translators'])
            ->get();
        return view('exchanges.show', compact('exchange', 'similar_books'));
    }

    public function offers(Exchange $exchange)
    {
        return view('exchanges.offers', compact('exchange'));
    }

    public function setPickupLocation(Request $request, Exchange $exchange)
    {
        $request->validate([
            'pickup_location' => 'required',
            'pickup_time' => 'required|date|after:now',
        ]);

        $exchange->pickup_location = $request->pickup_location;
        $exchange->pickup_time = $request->pickup_time;
        $exchange->save();

        $text = 'Pickup loaction & time has been set by ' . auth()->user()->name .
            ' to exchange book ' . $exchange->book->name . ' and ' . $exchange->accepted_offer->book->name . PHP_EOL . PHP_EOL .
            'Location: ' . $exchange->pickup_location . PHP_EOL .
            'Time: ' . date('d M Y - h:m A', strtotime($exchange->pickup_time));

        Message::createMessageForUsers($exchange->user, $exchange->accepted_offer->user, $text);

        return back()->with('success', 'Pickup location & time has been set.');
    }

    public function completeExchange(Exchange $exchange)
    {
        $exchange->complete = true;
        $exchange->save();

        $text = auth()->user()->name . ' has marked the exchange of book ' .
            $exchange->book->name . ' and ' . $exchange->accepted_offer->book->name .
            ' as completed.';

        Message::createMessageForUsers($exchange->user, $exchange->accepted_offer->user, $text);
        return back()->with('success', 'The exchange has been marked as complete.');
    }
}
