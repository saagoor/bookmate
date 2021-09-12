@php
$writers = App\Models\Writer::oldest('name')->get(['id', 'name']);
$translators = $writers;
@endphp
<x-admin-layout>
    <div class="container max-w-xl">
        <div class="p-4 my-4 bg-white rounded-lg shadow md:p-6 md:my-6">

            <h1 class="mb-3 text-2xl font-semibold text-center">{{ $book->id ? 'Edit Book' : 'Add New Book' }}</h1>

            <form action="{{ $book->id ? route('admin.books.update', $book) : route('admin.books.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                
                @if ($book->id)
                    @method('PUT')
                @endif

                <x-input-image class="mb-3"
                    name="cover"
                    :image="$book->cover_url"
                    image-class="w-40 h-40">Book Cover</x-input-image>

                <x-input-text class="mb-3"
                    name="name"
                    :value="old('name', $book->name)"
                    autofocus
                    placeholder="A Song of Ice & Fire">Book Name</x-input-text>

                <div class="flex gap-4 mb-3">
                    <x-input-select class="flex-1"
                        name="language"
                        label="Language"
                        placeholder="A Song of Ice & Fire">
                        <option value="english"
                            {{ old('language', $book->language) == 'english' ? 'selected' : '' }}>English</option>
                        <option value="bangla"
                            {{ old('language', $book->language) == 'english' ? 'selected' : '' }}>Bangla</option>
                    </x-input-select>

                    <x-input-select class="flex-1"
                        name="category"
                        label="Category"
                        placeholder="Select Category">
                        <option value="">-Select Category-</option>
                        @foreach (App\Models\Book::$categories as $item)
                            <option {{ old('category', $book->category) == $item ? 'selected' : '' }}>
                                {{ $item }}</option>
                        @endforeach
                    </x-input-select>
                </div>

                <div class="flex gap-4 mb-3">
                    <x-input-text class="flex-1"
                        name="isbn"
                        :value="old('isbn', $book->isbn)"
                        placeholder="123456789">ISBN Number</x-input-text>

                    <x-input-text class="w-1/3"
                        name="page_count"
                        :value="old('page_count', $book->page_count)"
                        type="number"
                        placeholder="120">Page Count</x-input-text>

                </div>

                <div class="flex gap-4 mb-3">
                    <div class="flex-1">
                        <x-label>Publication Date</x-label>
                        <x-pikaday name="published_at"
                            type="date"
                            format="DD MMMM YYYY"
                            :value="old('published_at', $book->published_at)"
                            placeholder="01 January 2001"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-75" />

                        @error('published_at')
                            <p class="text-sm font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-input-select class="flex-1"
                        name="publisher_id"
                        label="Publisher"
                        placeholder="Select Publisher">
                        <option value="">-Select Publisher-</option>
                        @foreach (\App\Models\Publisher::get(['id', 'name']) as $item)
                            <option value="{{ $item->id }}"
                                {{ old('publisher_id', $book->publisher_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </x-input-select>
                </div>

                <div class="flex gap-4 mb-3">
                    <x-input-select class="flex-1"
                        multiple
                        name="writer_id[]"
                        label="Writer"
                        placeholder="Select Writer">
                        <option disabled="">Select Writer</option>
                        @foreach ($writers as $writer)
                            <option value="{{ $writer->id }}"
                                {{ in_array($writer->id, old('writer_id', $book->writers->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $writer->name }}</option>
                        @endforeach
                    </x-input-select>

                    <x-input-select class="flex-1"
                        multiple
                        name="translator_id[]"
                        label="Translator"
                        placeholder="Select Translator">
                        <option disabled
                            value="">Select Translator</option>
                        @foreach ($translators as $translator)
                            <option value="{{ $translator->id }}"
                                {{ in_array($translator->id, old('translator_id', $book->translators->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $translator->name }}</option>
                        @endforeach
                    </x-input-select>
                </div>



                <x-button type="submit"
                    class="justify-center w-full px-6 py-3">Save Book</x-button>

            </form>
        </div>
    </div>
</x-admin-layout>
