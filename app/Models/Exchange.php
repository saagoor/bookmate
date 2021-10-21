<?php

namespace App\Models;

use App\LocationScraper;
use App\Traits\ExchangeTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Exchange extends Model
{
    use HasFactory, ExchangeTrait, Searchable;

    protected $guarded = [];
    protected $dates = ['pickup_time'];

//    Utilities
    public function calculateBookWorth($price = null)
    {
        $price = $price ?? $this->book->getPrice();
        if ($this->missing_page) {
//            Deduct 10 for each page
            $price -= $this->missing_page * 10;
        }
        if ($this->markings_percentage && $this->markings_density) {
            $price -= ($this->markings_percentage + $this->markings_density) * 2;
        }
        if ($this->book_age) {
//            Deduct 10 for each year
            $price -= floor($this->book_age / 6) * 10;
        }
        return $price > 0 ? floor($price) : 0;
    }

    public static function saveFromRequest($request, $parent = null) : Exchange
    {
        $coordinates = $coordinates = (new LocationScraper)->get_user_coordinates();
        if(!$coordinates){
            throw new NotFoundHttpException('Could not get your coordinates, please try again.');
        }
        $exchange = Exchange::make($request->validated());
        $exchange->book_worth = $exchange->calculateBookWorth();
        $exchange->user_id = $request->user()->id;
        $exchange->latitude = $coordinates->latitude;
        $exchange->longitude = $coordinates->longitude;

        if ($parent){
            $exchange->exchange_id = $parent->id;
            $exchange->expected_book_id = null;
        }
        $exchange->save();

        if ($request->hasFile('previews')) {
            $previews = [];
            foreach ($request->previews as $preview) {
                $previews[]['image'] = $preview->store('exchanges');
            }
            $exchange->previews()->createMany($previews);
        }
        return $exchange;
    }

    public function transactions(){
        return $this->morphMany(Transaction::class, 'transactable');
    }

    public function makeTransactions($offer){
        $this->transactions()->create([
            'user_id' => $this->user_id,
            'amount' => $this->book_worth - $offer->book_worth
        ]);

        $this->transactions()->create([
            'user_id' => $offer->user->id,
            'amount' => $offer->book_worth - $this->book_worth,
        ]);
    }
}
