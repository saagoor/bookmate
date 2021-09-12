<x-app-layout>

    @auth
        <x-slot name="actions">
            <x-link-button :href="route('challanges.create')">
                <x-heroicon-o-plus class="mr-1" /> Create
            </x-link-button>
        </x-slot>
    @endauth

    <div class="container py-8">

        <div class="flex items-center justify-between mb-4">

            <div>
                <p class="mb-2 text-xl font-semibold">Challange Details</p>

                <x-right-sheet title="Invite Friend">
                    <x-slot name="trigger">
                        <x-button color="dark"
                            class="rounded-full">
                            <x-heroicon-s-user-add class="mr-1" /> Invite Friends
                        </x-button>
                    </x-slot>

                    <div class="max-w-xs">
                        <p class="text-muted">Invite your friends to join this book reading challange.</p>
                        <form action="">
                            <x-input-text name="email" placeholder="mhsagor91@gmail.com">Email Address</x-input-te>

                            <template>
                                <div
                                    class="max-w-xs py-2 overflow-y-auto bg-white border border-gray-100 rounded-lg shadow-lg max-h-60">
                                    <template>
                                        {{-- <x-user-list-tile
                                class="hover:bg-cool-gray-100 cursor-pointer {{ $loop->last ? 'border-gray-50' : '' }}"
                                :user="$item"
                                wire:click="setEmail('{{ $item->email }}')"
                            /> --}}
                                    </template>
                                </div>
                            </template>
                        </form>
                    </div>

                    <x-slot name="footer">
                        <x-button>Send Invitation</x-button>
                    </x-slot>

                </x-right-sheet>
            </div>

            <div>
                @if (!$challange->participants->contains(auth()->user()))
                    <form action="{{ route('challanges.join', $challange) }}"
                        method="post">
                        @csrf
                        <x-button class="text-base rounded-full">Join The Challange</x-button>
                    </form>
                @else
                    <div class="p-4 bg-green-200 card">
                        <p class="text-lg font-semibold">You are a participant.</p>
                        <form action="{{ route('challanges.updateParticipant', $challange) }}"
                            method="post"
                            onchange="this.submit()">
                            @csrf
                            <x-input-select name="percentage"
                                label="How much you completed reading?">
                                @foreach (range(0, 10) as $item)
                                    <option value="{{ $item * 10 }}"
                                        {{ $challange->participants->find(auth()->user()->id)->pivot->percentage == $item * 10 ? 'selected' : '' }}>
                                        {{ $item * 10 }}%</option>
                                @endforeach
                            </x-input-select>
                        </form>
                    </div>
                @endif
            </div>

        </div>

        <div class="flex flex-col gap-8 px-6 py-4 bg-white sm:gap-16 sm:flex-row-reverse card">

            <div class="flex-1">

                <x-countdown :expires="$challange->finish_at"
                    class="inline-flex gap-2 p-4 mb-4 text-center rounded-md bg-primary-100">
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

                <div class="mb-3">
                    @if ($challange->finish_at->isAfter(now()))
                        <div
                            class="inline-block px-2 mb-2 py-0.5 text-sm font-semibold text-green-900 bg-green-200 rounded-full">
                            <x-heroicon-o-clock class="h-4 mr-1" />Running
                        </div>
                    @else
                        <div
                            class="inline-block px-2 mb-2 py-0.5 text-sm font-semibold text-red-900 bg-red-200 rounded-full">
                            <x-heroicon-o-clock class="h-4 mr-1" />Finished
                        </div>
                    @endif

                    <h1 class="text-xl font-semibold sm:text-3xl">{{ $challange->book->name }}</h1>
                    <p>{{ $challange->created_at->format('F jS') }} to {{ $challange->finish_at->format('F jS') }}
                    </p>
                </div>
                <p class="mb-1 font-semibold">About the Book</p>
                <table class="text-sm">
                    <tr>
                        <td>
                            <x-bi-pen-fill class="h-3" /> Writer
                        </td>
                        <td class="px-1 py-1">:</td>
                        <td class="truncate">
                            @foreach ($challange->book->writers as $writer)
                                @if (!$loop->first)
                                    <span> & </span>
                                @endif
                                <a href="{{ route('writers.show', $writer) }}">{{ $writer->name }}</a>
                            @endforeach
                        </td>
                    </tr>
                    @if ($challange->book->translators->count())
                        <tr>
                            <td>
                                <x-heroicon-s-translate class="h-4" /> Translator
                            </td>
                            <td class="px-1 py-1">:</td>
                            <td class="truncate">
                                @foreach ($challange->book->translators as $translator)
                                    @if (!$loop->first)
                                        <span> & </span>
                                    @endif
                                    <a href="{{ route('writers.show', $translator) }}">{{ $translator->name }}</a>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>
                            <x-heroicon-o-clock class="h-4" /> Published at
                        </td>
                        <td class="px-1 py-1">:</td>
                        <td class="truncate">{{ $challange->book->published_at->format('F jS, Y') }}</td>
                    </tr>
                </table>
                <div>
                    {{ $challange->book->summary }}
                </div>

                <div class="grid grid-cols-3 my-6 border divide-x rounded-md">
                    <div class="p-4">
                        <p class="text-2xl font-bold">{{ $challange->participants->count() }}</p>
                        <p>Participants</p>
                    </div>
                    <div class="p-4">
                        <p class="text-2xl font-bold">
                            {{ $challange->participants->where('pivot.percentage', 100)->count() }}
                        </p>
                        <p>Finishers</p>
                    </div>
                    <div class="flex items-center justify-center p-4">
                        @foreach ($challange->participants->take(5) as $participant)
                            <x-avatar class="w-10 h-10 -ml-3 border rounded-full bg-primary-100"
                                :search="$participant->email" />
                        @endforeach
                    </div>
                </div>

                <h2 class="mb-3 text-xl font-semibold">Leaderboard</h2>

                <table class="w-full font-semibold">
                    <tr>
                        <th class="px-2 py-1 text-left border-b-2 border-gray-default">#</th>
                        <th class="px-2 py-1 text-left border-b-2 border-gray-default">Name</th>
                        <th class="px-2 py-1 text-left border-b-2 border-gray-default">Finished</th>
                        <th class="px-2 py-1 text-left border-b-2 border-gray-default">Days Took</th>
                    </tr>
                    @forelse ($challange->participants as $participant)
                        <tr>
                            <td class="px-2 py-1 border-b">{{ $loop->iteration }}</td>
                            <td class="px-2 py-1 border-b">
                                <div class="flex items-center gap-2">
                                    <x-avatar class="w-10 h-10 border rounded-full bg-primary-100"
                                        :search="$participant->email" />
                                    <span>{{ $participant->name }}</span>
                                </div>
                            </td>
                            <td class="px-2 py-1 border-b">{{ $participant->pivot->percentage }}%</td>
                            <td class="px-2 py-1 border-b">
                                {{ $participant->pivot->created_at->diffInDays(now()) ?? '?' }}
                            </td>
                        </tr>
                    @empty

                    @endforelse
                </table>

            </div>

            <div class="flex-1">
                <div>
                    {!! $challange->description !!}
                </div>

                <h3 class="mb-3 text-lg font-semibold">Discussions</h3>
                <form action="">
                    <div class="flex gap-4 my-6">
                        <x-avatar class="w-16 h-16 border rounded-full bg-primary-100"
                            search="mhsagor91@gmail.com" />
                        <div class="flex-1">
                            <x-input-textarea class="mb-2"
                                name="comment"
                                placeholder="Share your opinion....."></x-input-textarea>
                            <x-button>Post Comment</x-button>
                        </div>
                    </div>
                </form>
                <h3 class="mb-3 text-lg font-semibold">23 Comments</h3>

                <div>
                    {{-- Comment --}}
                    <div class="flex gap-3 py-4">
                        <x-avatar class="w-10 h-10 border rounded-full bg-primary-100"
                            search="mhsaagoor" />
                        <div class="flex-1">
                            <p class="leading-tight">
                                <a href="#"><span class="font-bold">Mehedi Hassain</span></a>
                                <span>A community of freaks, who have too much free time.</span>
                            </p>
                            <div class="flex gap-3 text-sm opacity-70">
                                <x-form-button :action="route('logout')"
                                    class="hover:text-primary-600">
                                    Like
                                </x-form-button>
                                <button class="hover:text-primary-600">Reply</button>
                                <span>3h</span>
                                <span>16 likes</span>
                            </div>

                            {{-- Replies --}}
                            <div class="flex gap-3 py-4">
                                <x-avatar class="w-10 h-10 border rounded-full bg-primary-100"
                                    search="mhsaagoor" />
                                <div class="flex-1">
                                    <p class="leading-tight">
                                        <a href="#"><span class="font-bold">Mehedi Hassain</span></a>
                                        <span>A community of freaks, who have too much free time.</span>
                                    </p>
                                    <div class="flex gap-3 text-sm opacity-70">
                                        <x-form-button :action="route('logout')"
                                            class="hover:text-primary-600">
                                            Like
                                        </x-form-button>
                                        <button class="hover:text-primary-600">Reply</button>
                                        <span>3h</span>
                                        <span>16 likes</span>
                                    </div>

                                    {{-- Replies --}}
                                    <div class="pl-4">

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>


        </div>

    </div>
</x-app-layout>
