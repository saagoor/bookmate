@props(['challenge'])
<div class="flex flex-col md:flex-row-reverse gap-4">
    <div class="flex flex-1 overflow-hidden card">
        <div>
            <x-img class="min-h-full w-36 h-44"
                :src="$challenge->book->cover_url" />
        </div>
        <div class="flex flex-col flex-1 p-4">
            <h2 class="mb-2 text-lg font-semibold">{{ $challenge->book->name }}</h2>
            <table class="self-start text-xs">
                <tr>
                    <td>
                        <x-bi-pen-fill class="h-3" /> Writer
                    </td>
                    <td class="px-1">:</td>
                    <td class="truncate">
                        @foreach ($challenge->book->writers as $writer)
                            @if (!$loop->first)
                                <span> & </span>
                            @endif
                            <a href="{{ route('writers.show', $writer) }}">{{ $writer->name }}</a>
                        @endforeach
                    </td>
                </tr>
                @if ($challenge->book->translators->count())
                    <tr>
                        <td>
                            <x-heroicon-s-translate class="h-4" /> Translator
                        </td>
                        <td class="px-1">:</td>
                        <td class="truncate">
                            @foreach ($challenge->book->translators as $translator)
                                @if (!$loop->first)
                                    <span> & </span>
                                @endif
                                <a href="{{ route('writers.show', $translator) }}">{{ $translator->name }}</a>
                            @endforeach
                        </td>
                    </tr>
                @endif
            </table>
            <div class="my-3">
                <x-link-button color="dark"
                    class="px-2 py-1"
                    :href="route('challenges.show', $challenge)">
                    View Details
                </x-link-button>
            </div>
            <div class="flex justify-between mt-auto text-sm">
                <p>{{ $challenge->finish_at->diffForHumans() }}.</p>
                <div class="flex justify-end gap-3">
                    <form method="POST">
                        @csrf
                        <button type="submit"
                            class="hover:text-primary-400">
                            <x-heroicon-o-heart />
                        </button> {{ $challenge->discussion->likes_count ?? '0' }}
                    </form>
                    <a href="{{ route('challenges.show', $challenge) }}">
                        <x-bi-chat-left-dots /> {{ $challenge->discussion->comments_count }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col p-4 bg-primary-200 sm:w-1/3 card">
        <x-countdown :expires="$challenge->finish_at"
            class="flex gap-2 text-center">
            <div>
                <p class="px-4 py-2 mb-1 font-bold rounded-full bg-primary-300">
                    <span x-text="timer.days">{{ $component->days() }}</span>
                </p>
                <p class="text-xs">Days</p>
            </div>
            <div>
                <p class="px-4 py-2 mb-1 font-bold rounded-full bg-primary-300">
                    <span x-text="timer.hours">{{ $component->hours() }}</span>
                    :
                    <span x-text="timer.minutes">{{ $component->minutes() }}</span>
                    :
                    <span x-text="timer.seconds">{{ $component->seconds() }}</span>
                </p>
                <p class="text-xs">Hrs &nbsp;&nbsp; Min &nbsp;&nbsp; Sec</p>
            </div>
        </x-countdown>
        <div class="flex items-center gap-2 mt-auto font-semibold">
            @php
                $participants = $challenge->participants->take(3);
            @endphp
            <div class="flex flex-row-reverse pl-4">
                @foreach ($participants->reverse() as $participant)
                    <x-avatar class="w-8 h-8 -ml-3 rounded-full"
                        :search="$participant->email" />
                @endforeach
            </div>
            <p class="text-xs truncate">
                {{ $participants->pluck('name')->map(fn($name) => Str::before($name, ' '))->join(', ', ' & ') }}
                joined
            </p>
        </div>
    </div>
</div>
