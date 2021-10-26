<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Exchange;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExchangeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exchange::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'exchange_id'   => $this->faker->randomElement([
                null,
                optional(Exchange::whereNull('exchange_id')->inRandomOrder()->first())->id
            ]),
            'user_id'   => User::inRandomOrder()->first(),
            'book_id'   => Book::inRandomOrder()->first(),
            'expected_book_id'   => Book::inRandomOrder()->first(),
            'book_edition'  => rand(1, 7),
            'book_print'    => $this->faker->randomElement(['original', 'nilkhet', 'news']),
            'book_age'  => rand(0.1, 5) * 10,
            'markings_percentage'   => rand(1, 2) * 5,
            'markings_density'   => rand(1, 2) * 5,
            'missing_pages' => rand(1, 3),
            'description'   => $this->faker->paragraph(10),
            'latitude'  => $this->faker->latitude(23.70, 23.99),
            'longitude' => $this->faker->longitude(90.30, 90.40),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Exchange $exchange){
            $exchange->book_worth = $exchange->calculateBookWorth(rand(1, 4) * 100);
        });
    }
}
