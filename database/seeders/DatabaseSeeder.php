<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Challenge;
use App\Models\Conversation;
use App\Models\Discussion;
use App\Models\EbookExchange;
use App\Models\Exchange;
use App\Models\Message;
use App\Models\Publisher;
use App\Models\User;
use App\Models\Writer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        User::truncate();
        User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'admin' => true,
        ]);
        User::factory()->create([
            'name' => 'Mehedi Hassain',
            'email' => 'mhsagor91@gmail.com',
            'password' => bcrypt('password'),
            'admin' => false,
        ]);
        User::factory()->create([
            'name' => 'Abu Obayed Shabbir',
            'email' => 'levelzerosss@gmail.com',
            'password' => bcrypt('password'),
            'admin' => false,
        ]);

        User::factory(10)->create()->each(function ($user, $index) {
//            if ($index % 2 == 0) {
//                Conversation::factory()->hasMessages(rand(10, 20))->create([
//                    'user_one_id' => $user->id,
//                ]);
//            }
        });

        $this->call(BooksSeeder::class);

        Exchange::factory(10)->create();

        EbookExchange::factory(10)->create();

        Challenge::factory(10)->hasParticipants(rand(2, 5))->create();

        Discussion::factory(10)->hasComments(rand(2, 10))->create();

        DB::statement("SET foreign_key_checks=1");
    }
}
