<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name'  => $this->faker->name(),
            'cover' => $this->faker->imageUrl(400, 200, 'book'),
            'publisher_id'  => Publisher::inRandomOrder()->first(['id'])->id,
            'isbn'  => $this->faker->isbn10(),
            'published_at'  => $this->faker->date(),
            'language'      => $this->faker->randomElement(['English', 'Bangla']),
            'category'      => $this->faker->randomElement(Book::$categories)
        ];
    }
}
