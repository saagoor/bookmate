<x-skeleton :attributes="$attributes">
    @if ($showErrors)
        <x-errors/>
    @endif
    <div class="min-h-screen" x-data="application">
        <header class="shadow-sm">
            @include('layouts.navigation')
        </header>
        <main>
            <!-- Page Content -->
            {{ $slot }}
        </main>
        @auth
            <!-- Conversation -->
            <x-conversation />
        @endauth
    </div>
</x-skeleton>