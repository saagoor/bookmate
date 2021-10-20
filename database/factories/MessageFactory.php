<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $conversation = Conversation::inRandomOrder()->first();
        $condition = $this->faker->randomElement([true, false]);
        return [
            'conversation_id'   => $conversation->id,
            'sender_id' => $condition ? $conversation->user_one_id : $conversation->user_two_id,
            'receiver_id' => $condition ? $conversation->user_two_id : $conversation->user_one_id,
            'message'   => $this->faker->sentence(),
        ];
    }
}
