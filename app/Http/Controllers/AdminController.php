<?php

namespace App\Http\Controllers;

use App\Models\Book;
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
        $books = $this->search(Book::class)->paginate();
        $books->load(['writers', 'translators', 'publisher']);
        return view('admin.books', compact('books'));
    }

    public function writers()
    {
        $writers = $this->search(Writer::class)->paginate();
        return view('admin.writers', compact('writers'));
    }

    public function publishers()
    {
        $publishers = $this->search(Publisher::class)->paginate();
        return view('admin.publishers', compact('publishers'));
    }

    public function exchanges()
    {
        $exchanges = $this->search(Exchange::class)->paginate();
        $exchanges->load(['book', 'expected_book', 'user'])->loadCount('offers');
        return view('admin.exchanges', compact('exchanges'));
    }

    public function users()
    {
        $users = $this->search(User::class)->paginate();
        return view('admin.users', compact('users'));
    }

}
