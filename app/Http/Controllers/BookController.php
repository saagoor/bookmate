<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{

    public function index()
    {
        $books = Book::search()
            ->withAvg('reviews', 'rating')
            ->paginate(12);

        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.save', [
            'book' => new Book()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());
        $this->save($request, new Book());
        return redirect()->route('admin.books')->with('success', 'The book has been inserted.');
    }

    public function show(Book $book)
    {
        $book->loadAvg('reviews', 'rating')
            ->loadCount('reviews')
            ->load('reviews.user');
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.save', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate($this->rules());
        $this->save($request, $book);
        return redirect()->route('admin.books')->with('success', 'The book has been updated.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return back()->with('success', "The book $book->name has been deleted.");
    }

    protected function rules()
    {
        return [
            'cover' => 'nullable|image',
            'name' => 'required',
            'language' => 'required',
            'category' => ['required', Rule::in(Book::$categories)],
            'isbn' => 'nullable',
            'page_count' => 'nullable|integer',
            'published_at' => 'required|date',
            'publisher_id' => 'required|integer',
            'writer_id' => 'required',
            'writer_id.*' => 'integer',
            'translator_id' => 'nullable',
            'translator_id.*' => 'integer',
        ];
    }

    protected function save(Request $request, Book $book): Book
    {
        $book->fill($request->except(['_token', 'cover', 'writer_id', 'translator_id']));
        if ($request->hasFile('cover')) {
            $book->cover = $request->cover->store('books');
        }
        $book->save();
        $book->authors()->sync($request->writer_id);
        $book->authors()->syncWithPivotValues($request->translator_id, ['translator' => true], false);
        return $book;
    }
}
