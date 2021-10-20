@extends('users.dashboard.template')

@section('content')
    <div class="text-xl mb-3">
        <p>Welcome,</p>
        <h1 class="font-sans font-semibold">{{ auth()->user()->name }}</h1>
    </div>

    <div class="card p-3 sm:p-4 max-w-xl">
        <h2 class="font-semibold text-lg mb-3">Recent Transactions</h2>
        @forelse(auth()->user()->transactions as $transaction)
            <div class="card bg-gray-100 px-3 py-2 mb-3">
                @if(class_basename($transaction->transactable_type) == 'Exchange')
                    <div class="flex gap-3">
                        <div class="self-center">
                            <div class="flex items-center justify-center text-primary-400 w-10 h-10 rounded-full border-2 border-primary-400">
                                <x-heroicon-o-book-open/>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="mb-1 flex flex-col justify-between">
                                <strong>
                                    <x-heroicon-o-currency-bangladeshi/> {{ $transaction->amount }}
                                </strong>
                                <span class="text-sm">{{ $transaction->transactable->book->name ?? 'N/A' }} &leftrightarrow; {{ $transaction->transactable->accepted_offer->book->name ?? 'N/A' }}</span>
                            </p>
                            <p class="text-sm flex flex-col justify-between">
                                <span>{{ $transaction->created_at->diffForHumans() }}</span>
                                <span>{{ $transaction->transactable->user->name ?? 'N/A' }} &leftrightarrow; {{ $transaction->transactable->accepted_offer->user->name ?? 'N/A' }}</span>
                            </p>
                        </div>
                    </div>
                @else
                    <p>Amount: {{ $transaction->amount }}</p>
                @endif
            </div>
        @empty
            <p>No transaction found.</p>
        @endforelse
    </div>
@endsection
