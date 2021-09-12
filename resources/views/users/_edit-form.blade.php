<div class="container max-w-md">
    <div class="p-4 my-4 bg-white rounded-lg shadow md:p-6 md:my-6">

        <h1 class="mb-3 text-2xl font-semibold text-center">{{ $title ?? 'Edit Profile' }}</h1>

        <form action="{{ $formAction ?? route('admin.users.update', $user) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            @if ($user->id)
                @method('PUT')
            @endif

            <x-input-image class="mb-3"
                name="image"
                :image="$user->image_url"
                image-class="w-20 h-20 mb-2 rounded-full">Image</x-input-image>

            <x-input-text class="mb-3"
                name="name"
                :value="old('name', $user->name)"
                placeholder="John Doe">Name</x-input-text>

            <x-input-text class="mb-3"
                name="email"
                type="email"
                :value="old('email', $user->email)"
                placeholder="john@doe.com">Email</x-input-text>

            <x-button type="submit"
                class="px-6 py-3">Save User</x-button>

        </form>
    </div>
</div>