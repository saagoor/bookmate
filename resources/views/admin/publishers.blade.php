<x-admin-layout title="Publishers" :show-search="true">
        
    <x-slot name="actions">
        <x-link-button :href="route('admin.publishers.create')"><x-heroicon-o-plus class="h-5 -mt-0.5 mr-1" />Add New</x-link-button>
    </x-slot>

    <div class="container my-4">
        <h1 class="mb-3 text-xl font-semibold">Publishers</h1>
        <table class="w-full overflow-hidden text-sm bg-white border rounded-lg shadow-sm">
            <tr>
                <th class="px-2 py-1 font-semibold text-left border">ID</th>
                <th class="px-2 py-1 font-semibold text-left border">Image</th>
                <th class="px-2 py-1 font-semibold text-left border">Name</th>
                <th class="px-2 py-1 font-semibold text-left border">Location</th>
                <th class="px-2 py-1 font-semibold text-left border">Email</th>
                <th class="px-2 py-1 font-semibold text-left border">Phone</th>
                <th class="px-2 py-1 font-semibold text-right border">Actions</th>
            </tr>

            @forelse ($publishers as $publisher)
                <tr>
                    <td class="px-2 py-1 border">{{ $publisher->id }}</td>
                    <td class="px-2 py-1 border"><img class="h-10 rounded" data-src="{{ $publisher->image_url }}"></td>
                    <td class="px-2 py-1 border">{{ $publisher->name }}</td>
                    <td class="px-2 py-1 border">{{ $publisher->location }}</td>
                    <td class="px-2 py-1 border">{{ $publisher->email }}</td>
                    <td class="px-2 py-1 border">{{ $publisher->phone }}</td>
                    <td class="px-2 py-1 border">
                        <x-admin-actions
                            :delete="route('admin.publishers.destroy', $publisher)"
                            :edit="route('admin.publishers.edit', $publisher)" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-2 py-1 border"
                        colspan="7">No publishers found!</td>
                </tr>
            @endforelse
        </table>
        <div class="my-6">
            {{ $publishers->links() }}
        </div>
    </div>
</x-admin-layout>
