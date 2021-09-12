@php
$title = 'Reading Challanges';
@endphp
<x-app-layout :title="$title">

    @auth
        <x-slot name="actions">
            <x-link-button :href="route('challanges.create')">
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
                    <span class="relative {{ request('completed') ? 'opacity-50' : '' }}">Active & Upcoming <span
                            class="absolute inline-flex items-center justify-center w-8 h-8 text-lg rounded-full -right-6 -top-6 bg-primary-400">5</span>
                    </span>
                </a>

                <a href="{{ url()->current() }}?completed=true">
                    <span class="relative {{ !request('completed') ? 'opacity-50' : '' }}">Completed <span
                            class="absolute inline-flex items-center justify-center w-8 h-8 text-lg rounded-full -right-6 -top-6 bg-primary-400">0</span></span>
                </a>
            </h2>

        </div>

        <div class="flex flex-col gap-6">

            @foreach ($challanges as $challange)
                <x-challange-card :challange="$challange" />
            @endforeach

        </div>

        <div class="my-6">
            {{ $challanges->links() }}
        </div>

    </div>
</x-app-layout>
