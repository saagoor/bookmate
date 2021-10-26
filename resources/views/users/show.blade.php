<x-app-layout :title="$user->name">

    <div class="container py-8">

        <div class="bg-white shadow-xl rounded-xl overflow-hidden flex flex-col md:flex-row items-center mb-6 p-6 gap-6">
            <x-img :src="$user->image_url" class="w-32 h-34 rounded-full bg-primary-100"/>
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-lg md:text-2xl font-semibold">{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
            </div>
            @auth
                @if (auth()->user()->id == $user->id)
                    <x-link-button :href="route('users.edit', $user)">Edit Profile</x-link-button>
                @else
                    <x-button
                            class="text-base sm:text-lg font-heading"
                            x-on:click="openConversation({{ $user }})">
                        <x-heroicon-o-chat class="mr-2 -mt-0.5"/>
                        Send Message
                    </x-button>
                @endif
            @endauth
        </div>

        <x-model-reviews :model="$user" :can-review="auth()->check() && auth()->user()->canReview($user)"/>

    </div>

</x-app-layout>