<div>
    @forelse ($exchange->offers as $offer)
        <div class="relative px-2 py-3 my-3 bg-gray-100 rounded-md shadow">
            <x-user-list-tile class="px-0"
                :user="$offer->user" />
            <hr>
            <x-list-tile class="px-0"
                :image="$offer->offered_book->cover_url"
                :rounded-image="false"
                :title="$offer->offered_book->name"
                :subtitle="$offer->offered_book->writers->pluck('name')->join(', ')" />

            @if ($exchange->accepted_offer_id == $offer->id)
                <div class="inline-flex px-2 py-1 mt-2 text-xs font-semibold text-gray-900 bg-green-500 rounded-md">
                    <x-heroicon-o-check class="h-4 mt-0 -ml-1" /> Accepted
                </div>
            @else
                @if (auth()->user()->admin)
                    <x-button x-on:click="async () => {
                            $event.target.innerText = 'Loading...';
                            $event.target.setAttribute('disabled', true);
                            axios.put('{{ route('admin.exchanges.offers.accept', [$exchange, $offer]) }}')
                                .then(response => getContents(true))
                                .catch(error => {
                                    console.log(error.message);
                                    $event.target.innerText = error.message;
                                });
                        }"
                        class="px-2 py-1 mt-2 tracking-normal capitalize">
                        <x-heroicon-o-check class="h-4 mt-0 -ml-1" /> Accept
                    </x-button>
                @endif
            @endif
        </div>
    @empty
        <p class="text-lg">No offer has been received yet.</p>
    @endforelse
</div>
