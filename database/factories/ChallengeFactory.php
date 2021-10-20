<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Challenge;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChallengeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Challenge::class;

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
            'finish_at' => now()->addDays(rand(20, 50))->addMinutes(rand(10, 100))->addSeconds(1, 50),
        ];
    }
}
