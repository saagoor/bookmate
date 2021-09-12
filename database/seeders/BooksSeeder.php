<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Writer;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $booksData = collect($this->books());

        $publishers = $booksData->pluck('publisher')->unique();
        $writers = $booksData->pluck('writer')->unique();

        // Insert Publishers
        $publishers = $publishers->map(function($pub){
            return Publisher::factory()->make(['name' => $pub]);
        });
        Publisher::insert($publishers);
        $publishers = Publisher::all(['id', 'name']);

        // Insert Writers
        $writers = $writers->map(function($writer){
            return Writer::factory()->raw(['name'   => $writer]);
        });
        Writer::insert($writers->toArray());
        $writers = Writer::all(['id', 'name']);

        // Insert Books
        

        dd($writers);
    }

    protected function getCovers()
    {
        return Storage::allFiles('covers');
    }

    public function books() : array
    {
        $rows   = array_map('str_getcsv', file(resource_path('data/books.csv')));
        $header = array_shift($rows);
        $csv    = array();
        foreach ($rows as $row) {
            $csv[] = array_combine($header, $row);
        }
        return $csv;
    }
}
