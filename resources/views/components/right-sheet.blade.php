<div x-cloak
    x-data="{show: false}"
    id="{{ $id ?? 'rightSheet' }}"
    @open{{ $id ?? 'sheet' }}.window="setTimeout(() => show = true, 250)">
    <span x-on:click="show = true">
        {{ $trigger }}
    </span>

    <div class="fixed top-0 bottom-0 right-0 z-50 pl-10 md:pl-1/3 lg:pl-1/2"
        x-show="show"
        x-on:close.stop="show = false"
        x-on:keydown.escape.window="show = false">

        <div class="fixed inset-0 transition-all transform"
            x-show="show"
            x-on:click="show = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div class="h-full overflow-hidden transition-all transform bg-white shadow-xl rounded-l-xl"
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="translate-x-2/3 opacity-50"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-2/3 opacity-50">
            <div class="flex flex-col h-full">
                <div class="flex items-center px-8 py-4 bg-cool-gray-200">
                    <button x-on:click="show = false"
                        class="py-2 pr-4 md:mr-4 hover:opacity-75 smooth">
                        <x-heroicon-s-arrow-left />
                    </button>
                    <div class="text-lg font-semibold">
                        {{ $title ?? '' }}
                    </div>
                </div>
                <div class="px-8 py-4 my-auto overflow-y-auto">
                    {{ $slot }}
                </div>
                @isset($footer)
                    <div class="px-6 py-4 text-right bg-gray-100">
                        {{ $footer }}
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>
