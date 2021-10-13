<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Exchange;
use App\Models\ExchangeOffer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExchangeOfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExchangeOffer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'exchange_id'   => Exchange::inRandomOrder()->first(),
            'user_id'   => User::inRandomOrder()->first(),
            'offered_book_id'   => Book::inRandomOrder()->first(),
            'book_worth'    => rand(1, 5) * 100,
        ];
    }
}
