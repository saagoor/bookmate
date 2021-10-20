@php
    $title = 'Start a Discussion';
@endphp
<x-app-layout :title="$title">
    <div class="container max-w-xl py-6 md:py-10">
        <div class="bg-white p-6 rounded-xl shadow-xl mt-6">
            <h1 class="text-xl font-semibold mb-3">{{ $title }}</h1>
            <form action="{{ route('discussions.store') }}" method="post">
                @csrf
                <x-input-select-book
                        :books="App\Models\Book::getForSelector()"
                        name="book_id"
                        class="mb-3"
                        placeholder="Select Book"
                >Select Book
                </x-input-select-book>

                <x-input-text name="title" class="mb-3" placeholder="Discussion Title">Title</x-input-text>

                <div>
                    <x-label class="mb-1">Discussion Text</x-label>
                    <x-easy-mde name="body" :options="['minHeight' => '150px']"/>
                    @error('body')
                        <p class="-mt-2 mb-3 text-sm font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <x-button>Start Discussion</x-button>
            </form>
        </div>
    </div>
</x-app-layout>
