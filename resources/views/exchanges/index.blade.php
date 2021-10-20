@php
$title = 'Books Available for Exchange';
@endphp
<x-app-layout :title="$title">
    <x-slot name="actions">
        @auth
            <x-link-button class="border-gray-100 "
                :href="route('exchanges.create')">
                <x-heroicon-s-plus class="inline w-6 h-6 mr-1" />
                <span class="pr-2">Post Request</span>
            </x-link-button>
        @endauth
    </x-slot>

    <div class="container max-w-3xl py-6 md:py-10">

        <p class="text-lg font-semibold mb-3">
            <a href="{{ route('ebooks.index') }}">Exchange eBooks <x-heroicon-o-arrow-right /></a>
        </p>

        <div class="flex justify-between">
            <h1 class="text-3xl font-semibold md:mb-6">{{ $title }}</h1>
            <x-form-search />
        </div>


        <div class="grid gap-6">
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
    </div>
</x-app-layout>
