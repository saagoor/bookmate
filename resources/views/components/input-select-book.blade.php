@props(['books', 'name' => 'book_id'])


@php

if (!isset($books)) {
    $books = App\Models\Book::getForSelector();
}

$books = $books->map(function ($book) {
    $book->writer = $book->authors->pluck('name')->implode(', ');
    return $book;
});
@endphp

<x-input-searchable-select :attributes="$attributes"
    :name="$name"
    :rounded-image="false"
    :options="$books"
    :properties="[
        'image' => 'cover_url',
        'subtitle'  => 'writer',
    ]">{{ $slot }}</x-input-searchable-select>
