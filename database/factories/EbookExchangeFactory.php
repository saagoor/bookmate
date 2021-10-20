<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\EbookExchange;
use App\Models\Exchange;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class EbookExchangeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EbookExchange::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ebook_exchange_id' => $this->faker->randomElement([
                null,
                optional(EbookExchange::whereNull('ebook_exchange_id')->inRandomOrder()->first())->id
            ]),
            'user_id' => User::inRandomOrder()->first(),
            'book_id' => Book::inRandomOrder()->first(),
            'expected_book_id' => Book::inRandomOrder()->first(),
            'book_edition' => rand(1, 7),
            'ebook' => $this->faker->randomElement(Storage::allFiles('ebooks')),
        ];
    }
}
