@php
    $title = 'eBooks Available for Exchange';
@endphp
<x-app-layout :title="$title">
    <x-slot name="actions">
        @auth
            <x-link-button class="border-gray-100 "
                           :href="route('ebooks.create')">
                <x-heroicon-s-plus class="inline w-6 h-6 mr-1"/>
                <span class="pr-2">Exchange</span>
            </x-link-button>
        @endauth
    </x-slot>

    <div class="container max-w-3xl py-6 md:py-10">

        <p class="text-lg font-semibold mb-3">
            <a href="{{ route('exchanges.index') }}">
                <x-heroicon-o-arrow-left />
                Exchange Real Books
            </a>
        </p>

        <div class="flex justify-between">
            <h1 class="text-3xl font-semibold md:mb-6">{{ $title }}</h1>
            <x-form-search/>
        </div>

        <div class="grid gap-6">
            @forelse ($ebooks as $exchange)
                <x-book-exchange-card :exchange="$exchange" :ebook="true" />
            @empty
                <div>
                    <p class="text-xl">Whoops!</p>
                    <p>Sorry, no exchangeable book found.</p>
                </div>
            @endforelse
        </div>
        <div class="my-6">{{ $ebooks->links() }}</div>
    </div>
</x-app-layout>
