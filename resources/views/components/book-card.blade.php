@props(['book'])
<div class="relative overflow-hidden bg-white rounded-md shadow-xl group aspect-w-4 aspect-h-6">
    <div class="p-2">
        <x-img class="w-full h-full rounded-md"
        :src="$book->cover_url" />
    </div>
    <div
        class="absolute inset-0 flex flex-col p-4 leading-tight transition delay-100 transform scale-0 bg-white opacity-0 gap-y-2 group-hover:opacity-100 group-hover:scale-100">
        <h2 class="font-semibold">{{ $book->name }}</h2>
        <div class="text-sm">
            <p>
                Writer:
                @foreach ($book->writers as $writer)
                    @if (!$loop->first)
                        <span> & </span>
                    @endif
                    <a href="{{ route('writers.show', $writer) }}">{{ $writer->name }}</a>
                @endforeach
            </p>
        </div>
        <p class="text-xs">Category: {{ $book->category }}</p>
        <div class="text-primary-500">
            <x-ratings :rating="$book->reviews_avg_rating" />
        </div>
        <x-link-button class="mt-auto" :href="route('books.show', $book)">View Details</x-link-button>
    </div>
</div>