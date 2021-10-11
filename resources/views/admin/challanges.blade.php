<x-admin-layout title="Challanges"
    :show-search="true">

    <div class="container my-4">
        <h1 class="mb-3 text-xl font-semibold">Challanges</h1>
        <table class="w-full overflow-hidden text-sm bg-white border rounded-lg shadow-sm">
            <tr>
                <th class="px-2 py-1 font-semibold text-left border">ID</th>
                <th class="px-2 py-1 font-semibold text-left border">Image</th>
                <th class="px-2 py-1 font-semibold text-left border">Book Name</th>
                <th class="px-2 py-1 font-semibold text-left border">Finish At</th>
                <th class="px-2 py-1 font-semibold text-left border">Participants</th>
                <th class="px-2 py-1 font-semibold text-right border">Actions</th>
            </tr>

            @forelse ($challanges as $challange)
                <tr>
                    <td class="px-2 py-1 border">{{ $challange->id }}</td>
                    <td class="px-2 py-1 border">
                        <img class="w-10 h-10 rounded-full bg-primary-300"
                            data-src="{{ $challange->book->image_url }}">
                    </td>
                    <td class="px-2 py-1 border">{{ $challange->book->name }}</td>
                    <td class="px-2 py-1 border">{{ $challange->finish_at }}</td>
                    <td class="px-2 py-1 border">{{ $challange->participants_count }}</td>
                    <td class="px-2 py-1 border">
                        <x-admin-actions :delete="route('admin.challanges.destroy', $challange)" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-2 py-1 border"
                        colspan="7">No challanges found!</td>
                </tr>
            @endforelse
        </table>
        <div class="my-6">
            {{ $challanges->links() }}
        </div>
    </div>
</x-admin-layout>
