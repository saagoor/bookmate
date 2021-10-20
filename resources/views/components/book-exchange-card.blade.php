@props(['exchange', 'ebook' => false])

@php
    $label = '';

    if($exchange->complete){
        $label = 'Exchange Complete';
    }else if ($exchange->accepted_offer_id) {
        if (auth()->check() && $exchange->accepted_offer->user_id == auth()->user()->id) {
            $label = 'Offer Accepted';
        } elseif ($exchange->user_id == auth()->user()->id) {
            $label = $exchange->offers_count . ' Offers';
        } else {
            $label = 'Not Available';
        }
    } elseif ($exchange->current_users_offer) {
        $label = 'Offer Sent';
    } else {
        $label = $exchange->offers_count . ' Offers';
    }

@endphp

<div class="relative overflow-hidden text-sm rounded-md shadow bg-primary-50">

    @if ($label)
        <div class="absolute rounded-bl-md top-0 right-0 px-4 py-2 text-xs font-semibold text-gray-900 bg-blue-200">
            {{ $label }}
        </div>
    @endif

    <div class="flex">
        <div class="{{ $ebook ? 'w-1/6' : 'w-1/5' }}">
            <a href="{{ route('exchanges.show', $exchange) }}">
                <x-img class="w-full h-full"
                       src="{{ $exchange->book->cover_url }}"
                       alt="{{ $exchange->book->name }}"/>
            </a>
        </div>
        <div class="flex flex-col justify-between flex-1">
            <div class="p-4 my-auto">
                <h3 class="mb-1 text-base font-semibold md:text-lg">
                    <a title="View the book"
                       href="{{ route('books.show', $exchange->book_id) }}">{{ $exchange->book->name }}</a>
                </h3>
                <table>
                    <tr>
                        <td>
                            <x-bi-pen-fill/>
                            Writer
                        </td>
                        <td class="px-1">:</td>
                        <td>
                            @foreach ($exchange->book->writers as $writer)
                                @if (!$loop->first)
                                    <span> & </span>
                                @endif
                                <a href="{{ route('writers.show', $writer) }}">{{ $writer->name }}</a>
                            @endforeach
                        </td>
                    </tr>
                    @if ($exchange->book->translators->count())
                        <tr>
                            <td>
                                <x-heroicon-s-translate/>
                                Translator
                            </td>
                            <td class="px-1">:</td>
                            <td>
                                @foreach ($exchange->book->translators as $translator)
                                    @if (!$loop->first)
                                        <span> & </span>
                                    @endif
                                    <a href="{{ route('writers.show', $translator) }}">{{ $translator->name }}</a>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    @if (!$ebook)
                        <tr class="font-semibold text-primary-500">
                            <td>
                                <x-heroicon-s-book-open/>
                                Book Worth
                            </td>
                            <td class="px-1">:</td>
                            <td class="capitalize">{{ $exchange->book_worth }}</td>
                        </tr>
                    @endif
                </table>
            </div>
            <div class="flex justify-between border-t justify-self-end">
                <div class="flex-1 px-4 py-2 border-r">
                    <p class="text-sm opacity-70">Book Owner</p>
                    <p class="truncate">
                        <a href="{{ route('users.show', $exchange->user) }}">
                            <x-heroicon-s-user/> {{ $exchange->user->name }}
                        </a>
                    </p>
                </div>
                <div class="flex-1 px-4 py-2 border-r">
                    <p class="text-sm opacity-70">Book Rating</p>
                    <p>
                        <x-ratings :rating="$exchange->book->reviews_avg_rating"/>
                    </p>
                </div>
                <div class="flex-1">
                    <x-link-button
                            color="light"
                            class="w-full h-full !text-base font-semibold rounded-none rounded-br-md"
                            href="{{ route(($ebook ? 'ebooks.show' : 'exchanges.show'), $exchange) }}">View Details
                    </x-link-button>
                </div>
            </div>
        </div>
    </div>
</div>
