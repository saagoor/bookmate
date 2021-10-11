@extends('users.dashboard.template')

@section('content')
    <div class="mb-4">
        <h1 class="text-xl font-semibold sm:text-2xl">Your Exchanges</h1>
        <p>The exchanges you have requested or has sent an offer to.</p>
    </div>

    <div class="grid max-w-2xl gap-6">
        @forelse ($exchanges as $exchange)
            <x-book-exchange-card :exchange="$exchange" />
        @empty
            <div>
                <p class="text-xl">Ooops!</p>
                <p>Sorry, no exchangable book found.</p>
            </div>
        @endforelse
    </div>

    <div class="my-6">{{ $exchanges->links() }}</div>

@endsection
