<x-app-layout :title="$book->name">

    <div class="container py-8">

        <div class="bg-white shadow-xl rounded-xl overflow-hidden flex flex-col md:flex-row mb-6">
            <div class="md:w-1/5">
                <x-img class="w-full" :src="$book->cover_url"/>
            </div>
            <div class="flex-1 p-4 md:p-6">
                <h1 class="text-2xl font-semibold mb-5">{{ $book->name }}</h1>
                <table>
                    <tr>
                        <td>Writer</td>
                        <td class="w-3">:</td>
                        <td>
                            @foreach ($book->writers as $writer)
                                @if (!$loop->first)
                                    <span> & </span>
                                @endif
                                <a href="{{ route('writers.show', $writer) }}">{{ $writer->name }}</a>
                            @endforeach
                        </td>
                    </tr>
                    @if ($book->translators->count())
                        <tr>
                            <td>Translator</td>
                            <td>:</td>
                            <td>
                                @foreach ($book->translators as $translator)
                                    @if (!$loop->first)
                                        <span> & </span>
                                    @endif
                                    <a href="{{ route('writers.show', $translator) }}">{{ $translator->name }}</a>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>ISBN</td>
                        <td>:</td>
                        <td>{{ $book->isbn }}</td>
                    </tr>
                    <tr>
                        <td>Language</td>
                        <td>:</td>
                        <td>{{ $book->language }}</td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>:</td>
                        <td>{{ $book->category }}</td>
                    </tr>
                    <tr>
                        <td>Page Count</td>
                        <td>:</td>
                        <td>{{ $book->page_count }}</td>
                    </tr>
                    <tr>
                        <td>Published At</td>
                        <td>:</td>
                        <td>{{ $book->published_at->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td>Publisher</td>
                        <td>:</td>
                        <td>{{ $book->publisher->name }}</td>
                    </tr>
                </table>
            </div>
            <div class="flex-1 md:self-center p-4 md:p-6">
                <p class="mb-2 font-semibold">Monthly Statistics</p>
                <div class="grid grid-cols-2 divide-x divide-y border rounded-md border-collapse">
                    <div class="p-4 border-collapse">
                        <p class="font-semibold">Views</p>
                        <p class="text-2xl font-semibold">{{ $book->months_views_count }}</p>
                    </div>
                    <div class="p-4 border-collapse">
                        <p class="font-semibold">Reads</p>
                        <p class="text-2xl font-semibold">{{ $book->months_reads_count }}</p>
                    </div>
                    <div class="p-4 border-collapse">
                        <p class="font-semibold">Exchanges</p>
                        <p class="text-2xl font-semibold">{{ $book->months_exchanges_count }}</p>
                    </div>
                    <div class="p-4 border-collapse">
                        <p class="font-semibold">Challenges</p>
                        <p class="text-2xl font-semibold">{{ $book->months_challenges_count }}</p>
                    </div>
                </div>
            </div>
        </div>

        <x-model-reviews :model="$book" />

    </div>

</x-app-layout>