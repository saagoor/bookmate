<x-admin-layout title="Books"
    :show-search="true">

    <x-slot name="actions">
        <x-link-button :href="route('admin.books.create')">
            <x-heroicon-o-plus class="h-5 -mt-0.5 mr-1" />Add New
        </x-link-button>
    </x-slot>

    <div class="container my-4">
        <h1 class="mb-3 text-xl font-semibold">Books</h1>
        <table class="w-full overflow-hidden text-sm bg-white border rounded-lg shadow-sm">
            <tr>
                <th class="px-2 py-1 font-semibold text-left border">ID</th>
                <th class="px-2 py-1 font-semibold text-left border">Cover</th>
                <th class="px-2 py-1 font-semibold text-left border">Name</th>
                <th class="px-2 py-1 font-semibold text-left border">Category</th>
                <th class="px-2 py-1 font-semibold text-left border">Writer</th>
                <th class="px-2 py-1 font-semibold text-left border">Translator</th>
                <th class="px-2 py-1 font-semibold text-left border">Publisher</th>
                <th class="px-2 py-1 font-semibold text-left border">Language</th>
                <th class="px-2 py-1 font-semibold text-right border">Actions</th>
            </tr>

            @forelse ($books as $book)
                <tr>
                    <td class="px-2 py-1 border">{{ $book->id }}</td>
                    <td class="px-2 py-1 border">
                        <img class="h-10 rounded"
                            data-src="{{ $book->cover_url }}">
                    </td>
                    <td class="px-2 py-1 border">{{ $book->name }}</td>
                    <td class="px-2 py-1 border"><a
                            href="{{ request()->fullUrlWithQuery(['category' => $book->category]) }}">{{ $book->category }}</a>
                    </td>
                    <td class="px-2 py-1 border">
                        @foreach ($book->writers as $writer)
                            <p><a
                                    href="{{ request()->fullUrlWithQuery(['writer' => $writer->id]) }}">{{ $writer->name }}</a>
                            </p>
                        @endforeach
                    </td>
                    <td class="px-2 py-1 border">
                        @forelse ($book->translators as $translator)
                            <p><a
                                    href="{{ request()->fullUrlWithQuery(['translator' => $translator->id]) }}">{{ $translator->name }}</a>
                            </p>
                        @empty
                            <p>N/A</p>
                        @endforelse
                    </td>
                    <td class="px-2 py-1 border">
                        <a
                            href="{{ request()->fullUrlWithQuery(['publisher' => $book->publisher->id]) }}">{{ $book->publisher->name }}</a>
                    </td>
                    <td class="px-2 py-1 capitalize border">{{ $book->language }}</td>
                    <td class="px-2 py-1 border">

                        <x-admin-actions :delete="route('admin.books.destroy', $book)"
                            :edit="route('admin.books.edit', $book)">
                            <button class="w-20 px-2 py-1.5 text-xs font-semibold rounded-md bg-primary-200 transition"
                                x-data="bookPriceFetcher"
                                x-on:click="getPrice({{ $book->id }})">
                                <span x-show="!loading" x-ref="price">Get Price</span>
                                <span x-show="loading"
                                    x-cloak
                                    class="block w-3 h-3 mx-auto bg-gray-900 rounded-full animate-ping"></span>
                            </button>
                        </x-admin-actions>

                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-2 py-2 border"
                        colspan="7">No books found!</td>
                </tr>
            @endforelse
        </table>
        <div class="my-6">
            {{ $books->links() }}
        </div>
    </div>
</x-admin-layout>
