<?php

namespace Database\Factories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublisherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Publisher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'  => $this->faker->company,
            'image' => $this->faker->imageUrl(50, 50, 'avatar'),
            'location'  => $this->faker->address(),
            'email'     => $this->faker->email(),
            'phone'     => $this->faker->phoneNumber()
        ];
    }
}
