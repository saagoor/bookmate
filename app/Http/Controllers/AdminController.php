<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Challenge;
use App\Models\Exchange;
use App\Models\Publisher;
use App\Models\User;
use App\Models\Writer;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function books()
    {
        $books = Book::search()
            ->withAvg('reviews', 'rating')
            ->paginate();

        return view('admin.books', compact('books'));
    }

    public function writers()
    {
        $writers = Writer::search()->paginate();
        return view('admin.writers', compact('writers'));
    }

    public function publishers()
    {
        $publishers = Publisher::search()->paginate();
        return view('admin.publishers', compact('publishers'));
    }

    public function exchanges()
    {
        $exchanges = Exchange::search()
            ->with(['book', 'expected_book', 'user'])
            ->paginate();
        return view('admin.exchanges', compact('exchanges'));
    }

    public function challenges()
    {
        $challenges = Challenge::search()
            ->with(['book'])
            ->paginate();
        return view('admin.challenges', compact('challenges'));
    }

    public function users()
    {
        $users = User::search()->paginate();
        return view('admin.users', compact('users'));
    }
}
