<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Challenge;
use App\Models\Discussion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscussionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discussion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $model = Book::inRandomOrder()->first();
        return [
            'discussable_type' => get_class($model),
            'discussable_id' => $model->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'title' => $this->faker->realTextBetween(50, 80),
            'body' => $this->faker->realTextBetween(200, 300),
        ];
    }
}
