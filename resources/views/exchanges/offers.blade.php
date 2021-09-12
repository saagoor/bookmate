<div>
    @forelse ($exchange->offers as $offer)
        <div class="relative p-4 py-3 my-3 bg-gray-100 rounded-md shadow">
            <p class="font-semibold">
                <x-heroicon-o-user /> {{ $offer->user->name }}
            </p>
            <p class="font-semibold">
                <x-heroicon-o-book-open /> {{ $offer->offered_book->name }}
            </p>

            @if ($exchange->accepted_offer_id == $offer->id)
                <div class="inline-flex px-2 py-1 mt-2 text-xs font-semibold text-gray-900 bg-green-500 rounded-md">
                    <x-heroicon-o-check class="h-4 mt-0 -ml-1" /> Accepted</div>
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
                        }" class="px-2 py-1 mt-2 tracking-normal capitalize"><x-heroicon-o-check class="h-4 mt-0 -ml-1" /> Accept</x-button>
                @endif
            @endif
        </div>
    @empty
        <p class="text-lg">No offer has been received yet.</p>
    @endforelse
</div>
