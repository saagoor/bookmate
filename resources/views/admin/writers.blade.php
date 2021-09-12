<x-admin-layout title="Writers" :show-search="true">
    
    <x-slot name="actions">
        <x-link-button :href="route('admin.writers.create')"><x-heroicon-o-plus class="h-5 -mt-0.5 mr-1" />Add New</x-link-button>
    </x-slot>

    <div class="container my-4">
        <h1 class="mb-3 text-xl font-semibold">Writers</h1>
        <table class="w-full overflow-hidden text-sm bg-white border rounded-lg shadow-sm">
            <tr>
                <th class="px-2 py-1 font-semibold text-left border">ID</th>
                <th class="px-2 py-1 font-semibold text-left border">Image</th>
                <th class="px-2 py-1 font-semibold text-left border">Name</th>
                <th class="px-2 py-1 font-semibold text-left border">Location</th>
                <th class="px-2 py-1 font-semibold text-left border">Date of Birth</th>
                <th class="px-2 py-1 font-semibold text-right border">Actions</th>
            </tr>

            @forelse ($writers as $writer)
                <tr>
                    <td class="px-2 py-1 border">{{ $writer->id }}</td>
                    <td class="px-2 py-1 border">
                        <img class="w-10 h-10 rounded-full bg-primary-300" data-src="{{ $writer->image_url }}">
                    </td>
                    <td class="px-2 py-1 border"><a href="{{ route('admin.books', ['writer' => $writer->id]) }}">{{ $writer->name }}</a></td>
                    <td class="px-2 py-1 border">{{ $writer->location }}</td>
                    <td class="px-2 py-1 border">{{ $writer->date_of_birth->format('d M Y') }}</td>
                    <td class="px-2 py-1 border">

                        <x-admin-actions 
                            :delete="route('admin.writers.destroy', $writer)"
                            :edit="route('admin.writers.edit', $writer)" />

                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-2 py-1 border"
                        colspan="7">No writers found!</td>
                </tr>
            @endforelse
        </table>
        <div class="my-6">
            {{ $writers->links() }}
        </div>
    </div>
</x-admin-layout>
