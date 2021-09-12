<x-skeleton :attributes="$attributes">
    @if ($showErrors)
        <x-errors />
    @endif
    <div class="min-h-screen">
        <header class="shadow-sm">
            @include('layouts.navigation')
        </header>
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</x-skeleton>