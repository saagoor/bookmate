@props(['discussion'])

<div class="bg-white shadow-lg p-6 rounded-xl">
    <h2 class="mb-3 font-semibold text-lg">
        <a href="{{ route('discussions.show', $discussion) }}">{{ $discussion->title }}</a>
    </h2>
    <div class="flex justify-between text-sm mb-3">
        <x-list-tile
                :title="$discussion->discussable->name"
                :image="$discussion->discussable->cover_url"
                :subtitle="$discussion->discussable->writer"
                :rounded-image="false"
                class="!p-0 border-none"
        />
        <x-user-list-tile :user="$discussion->user" class="!p-0 border-none" />
        <div class="text-right">
            <p>{{ $discussion->created_at->diffForHumans() }}</p>
            <p>{{ $discussion->comments_count }} Comments</p>
        </div>
    </div>
    <div class="prose prose-sm max-w-full">
        <x-markdown>
        {!! $discussion->body !!}
        </x-markdown>
    </div>
</div>