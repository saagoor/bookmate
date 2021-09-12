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
            'user_id'   => User::inRandomOrder()->first(),
            'book_id'   => Book::inRandomOrder()->first(),
            'expected_book_id'   => Book::inRandomOrder()->first(),
            'book_condition'    => $this->faker->randomElement(['average', 'good', 'fresh', 'full_fresh']),
            'description'   => $this->faker->paragraphs(5, true),
        ];
    }
}
