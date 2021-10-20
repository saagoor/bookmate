@php
    $book = $exchange->book;
@endphp

<x-app-layout :title="$book->name">
    <x-slot name="title">{{ $book->name }}</x-slot>
    <x-slot name="actions">
        @auth
            <x-link-button
                    color="light"
                    class="px-4 py-2 sm:px-5 sm:py-2.5 border-primary-100"
                    href="{{ route('ebooks.create') }}">
                <x-heroicon-s-plus class="-mt-0.5 mr-1"/>
                <span class="pr-2">Post Request</span>
            </x-link-button>
        @endauth
    </x-slot>

    <div>
        <div class="container max-w-4xl py-6 md:py-8">
            <h3 class="mb-8 text-xl font-semibold text-center sm:text-2xl">
                @if (auth()->check() && $exchange->user_id == auth()->user()->id)
                    You have posted this eBook to exchange.
                @elseif ($exchange->accepted_offer_id)
                    This eBook has been exchanged with another eBook.
                @else
                    This eBook is available for exchange.
                @endif
            </h3>
            <div class="flex flex-col gap-6 lg:gap-10 p-4 sm:items-start sm:p-6 md:flex-row card">
                <div class="relative flex-1">
                    @if ($book->cover)
                        <x-img class="w-full rounded-lg"
                               :src="$book->cover_url"/>
                    @else
                        <div class="absolute top-0 bottom-0 z-0 -right-5 text-primary-200 -left-5 sm:-left-6">
                            <svg preserveAspectRatio="none"
                                 class="w-full h-full"
                                 fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 32 32">
                                <title>book</title>
                                <path
                                        d="M28 4v26h-21c-1.657 0-3-1.343-3-3s1.343-3 3-3h19v-24h-20c-2.2 0-4 1.8-4 4v24c0 2.2 1.8 4 4 4h24v-28h-2z">
                                </path>
                                <path
                                        d="M7.002 26v0c-0.001 0-0.001 0-0.002 0-0.552 0-1 0.448-1 1s0.448 1 1 1c0.001 0 0.001-0 0.002-0v0h18.997v-2h-18.997z">
                                </path>
                            </svg>
                        </div>

                        <div class="relative z-10 flex flex-col justify-between w-2/3 pt-16 pb-40 pl-14 h-3/4 gap-y-14">
                            <h1 class="text-3xl italic font-black">{{ $book->name }}</h1>
                            <div>
                                <p class="text-sm">Written By</p>
                                @foreach ($book->writers as $writer)
                                    <p class="font-semibold">
                                        <a href="{{ route('writers.show', $writer) }}">{{ $writer->name }}</a>
                                    </p>
                                @endforeach
                            </div>
                            <div>
                                <p class="text-sm">Published By</p>
                                <p class="font-semibold">
                                    <a href="{{ route('publishers.show', $book->publisher) }}">{{ $book->publisher->name }}</a>
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="my-10">
                        <p class="text-lg font-semibold mb-3">Share on Social Media</p>
                        <x-social-share title="Exchange - {{ $book->name}}" :url="url()->current()"/>
                    </div>
                </div>
                <div class="flex-1">
                    @include('ebooks._exchange_status')
                    <div class="overflow-hidden border rounded-lg bg-primary-50">
                        @if ($book->cover)
                            <div class="flex flex-col gap-3 p-4">
                                <h1 class="text-3xl italic font-black">{{ $book->name }}</h1>
                                <div>
                                    <p class="text-sm">Written By</p>
                                    @foreach ($book->writers as $writer)
                                        <p class="font-semibold">
                                            <a href="{{ route('writers.show', $writer) }}">{{ $writer->name }}</a>
                                        </p>
                                    @endforeach
                                </div>
                                <div>
                                    <p class="text-sm">Published By</p>
                                    <p class="font-semibold">
                                        <a href="{{ route('publishers.show', $book->publisher) }}">{{ $book->publisher->name }}</a>
                                    </p>
                                </div>
                            </div>
                        @endif
                        <table class="w-full">
                            <tr>
                                <td class="px-4 py-2 border-t border-b">Edition</td>
                                <td class="px-0 py-2 border-t border-b">:</td>
                                <td class="px-4 py-2 border-t border-b">{{ $exchange->book_edition ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 border-t border-b">Language</td>
                                <td class="px-0 py-2 border-t border-b">:</td>
                                <td class="px-4 py-2 border-t border-b">{{ $book->language }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 border-t border-b">Publication Date</td>
                                <td class="px-0 py-2 border-t border-b">:</td>
                                <td class="px-4 py-2 border-t border-b">
                                    {{ $book->published_at ? $book->published_at->format('d F Y') : '' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 border-t border-b">ISBN</td>
                                <td class="px-0 py-2 border-t border-b">:</td>
                                <td class="px-4 py-2 border-t border-b">{{ $book->isbn }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 border-t border-b">Category</td>
                                <td class="px-0 py-2 border-t border-b">:</td>
                                <td class="px-4 py-2 border-t border-b">
                                    <span class="capitalize">{{ $book->category }}</span>
                                </td>
                            </tr>
                            @if($exchange->expected_book_id && $exchange->expected_book)
                                <tr>
                                    <td class="px-4 py-2 border-t border-b">Expected Book</td>
                                    <td class="px-0 py-2 border-t border-b">:</td>
                                    <td class="px-4 py-2 border-t border-b">{{ $exchange->expected_book->name }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="mt-4 lg:mt-6">
                        <p class="mb-1.5 font-semibold">Book's Monthly Statistics</p>
                        <div class="grid grid-cols-3 overflow-hidden border rounded-md bg-primary-50">
                            <div class="px-4 py-2 border-r">
                                <p class="text-sm">Reads</p>
                                <p class="text-lg font-semibold">{{ $book->months_reads_count ?? '00' }}</p>
                            </div>
                            <div class="px-4 py-2 border-r">
                                <p class="text-sm">Exchange</p>
                                <p class="text-lg font-semibold">{{ $book->months_exchanges_count ?? '00' }}</p>
                            </div>
                            <div class="px-4 py-2">
                                <p class="text-sm">Views</p>
                                <p class="text-lg font-semibold">{{ $book->months_views_count ?? '00' }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Book Summary --}}
            <div class="p-4 my-6 sm:p-6 card">
                <h2 class="mb-3 text-xl font-semibold">Book Summary</h2>
                @if ($book->string)
                    <details>
                        {!! '<summary>' . substr_replace($book->summary, '</summary>', 50) !!}
                    </details>
                @else
                    <p>No summary added for this book.</p>
                @endif
            </div>

            {{-- Similar Books --}}
            <div class="p-4 my-6 sm:p-6 card">
                <h2 class="mb-3 text-xl font-semibold">Similar Books</h2>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                    @forelse ($similar_books as $book)
                        <x-book-card :book="$book"/>
                    @empty
                        <p>Sorry, no similar book has been found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
