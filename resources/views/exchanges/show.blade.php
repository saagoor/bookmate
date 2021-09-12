@php
$book = $exchange->book;
@endphp

<x-app-layout :title="$book->name">
    <x-slot name="title">{{ $book->name }}</x-slot>
    <x-slot name="actions">
        @auth
            <x-link-button color="light"
                class="px-4 py-2 sm:px-5 sm:py-2.5 border-primary-100"
                href="{{ route('exchanges.create') }}">
                <x-heroicon-s-plus class="-mt-0.5 mr-1" />
                <span class="pr-2">Post Request</span>
            </x-link-button>
        @endauth
    </x-slot>

    <div>
        <div class="container max-w-4xl py-6 md:py-8">
            <h3 class="mb-8 text-xl font-semibold text-center sm:text-2xl">
                @if (auth()->check() && $exchange->user_id == auth()->user()->id)
                    You have posted this book to exchannge.
                @elseif ($exchange->accepted_offer_id)
                    This book has been exchanged with another book.
                @else
                    This book is available for exchange.
                @endif
            </h3>
            <div class="flex flex-col gap-6 p-4 sm:items-start sm:p-6 md:flex-row card">
                <div class="relative flex-1">
                    <div class="absolute top-0 bottom-0 z-0 -right-5 text-primary-200 -left-5 sm:-left-6">
                        <svg preserveAspectRatio="none"
                            class="w-full h-full"
                            fill="currentColor"
                            version="1.1"
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
                                <a
                                    href="{{ route('publishers.show', $book->publisher) }}">{{ $book->publisher->name }}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    @auth
                        @if ($exchange->user_id == auth()->user()->id)
                            @php
                                $exchange->loadCount('offers');
                            @endphp
                            <div class="px-4 py-4 mb-6 sm:px-6 card">
                                <p class="mb-3 text-2xl font-bold">{{ $exchange->offers_count }} Offer Received</p>
                                <x-exchange-offers :exchange="$exchange"
                                    button-class="" />
                            </div>
                        @else
                            @if ($exchange->current_user_sent_offer)
                                <p class="p-4 mb-6 text-lg font-semibold bg-green-100 rounded-md shadow">
                                    <x-heroicon-s-check class="w-8 h-8 mr-2 border-2 rounded-full -mt-1.5 text-green-500 border-green-200"/>
                                    You have sent an exchange offer.
                                </p>
                            @endif
                            @if (!$exchange->accepted_offer_id)
                            <div class="flex flex-col gap-3 mb-6 sm:flex-row">
                                @if (!$exchange->current_user_sent_offer)
                                    <div class="flex-1"
                                        x-data="{show: {{ $errors->any() ? 'true' : 'false' }}}">
                                        <x-link-button color="light"
                                            @click.prevent="show = true"
                                            class="w-full py-3 text-base sm:text-lg">
                                            <x-heroicon-o-hand class="mr-2 -mt-0.5 transform rotate-90" />
                                            Send Offer
                                        </x-link-button>
                                        <x-modal-form :action="route('exchanges.offers.store', $exchange)"
                                            submit-text="Send Your Offer">

                                            <x-input-select-book class="mb-3"
                                                name="offered_book_id">Your Book</x-input-select-book>

                                            <x-input-select-book-condition class="mb-3"
                                                label="Book's Condition" />

                                            <x-input-text name="book_edition"
                                                placeholder="i.e 1st">Edition</x-input-text>

                                        </x-modal-form>
                                    </div>
                                @endif
                                <x-link-button class="flex-1 py-3 text-base sm:text-lg"
                                    href="#conversation">
                                    <x-heroicon-o-chat class="mr-2 -mt-0.5" />
                                    Contact Owner
                                </x-link-button>
                            </div>
                            @elseif ($exchange->accepted_offer->user_id == auth()->user()->id)
                                <div class="p-4 mb-6 leading-tight bg-green-100 rounded-md shadow">
                                    <p>You offered to exchange with 
                                        <span class="font-semibold">{{ $exchange->accepted_offer->offered_book->name ?? '' }}.</span>
                                    </p>
                                    <p>And {{ $exchange->user->name }} has accepted your exchange offer.</p>
                                </div>
                            @endif
                        @endif
                    @else
                        <div class="p-4 mb-6 sm:p-6 card">
                            <p class="text-lg">
                                Please
                                <a href="{{ route('login') }}"><span class="font-semibold">Login</span></a>
                                or
                                <a href="{{ route('register') }}"><span class="font-semibold">Register</span></a>
                                to send exchange offer.
                            </p>
                        </div>
                    @endauth
                    <div class="overflow-hidden border rounded-lg bg-primary-50">
                        <table class="w-full">
                            <tr>
                                <td class="px-4 py-2 border-t border-b">Book Condition</td>
                                <td class="px-0 py-2 border-t border-b">:</td>
                                <td class="px-4 py-2 border-t border-b">
                                    <span
                                        class="capitalize">{{ str_replace('_', ' ', $exchange->book_condition) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 border-t border-b">Edition</td>
                                <td class="px-0 py-2 border-t border-b">:</td>
                                <td class="px-4 py-2 border-t border-b">{{ $exchange->book_edition }}</td>
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
                                <td class="px-4 py-2 border-t border-b">{{ $book->category }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-4 lg:mt-6">
                        <p class="mb-1.5 font-semibold">Book's Monthly Statistics</p>
                        <div class="grid grid-cols-3 overflow-hidden border rounded-md bg-primary-50">
                            <div class="px-4 py-2 border-r">
                                <p class="text-sm">Reads</p>
                                <p class="text-lg font-semibold">{{ $book->statistics->reads ?? '00' }}</p>
                            </div>
                            <div class="px-4 py-2 border-r">
                                <p class="text-sm">Exchnage</p>
                                <p class="text-lg font-semibold">{{ $book->statistics->exchange ?? '00' }}</p>
                            </div>
                            <div class="px-4 py-2">
                                <p class="text-sm">Views</p>
                                <p class="text-lg font-semibold">{{ $book->statistics->views ?? '00' }}</p>
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

            {{-- Picture Previews --}}
            <div class="p-4 my-6 sm:p-6 card"
                x-data="{
                items: [
                    '{{ asset('images/book-cover.jpg') }}',
                    '{{ asset('images/book-cover.jpg') }}',
                    '{{ asset('images/book-cover.jpg') }}',
                    '{{ asset('images/book-cover.jpg') }}',
                ],
                show: false,
                currentIndex: 0,
            }">
                <h2 class="mb-3 text-xl font-semibold">Picture Previews</h2>
                <div class="flex flex-wrap gap-4">
                    <template x-for="(item, index) in items"
                        :key="index">
                        <img x-on:click="show = true"
                            class="w-32 cursor-pointer"
                            :data-src="item"
                            alt="Book Title">
                    </template>
                </div>
                <x-modal>
                    <div class="px-4 pt-5 pb-4 text-center bg-white sm:p-6 sm:pb-4">
                        <img class="h-full max-h-screen mx-auto"
                            :data-src="items[currentIndex]">
                    </div>
                    <div class="justify-between px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Prev
                        </button>
                        <button type="button"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Next
                        </button>
                    </div>
                </x-modal>
            </div>

            {{-- Similar Books --}}
            <div class="p-4 my-6 sm:p-6 card">
                <h2 class="mb-3 text-xl font-semibold">Similar Books</h2>
                <div class="flex flex-wrap gap-4">
                    <a href="#books/show">
                        <div>
                            <img class="w-32 cursor-pointer"
                                data-src="{{ asset('images/book-cover.jpg') }}"
                                alt="Book Title">
                            <p class="mt-1 text-sm">The Prophet</p>
                        </div>
                    </a>
                    <a href="#books/show">
                        <div>
                            <img class="w-32 cursor-pointer"
                                data-src="{{ asset('images/book-cover.jpg') }}"
                                alt="Book Title">
                            <p class="mt-1 text-sm">The Prophet</p>
                        </div>
                    </a>
                    <a href="#books/show">
                        <div>
                            <img class="w-32 cursor-pointer"
                                data-src="{{ asset('images/book-cover.jpg') }}"
                                alt="Book Title">
                            <p class="mt-1 text-sm">The Prophet</p>
                        </div>
                    </a>
                    <a href="#books/show">
                        <div>
                            <img class="w-32 cursor-pointer"
                                data-src="{{ asset('images/book-cover.jpg') }}"
                                alt="Book Title">
                            <p class="mt-1 text-sm">The Prophet</p>
                        </div>
                    </a>
                    <a href="#books/show">
                        <div>
                            <img class="w-32 cursor-pointer"
                                data-src="{{ asset('images/book-cover.jpg') }}"
                                alt="Book Title">
                            <p class="mt-1 text-sm">The Prophet</p>
                        </div>
                    </a>
                    <a href="#books/show">
                        <div>
                            <img class="w-32 cursor-pointer"
                                data-src="{{ asset('images/book-cover.jpg') }}"
                                alt="Book Title">
                            <p class="mt-1 text-sm">The Prophet</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
