<?php

namespace Database\Factories;

use App\Models\Writer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WriterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Writer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name();
        return [
            'name'  => $name,
            'image' => "https://avatars.dicebear.com/api/croodles-neutral/:" . Str::slug($name) . ".svg",
            'location'  => $this->faker->address(),
            'date_of_birth' => $this->faker->date,
            'email'     => $this->faker->email(),
        ];
    }
}
