@props(['exchange'])
<div class="relative overflow-hidden text-sm rounded-md shadow bg-primary-50">

    @if ($exchange->accepted_offer_id)
        <div class="absolute top-0 right-0 px-4 py-2 text-xs font-semibold bg-primary-200 text-primary-900">
            Exchanged
        </div>
    @endif

    <div class="flex">
        <div class="w-1/5">
            <a href="{{ route('exchanges.show', $exchange) }}">
                <x-img class="w-full h-full"
                    src="{{ $exchange->book->cover_url }}"
                    alt="{{ $exchange->book->name }}" />
            </a>
        </div>
        <div class="flex flex-col justify-between flex-1">
            <div class="p-4 my-auto">
                <h3 class="mb-1 text-base font-semibold md:text-lg">
                    <a title="View the book" href="{{ route('books.show', $exchange->book_id) }}">{{ $exchange->book->name }}</a>
                </h3>
                <table>
                    <tr>
                        <td>
                            <x-bi-pen-fill /> Writer
                        </td>
                        <td class="px-1">:</td>
                        <td>
                            @foreach ($exchange->book->writers as $writer)
                                @if (!$loop->first)
                                    <span> & </span>
                                @endif
                                <a href="{{ route('writers.show', $writer) }}">{{ $writer->name }}</a>
                            @endforeach
                        </td>
                    </tr>
                    @if ($exchange->book->translators->count())
                        <tr>
                            <td>
                                <x-heroicon-s-translate /> Translator
                            </td>
                            <td class="px-1">:</td>
                            <td>
                                @foreach ($exchange->book->translators as $translator)
                                    @if (!$loop->first)
                                        <span> & </span>
                                    @endif
                                    <a href="{{ route('writers.show', $translator) }}">{{ $translator->name }}</a>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    <tr class="font-semibold text-primary-500">
                        <td>
                            <x-heroicon-s-book-open /> Condition
                        </td>
                        <td class="px-1">:</td>
                        <td class="capitalize">{{ str_replace('_', ' ', $exchange->book_condition) }}</td>
                    </tr>
                </table>
            </div>
            <div class="flex justify-between border-t justify-self-end">
                <div class="flex-1 px-4 py-2 border-r">
                    <p class="text-sm opacity-70">Owner</p>
                    <p class="truncate">
                        <a href="{{ route('users.show', $exchange->user) }}">
                            <x-heroicon-s-user /> {{ $exchange->user->name }}
                        </a>
                    </p>
                </div>
                <div class="flex-1 px-4 py-2 border-r">
                    <p class="text-sm opacity-70">Book Rating</p>
                    <p>
                        <x-heroicon-s-star />
                        <x-heroicon-s-star />
                        <x-heroicon-s-star />
                        <x-heroicon-s-star />
                        <x-heroicon-o-star />
                    </p>
                </div>
                <div class="flex-1">
                    <x-link-button color="light"
                        class="w-full h-full !text-base font-semibold rounded-none rounded-br-md"
                        href="{{ route('exchanges.show', $exchange) }}">View Details
                    </x-link-button>
                </div>
            </div>
        </div>
    </div>
</div>
