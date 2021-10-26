<div class="relative px-2 py-3 my-3 bg-gray-100 rounded-md shadow">
    <x-user-list-tile
            class="px-0"
            :user="$offer->user"/>
    <hr>
    <x-list-tile
            class="px-0"
            :image="$offer->book->cover_url"
            :rounded-image="false"
            :title="$offer->book->name"
            :subtitle="$offer->book->writers->pluck('name')->join(', ')"/>

    @if (!$exchange->is_ebook)
        <p class="text-sm">Book Worth: {{ $offer->book_worth }}</p>
        @php
            $worth_calculation = $exchange->book_worth - $offer->book_worth;
        @endphp
        @if($worth_calculation > 0)
            <p class="text-sm">You will get extra: {{ $worth_calculation }}</p>
        @else
            <p class="text-sm">You will have to pay extra: {{ abs($worth_calculation) }}</p>
        @endif
        <p class="text-sm font-semibold">{{ round($offer->distance, 1) }} Km away from here.</p>
    @endif

    @if ($exchange->accepted_offer_id == $offer->id)
        <div class="flex items-center gap-2 mt-2">
            @if (auth()->user()->admin || auth()->user()->id == $exchange->user_id)
                @if(!$exchange->complete && !$exchange->is_ebook)
                    <form action="{{ route('exchanges.offers.reject', [$exchange, $offer]) }}" method="post">
                        @csrf
                        <x-button
                                color="gray"
                                onclick="return confirm('Are you sure?')"
                                class="font-heading">
                            <x-heroicon-s-x class="h-4 mt-0 -ml-1 mr-1"/>
                            Reject
                        </x-button>
                    </form>
                @endif
                <x-button
                        type="button"
                        x-on:click='openConversation({{ $offer->user }})'
                        class="font-heading">
                    <x-heroicon-o-chat class="mr-2"/>
                    Message
                </x-button>
            @endif
        </div>
    @else
        @if (auth()->user()->admin || auth()->user()->id == $exchange->user_id)
            <form action="{{ route(($exchange->is_ebook ? 'ebooks.offers.accept' : 'exchanges.offers.accept'), [$exchange, $offer]) }}"
                  method="post">
                @csrf
                <x-button class="px-2 py-1 mt-2 tracking-normal capitalize">
                    <x-heroicon-o-check class="h-4 mt-0 -ml-1"/>
                    Accept
                </x-button>
            </form>
        @endif
    @endif
</div>