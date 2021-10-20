@php
    $title = $discussion->title . ' - ' . $discussion->discussable->name;
@endphp
<x-app-layout :title="$title">
    <x-slot name="actions">
        @auth
            <x-link-button
                    class="border-gray-100 "
                    :href="route('discussions.create')">
                <x-heroicon-s-plus class="inline w-6 h-6 mr-1"/>
                <span class="pr-2">New Discussion</span>
            </x-link-button>
        @endauth
    </x-slot>

    <div class="container max-w-3xl py-6 md:py-10">
        <x-discussion-card :discussion="$discussion"/>
        <div class="bg-white p-6 rounded-xl shadow-xl mt-6">
            <x-discussion :discussion="$discussion"/>
        </div>
    </div>
</x-app-layout>
