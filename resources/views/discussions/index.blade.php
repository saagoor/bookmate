@php
    $title = 'Discussions';
@endphp
<x-app-layout :title="$title">
    <x-slot name="actions">
        @auth
            <x-link-button class="border-gray-100 "
                           :href="route('discussions.create')">
                <x-heroicon-s-plus class="inline w-6 h-6 mr-1" />
                <span class="pr-2">New Discussion</span>
            </x-link-button>
        @endauth
    </x-slot>

    <div class="container max-w-3xl py-6 md:py-10">

        <div class="flex justify-between">
            <h1 class="mb-4 text-3xl font-semibold md:mb-6">{{ $title }}</h1>
            <x-form-search />
        </div>

        <div class="grid gap-6">
            @forelse ($discussions as $discussion)
                <x-discussion-card :discussion="$discussion" />
            @empty
                <div>
                    <p class="text-xl">Ooops!</p>
                    <p>Sorry, no discussion found.</p>
                </div>
            @endforelse
        </div>
        <div class="my-6">{{ $discussions->links() }}</div>
    </div>
</x-app-layout>
