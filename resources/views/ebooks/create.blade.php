@php
    $title = 'Post an eBook to Exchange';

    $books = App\Models\Book::getForSelector();

@endphp
<x-app-layout :title="$title">

    <div class="container max-w-xl py-6 md:py-10">
        <main class="bg-white shadow-xl rounded-xl p-6">
            <h1 class="mb-4 text-3xl font-semibold md:mb-6">{{ $title }}</h1>

            <form action="{{ route('ebooks.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                <x-input-searchable-select
                        class="mb-3"
                        name="book_id"
                        :rounded-image="false"
                        :options="$books"
                        :properties="[
                            'image' => 'cover_url',
                            'subtitle'  => 'writer',
                        ]">Your Book
                </x-input-searchable-select>

                <x-input-text class="mb-3" name="ebook" type="file" accept=".pdf,.epub">Upload eBook</x-input-text>

                <x-input-text class="mb-3" name="book_edition" type="number">Book Edition</x-input-text>

                <x-input-searchable-select
                        class="mb-3"
                        name="expected_book_id"
                        :rounded-image="false"
                        :options="$books"
                        :properties="[
                            'image' => 'cover_url',
                            'subtitle'  => 'writer',
                        ]">Expected Book
                </x-input-searchable-select>

                <x-button class="text-base font-heading">
                    Post Exchange Request
                </x-button>

            </form>
        </main>
    </div>
</x-app-layout>
