@props([
    'buttonLabel' => 'View Offers',
    'buttonClass' => 'px-2 py-1 tracking-normal capitalize',
    'exchange',
])
<div x-data="{
    getContents(force = false){
        let el = this.$refs.sheetContents;
        if(!el.hasAttribute('data-loaded') || force){
            axios.get('{{ route('exchanges.offers', $exchange->id) }}')
                .then(response => {
                    el.innerHTML = response.data;
                    el.setAttribute('data-loaded', true);
                })
                .catch(error => {
                    el.innerHTML = error.message;
                });
        }
    }
}">
    <x-right-sheet title="Received Offers">
        <x-slot name="trigger">
            <x-button :class="$buttonClass"
                x-on:click="getContents()">{{ $buttonLabel }}</x-button>
        </x-slot>
        <div class="max-w-lg w-80">
            <div x-ref="sheetContents">
                <div class="text-center">
                    <x-heroicon-o-refresh class="w-10 h-10 animate-spin" />
                </div>
            </div>
        </div>
    </x-right-sheet>
</div>
