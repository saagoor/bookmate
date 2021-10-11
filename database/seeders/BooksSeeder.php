<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Review;
use App\Models\Writer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Writer::truncate();
        Publisher::truncate();
        Book::truncate();

        $booksData = collect($this->books());

        $publishers = $booksData->pluck('publisher')->unique();
        $writers = $booksData->pluck('writer')->unique();

        // Insert Publishers
        $publishers = $publishers->map(function($pub){
            return Publisher::factory()->make(['name' => $pub]);
        });
        Publisher::insert($publishers->toArray());
        $publishers = Publisher::all(['id', 'name']);

        // Insert Writers
        $writers = $writers->map(function($writer){
            return Writer::factory()->raw(['name'   => $writer]);
        });
        Writer::insert($writers->toArray());
        $writers = Writer::all(['id', 'name']);
        if($writers->count() < 30){
            Writer::factory(30 - $writers->count())->create();
            $writers = Writer::all(['id', 'name']);
        }

        // Insert Books
        
        $books = $booksData->map(function($book) use($publishers, $writers){
            if($book['publisher']){
                $book['publisher_id'] = $publishers->where('name', $book['publisher'])->first()->id;
                unset($book['publisher']);
            }
            if($book['writer']){
                // $book['writer_id'] = $writers->where('name', $book['writer']);
                unset($book['writer']);
            }
            if($book['published_at']){
                $book['published_at'] = Carbon::parse($book['published_at'])->format('Y-m-d');
            }
            $book = array_filter($book, 'strlen');
            return Book::factory()->make($book)->getAttributes();
        });

        Book::insert($books->toArray());
        
        $books = Book::all();
        $books->each(function($book) use($writers){
            $book->writers()->sync(rand(1, $writers->count()));
            $book->authors()->syncWithPivotValues(rand(1, $writers->count()), ['translator' => true], false);
            $book->reviews()->saveMany(Review::factory(rand(2, 4))->make());
        });

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
