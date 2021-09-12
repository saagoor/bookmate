<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Challange;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChallangeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Challange::class;

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
            'finish_at' => now()->addDays(rand(20, 50)),
        ];
    }
}
