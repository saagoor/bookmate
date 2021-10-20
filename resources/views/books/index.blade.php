@php
$title = 'Books';
@endphp
<x-app-layout :title="$title">
    <x-slot name="actions">
        @auth
            <x-link-button class="border-gray-100 "
                :href="route('exchanges.create')">
                <x-heroicon-s-plus class="inline w-6 h-6 mr-1" />
                <span class="pr-2">Exchange</span>
            </x-link-button>
        @endauth
    </x-slot>

    <div class="container py-6 md:py-10">

        <div class="flex justify-between">
            <h1 class="mb-4 text-3xl font-semibold md:mb-6">{{ $title }}</h1>
            <x-form-search />
        </div>

        <div class="grid grid-cols-2 gap-6 md:gap-8 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-6">
            @forelse ($books as $book)
                <x-book-card :book="$book" />
            @empty
                <div>
                    <p class="text-xl">Ooops!</p>
                    <p>Sorry, no books found.</p>
                </div>
            @endforelse
        </div>
        <div class="my-8 sm:my-10">{{ $books->links() }}</div>
    </div>
</x-app-layout>
