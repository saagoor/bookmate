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

        <div class="flex justify-between">
            <h1 class="mb-4 text-3xl font-semibold md:mb-6">{{ $title }}</h1>
            <form method="get">
                <div class="inline-flex gap-1"
                    x-data="{show: {{ request('search') ? 'true' : 'false' }}}">
                    <x-input x-show="show"
                        name="search"
                        placeholder="Search....." />
                    @if (request('search'))
                        <x-link-button color="light"
                            href="{{ url()->current() }}"
                            class="w-10 h-10 rounded-full !p-0.5">
                            <x-heroicon-o-x />
                        </x-link-button>
                    @else
                        <x-button type="button"
                            color="light"
                            class="w-10 h-10 rounded-full !p-0.5"
                            @click="show = !show">
                            <x-heroicon-o-search />
                        </x-button>
                    @endif
                </div>
            </form>
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
