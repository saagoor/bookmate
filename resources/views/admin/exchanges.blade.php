<x-admin-layout title="Exchanges"
    :show-search="true">

    <div class="container my-4">
        <h1 class="mb-3 text-xl font-semibold">Exchanges</h1>
        <table class="w-full overflow-hidden text-sm bg-white border rounded-lg shadow-sm">
            <tr>
                <th class="px-2 py-1 font-semibold text-left border">ID</th>
                <th class="px-2 py-1 font-semibold text-left border">User</th>
                <th class="px-2 py-1 font-semibold text-left border">Book</th>
                <th class="px-2 py-1 font-semibold text-left border">Expected Book</th>
                <th class="px-2 py-1 font-semibold text-left border">Book Condition</th>
                <th class="px-2 py-1 font-semibold text-left border">Offers Received</th>
                <th class="px-2 py-1 font-semibold text-right border">Actions</th>
            </tr>

            @forelse ($exchanges as $exchange)
                <tr>
                    <td class="px-2 py-1 border">{{ $exchange->id }}</td>
                    <td class="px-2 py-1 border">{{ $exchange->user->name }}</td>
                    <td class="px-2 py-1 font-semibold border">
                        <a
                            href="{{ route('admin.exchanges', ['book' => $exchange->book_id]) }}">{{ $exchange->book->name }}</a>
                    </td>
                    <td class="px-2 py-1 border">
                        <a
                            href="{{ route('admin.exchanges', ['book' => $exchange->expected_book_id]) }}">{{ $exchange->expected_book->name }}</a>
                    </td>
                    <td class="px-2 py-1 capitalize border">
                        {{ str_replace('_', ' ', $exchange->book_condition) }}
                    </td>
                    <td class="px-2 py-1 border">{{ $exchange->offers_count }}</td>
                    <td class="px-2 py-1 border">
                        <x-admin-actions :delete="route('admin.exchanges.destroy', $exchange)"
                            class="flex-row-reverse !justify-start !gap-2">
                            <x-exchange-offers :exchange="$exchange" />
                        </x-admin-actions>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-2 py-4 text-base font-semibold text-center border opacity-75"
                        colspan="7">Sorry, No exchange data found!</td>
                </tr>
            @endforelse
        </table>
        <div class="my-6">
            {{ $exchanges->links() }}
        </div>
    </div>
</x-admin-layout>
