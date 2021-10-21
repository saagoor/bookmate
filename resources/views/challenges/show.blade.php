<x-app-layout>

    @auth
        <x-slot name="actions">
            <x-link-button :href="route('challenges.create')">
                <x-heroicon-o-plus class="mr-1" /> Create
            </x-link-button>
        </x-slot>
    @endauth

    <div class="container py-8">

        <div class="flex items-center justify-between mb-4">

            <div>
                <p class="mb-2 text-xl font-semibold">Challenge Details</p>

                <x-right-sheet title="Invite Friend">
                    <x-slot name="trigger">
                        <x-button color="dark"
                            class="rounded-full">
                            <x-heroicon-s-user-add class="mr-1" /> Invite Friends
                        </x-button>
                    </x-slot>

                    <div class="max-w-xs"
                        x-data="{
                        users: [],
                        inviting: '',
                        invited: [],
                        search: '',
                        submit(){
                            this.users = [];
                            if(!this.search){
                                return;
                            }
                            axios.get('{{ route('users.index') }}', {
                                params: {search: this.search},
                            })
                            .then(({data}) => {
                                this.users = data.data;
                                console.log(data.data);
                            })
                            .catch((error) => {
                                alert(error);
                            });
                        },
                        sendInvitation(email){
                            if(this.invited.includes(email)){
                                this.inviting = '';
                                return;
                            }
                            this.inviting = email;
                            axios.post('{{ route('challenges.invite', $challenge) }}', {email: email})
                            .then((response) => {
                                this.invited.push(email);
                            })
                            .catch((error) => {
                                console.log(error);
                                alert(error);
                            })
                            .then(() => {
                                this.inviting = '';
                            });
                        }
                    }">
                        <p class="mb-3 leading-tight text-gray-500">Invite your friends to join this book reading challenge.</p>
                        <form action="{{ route('users.index') }}">
                            <x-input-text x-model="search"
                                name="search"
                                @input.debounce.500="submit()"
                                placeholder="mhsagor91@gmail.com">Name or Email</x-input-text>

                            <template x-if="users && users.length > 0">
                                <div
                                    class="max-w-xs py-2 overflow-y-auto bg-white border border-gray-100 rounded-lg shadow-lg max-h-60">

                                    <template x-for="user in users"
                                        :key="user.id">
                                        <a href="#"
                                            @click.prevent="sendInvitation(user.email)"
                                            class="flex items-center gap-3 px-4 py-2 border-b border-gray-100 hover:bg-primary-100">
                                            {{-- Shows loading while sending invitation --}}
                                            <template x-if="inviting == user.email">
                                                <div
                                                    class="inline-flex flex-col items-center justify-center w-12 h-12 rounded-full bg-primary-100">
                                                    <div
                                                        class="w-6 h-6 border-2 border-t-0 rounded-full border-primary-400 animate-spin">
                                                    </div>
                                                </div>
                                            </template>
                                            {{-- Shows invited after invitation sent --}}
                                            <template x-if="invited.includes(user.email) && inviting != user.email">
                                                <div
                                                    class="inline-flex flex-col items-center justify-center w-12 h-12 bg-green-200 rounded-lg">
                                                    <x-heroicon-o-check />
                                                    <span class="text-xs">Invited</span>
                                                </div>
                                            </template>
                                            {{-- Shows avatar otherwise --}}
                                            <template x-if="!invited.includes(user.email) && inviting != user.email">
                                                <img x-bind:src="user.image_url"
                                                    class="w-12 h-12 rounded-full bg-primary-100">
                                            </template>

                                            <div class="text-muted">
                                                <p class="font-bold leading-tight"
                                                    x-text="user.name"></p>
                                                <p class="text-sm leading-tight"
                                                    x-text="user.email"></p>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </template>
                        </form>
                    </div>

                    {{-- <x-slot name="footer">
                        <x-button>Send Invitation</x-button>
                    </x-slot> --}}

                </x-right-sheet>
            </div>

            <div>
                @if (!$challenge->participants->contains(auth()->user()))
                    <form action="{{ route('challenges.join', $challenge) }}"
                        method="post">
                        @csrf
                        <x-button class="text-base rounded-full">Join The Challenge</x-button>
                    </form>
                @else
                    <div class="p-4 bg-green-200 card">
                        <p class="text-lg font-semibold">You are a participant.</p>
                        <form action="{{ route('challenges.updateParticipant', $challenge) }}"
                            method="post"
                            onchange="this.submit()">
                            @csrf
                            <x-input-select name="percentage"
                                label="How much you completed reading?">
                                @foreach (range(0, 10) as $item)
                                    <option value="{{ $item * 10 }}"
                                        {{ $challenge->participants->find(auth()->user()->id)->pivot->percentage == $item * 10 ? 'selected' : '' }}>
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

                <x-countdown :expires="$challenge->finish_at"
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
                    @if ($challenge->finish_at->isAfter(now()))
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

                    <h1 class="text-xl font-semibold sm:text-3xl">
                        <a href="{{ route('books.show', $challenge->book) }}">{{ $challenge->book->name }}</a>
                    </h1>
                    <p>{{ $challenge->created_at->format('F jS') }} to {{ $challenge->finish_at->format('F jS') }}
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
                            <td class="px-1 py-1">:</td>
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
                    <tr>
                        <td>
                            <x-heroicon-o-clock class="h-4" /> Published at
                        </td>
                        <td class="px-1 py-1">:</td>
                        <td class="truncate">{{ $challenge->book->published_at->format('F jS, Y') }}</td>
                    </tr>
                </table>
                <div>
                    {{ $challenge->book->summary }}
                </div>

                <div class="grid grid-cols-3 my-6 border divide-x rounded-md">
                    <div class="p-4">
                        <p class="text-2xl font-bold">{{ $challenge->participants_count }}</p>
                        <p>Participants</p>
                    </div>
                    <div class="p-4">
                        <p class="text-2xl font-bold">
                            {{ $challenge->finishers_count }}
                        </p>
                        <p>Finishers</p>
                    </div>
                    <div class="flex items-center justify-center p-4">
                        @foreach ($challenge->participants->take(5) as $participant)
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
                    @forelse ($challenge->participants as $participant)
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
                                {{ $participant->pivot->created_at->diffInDays($participant->pivot->updated_at) ?? '?' }}
                            </td>
                        </tr>
                    @empty

                    @endforelse
                </table>

            </div>

            <div class="flex-1">
                <div>
                    {!! $challenge->description !!}
                </div>

                <h3 class="mb-3 text-lg font-semibold">Discussions</h3>

                <x-discussion :discussion="$challenge->discussion" />
            </div>
        </div>
    </div>
</x-app-layout>
