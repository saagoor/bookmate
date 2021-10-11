<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Challange;
use App\Models\Discussion;
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
        $choice = rand(1, 2);
        if($choice == 1){
            $model = Book::inRandomOrder()->first();
        }else{
            $model = Challange::inRandomOrder()->first();
        }
        return [
            'discussable_id'    => $model->id,
            'discussable_type'  => get_class($model),
        ];
    }
}
