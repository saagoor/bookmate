<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Discussion;
use App\Models\User;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function index()
    {
        $discussions = Discussion::search()
            ->where('discussable_type', Book::class)
            ->with(['user', 'discussable'])
            ->latest()
            ->paginate(20);

        return view('discussions.index', compact('discussions'));
    }

    public function show(Discussion $discussion)
    {
        return view('discussions.show', compact('discussion'));
    }

    public function create()
    {
        return view('discussions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer|exists:books,id',
            'title' => 'required',
            'body' => 'required',
        ]);
        $discussion = $request->user()->discussions()->create([
            'title' => $request->title,
            'body' => $request->body,
            'discussable_id'    => $request->book_id,
            'discussable_type'  => Book::class,
        ]);
        return redirect()
            ->route('discussions.show', $discussion)
            ->with('success', 'New discussion has been started.');
    }
}
