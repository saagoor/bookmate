@php
$title = 'Post a Book to Exchange';
$books = App\Models\Book::with('authors')
    ->latest('name')
    ->get(['id', 'name', 'cover']);
@endphp
<x-app-layout :title="$title">
    <div class="container max-w-lg py-6 md:py-10">
        <div class="p-6 bg-opacity-50 rounded-md shadow bg-primary-50">
            <h1 class="mb-4 text-3xl font-semibold md:mb-6">{{ $title }}</h1>

            <form action="{{ route('exchanges.store') }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf

                <x-input-searchable-select class="mb-3"
                    name="book_id"
                    :rounded-image="false"
                    :options="$books"
                    :properties="[
                        'image' => 'cover_url',
                        'subtitle'  => 'writer',
                    ]">Your Book</x-input-searchable-select>

                <div class="flex gap-3 mb-3">

                    <x-input-select-book-condition class="flex-1"
                        label="Your Book's Condition" />

                    <x-input-text class="flex-1"
                        name="book_edition"
                        placeholder="4th">Your Book's Edition</x-input-text>

                </div>

                <x-input-select-book class="mb-3"
                    name="expected_book_id">Expected Book</x-input-select-book>

                <x-input-textarea class="mb-3"
                    name="description"
                    placeholder="(Optional) Writer a short description......."
                    label="Description">{{ old('description') }}</x-input-textarea>

                <div class="mb-3">
                    <x-input-image type="file"
                        name="previews[]"
                        button-label="Select Previews"
                        multiple>Picture Previews</x-input-image>

                    @error('previews')
                        <p class="mt-0.5 text-sm font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <x-button class="text-base">Post Request</x-button>
            </form>
        </div>
    </div>
</x-app-layout>
