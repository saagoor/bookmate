<div>
    @forelse ($exchange->offers as $offer)
        @include('exchanges._offer-card', ['offer' => $offer])
    @empty
        <p class="text-lg">No offer has been received yet.</p>
    @endforelse
</div>
