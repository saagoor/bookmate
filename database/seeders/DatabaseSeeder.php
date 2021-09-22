<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Challange;
use App\Models\Exchange;
use App\Models\Publisher;
use App\Models\User;
use App\Models\Writer;
use Illuminate\Database\Seeder;
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
        User::truncate();
        User::factory()->create([
            'email' => 'admin@admin.com',
            'password'  => Hash::make('password'),
            'admin' => true,
        ]);
        User::factory()->create([
            'name'  => 'মেহেদী হাসাইন',
            'email' => 'mhsagor91@gmail.com',
            'password'  => bcrypt('password'),
            'admin' => false,
        ]);

        User::factory(10)->create();

        $this->call(BooksSeeder::class);

        Exchange::factory(10)->create();

        Challange::factory(10)->hasParticipants(rand(2, 5))->create();
    }
}
