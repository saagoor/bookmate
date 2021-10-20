<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExchangeRequest;
use App\Models\Exchange;
use App\Models\Message;

class ExchangeOfferController extends Controller
{
    public function store(ExchangeRequest $request, Exchange $exchange)
    {
        Exchange::saveFromRequest($request, $exchange);
        return back()->with('success', 'Your exchange offer has been sent.');
    }

    public function acceptOffer(Exchange $exchange, Exchange $offer)
    {
        if ($exchange->accepted_offer_id || $exchange->id != $offer->exchange_id) {
            return back()->with('error', 'Could not accept this offer! Cancel previous exchange first and make sure the exchange & offer match.');
        }

        // Make transaction between exchange parties
        $exchange->makeTransactions($offer);

        // Set accepted offer
        $exchange->accepted_offer_id = $offer->id;
        $exchange->save();

//        Notify via message
        $text = 'Exchange of book ' . $exchange->book->name . ' and ' . $offer->book->name . ' has been accepted.';
        Message::createMessageForUsers($exchange->user, $offer->user, $text);

        return back()->with('success', 'Offer has been accepted.');
    }

    public function rejectOffer(Exchange $exchange, Exchange $offer)
    {
        $exchange->accepted_offer_id = null;
        $exchange->pickup_location = null;
        $exchange->pickup_time = null;
        // Delete transaction between previous exchange parties
        $exchange->transactions()->delete();
        $exchange->save();
        $text = 'Exchange of book ' . $exchange->book->name . ' and ' . $offer->book->name . ' has been rejected.';
        Message::createMessageForUsers($exchange->user, $offer->user, $text);
        return back()->with('success', 'Exchange offer rejected.');
    }
}
