<?php

namespace App\Http\Controllers;

use App\Models\EbookExchange;
use App\Models\Exchange;
use App\Models\Message;
use Illuminate\Http\Request;

class EbookExchangeOffersController extends Controller
{
    public function index(EbookExchange $ebook)
    {
        return view('exchanges.offers', [
            'exchange'  => $ebook,
        ]);
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

    public function acceptOffer(EbookExchange $ebook, EbookExchange $offer)
    {
        if ($ebook->accepted_offer_id || $ebook->id != $offer->ebook_exchange_id) {
            return back()->with('error', 'Could not accept this offer! Cancel previous exchange first and make sure the exchange & offer match.');
        }
        // Set accepted offer
        $ebook->accepted_offer_id = $offer->id;
        $ebook->save();

//        Notify via message
        $text = 'Exchange of eBook ' . $ebook->book->name . ' and ' . $offer->book->name . ' has been accepted.';
        Message::createMessageForUsers($ebook->user, $offer->user, $text);

        return back()->with('success', 'Offer has been accepted.');
    }

    public function rejectOffer(EbookExchange $ebook, EbookExchange $offer)
    {
        $ebook->accepted_offer_id = null;
        $ebook->save();
        $text = 'Exchange of eBook ' . $ebook->book->name . ' and ' . $offer->book->name . ' has been rejected.';
        Message::createMessageForUsers($ebook->user, $offer->user, $text);
        return back()->with('success', 'Exchange offer rejected.');
    }
}
