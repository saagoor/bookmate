<form method="get">
    <div class="inline-flex gap-1"
        x-data="{show: {{ request('search') ? 'true' : 'false' }}}">
        <x-input x-show="show"
            x-ref="search"
            name="search"
            placeholder="Search....." />
        @if (request('search'))
            <x-link-button color="light"
                href="{{ url()->current() }}"
                class="w-10 h-10 rounded-full !p-0.5">
                <x-heroicon-o-x />
            </x-link-button>
        @else
            <x-button type="button"
                color="light"
                class="w-10 h-10 rounded-full !p-0.5"
                @click="show = !show; $nextTick(() => { $refs.search.focus() })">
                <x-heroicon-o-search x-show="!show" />
                <x-heroicon-o-x x-cloak x-show="show" />
            </x-button>
        @endif
    </div>
</form>