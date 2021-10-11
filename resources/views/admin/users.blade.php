<x-admin-layout title="Users" :show-search="true">
    <div class="container my-4">
        <h1 class="mb-3 text-xl font-semibold">Users</h1>
        <table class="w-full overflow-hidden text-sm bg-white border rounded-lg shadow-sm">
            <tr>
                <th class="px-2 py-1 font-semibold text-left border">ID</th>
                <th class="px-2 py-1 font-semibold text-left border">Avatar</th>
                <th class="px-2 py-1 font-semibold text-left border">Name</th>
                <th class="px-2 py-1 font-semibold text-left border">Email</th>
                <th class="px-2 py-1 font-semibold text-left border">Balance</th>
                <th class="px-2 py-1 font-semibold text-left border">Registered At</th>
                <th class="px-2 py-1 font-semibold text-right border">Actions</th>
            </tr>

            @forelse ($users as $user)
                <tr>
                    <td class="px-2 py-1 border">{{ $user->id }}</td>
                    <td class="px-2 py-1 border">
                        <img class="object-cover w-10 h-10 rounded-full bg-primary-200" data-src="{{ $user->image_url }}">
                    </td>
                    <td class="px-2 py-1 border">{{ $user->name }}</td>
                    <td class="px-2 py-1 border">{{ $user->email }}</td>
                    <td class="px-2 py-1 border">{{ $user->balance }}</td>
                    <td class="px-2 py-1 border">{{ $user->created_at->diffForHumans() }}</td>
                    <td class="px-2 py-1 border">
                        <x-admin-actions
                            :delete="route('admin.users.destroy', $user)"
                            :edit="route('admin.users.edit', $user)" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-2 py-4 text-lg font-semibold border" colspan="5">Sorry, no user found!</td>
                </tr>
            @endforelse
        </table>
        <div class="my-6">
            {{ $users->links() }}
        </div>
    </div>
</x-admin-layout>
