@php
$title = 'Reading Challenges';
@endphp
<x-app-layout :title="$title">

    @auth
        <x-slot name="actions">
            <x-link-button :href="route('challenges.create')">
                <x-heroicon-o-plus class="mr-1" /> Create
            </x-link-button>
        </x-slot>
    @endauth

    <div class="container max-w-4xl my-6 sm:my-8">

        <h1 class="mb-4 text-xl font-semibold opacity-50">{{ $title }}</h1>

        <div class="flex items-start justify-between mb-6">
            <h2 class="text-xl font-semibold md:text-2xl">
                
                <a href="{{ url()->current() }}"
                    class="mr-12 default">
                    <span class="relative {{ request('participated') ? 'opacity-50' : '' }}">
                        <span>New & Upcoming</span>
                        @if ($new_count)
                        <span
                            class="absolute inline-flex items-center justify-center w-8 h-8 text-lg rounded-full -right-6 -top-6 bg-primary-400">
                            {{ $new_count }}
                        </span>
                        @endif
                    </span>
                </a>

                @auth
                <a href="{{ url()->current() }}?participated=true">
                    <span class="relative {{ !request('participated') ? 'opacity-50' : '' }}">
                        <span>Participated</span>
                        @if ($participated_count)
                        <span
                            class="absolute inline-flex items-center justify-center w-8 h-8 text-lg rounded-full -right-6 -top-6 bg-primary-400">
                            {{ $participated_count }}
                        </span>
                        @endif
                    </span>
                </a>
                @endauth
                
            </h2>

            <x-form-search />

        </div>

        <div class="flex flex-col gap-6">

            @foreach ($challenges as $challenge)
                <x-challenge-card :challenge="$challenge" />
            @endforeach

        </div>

        <div class="my-6">
            {{ $challenges->links() }}
        </div>

    </div>
</x-app-layout>
