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
            'email' => 'mhsagor91@gmail.com',
            'password'  => bcrypt('password'),
            'admin' => true,
        ]);

        User::factory(10)->create();
        Publisher::factory(10)->create();
        Writer::factory(10)->create();

        Book::factory(10)
        ->hasAttached(Writer::factory()->count(rand(1, 2)))
        ->hasAttached(Writer::factory()->count(rand(1, 2)), ['translator' => true])
        ->create();

        Exchange::factory(5)->create();

        Challange::factory(5)->hasParticipants(rand(2, 5))->create();
    }
}
