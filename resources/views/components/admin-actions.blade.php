<div {{ $attributes->merge(['class' => 'flex justify-end gap-1']) }}>

    @isset($delete)
        <x-form-button :action="$delete"
            method="DELETE"
            class="inline-flex items-center justify-center w-6 h-6 p-1 text-red-900 transition bg-red-200 rounded-full hover:bg-red-400">
            <x-heroicon-o-trash class="mt-0" />
        </x-form-button>
    @endisset

    @isset($edit)
        <x-link-button :href="$edit"
            class="!p-1 rounded-full h-6 w-6">
            <x-heroicon-o-pencil-alt class="mt-0" />
        </x-link-button>
    @endisset

    {{ $slot }}

</div>
