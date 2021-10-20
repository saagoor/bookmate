@foreach($steps as $index => $step)
    <div class="flex justify-between items-center">
        <p @class([
            'opacity-100'   => $step['condition'],
            'opacity-40'   => !$step['condition'],
        ])
        >{{ ($index + 1) . '. ' . $step['content'] }}</p>

        @if($index == 2 && $steps[$index-1]['condition'] && !$steps[$index+1]['condition'])
{{--            For setting meetup location & time --}}
            <div x-data="{show: {{ $errors->any() ? 'true' : 'false' }}}" class="font-sans">
                <a class="text-sm font-semibold text-primary-600 hover:text-primary-900 float-right"
                   @click.prevent="show = true"
                   href="#">&looparrowleft; Set</a>
                <x-modal-form :title="$step['content']" :action="route('exchanges.pickup', $exchange)">
                    <x-input-text
                            name="pickup_location"
                            :value="old('pickup_location', $exchange->pickup_location)"
                            class="mb-3"
                            placeholder="Bashundhara, Panthapath">Location</x-input-text>
                    <x-input-text
                            name="pickup_time"
                            :value="date('Y-m-d\TH:i', strtotime(old('pickup_time', $exchange->pickup_time)))"
                            :min="date('Y-m-d\TH:i', time())"
                            class="mb-2"
                            type="datetime-local">Date & Time</x-input-text>
                </x-modal-form>
            </div>
        @endif

        @if($index == 3 && $steps[$index-1]['condition'] && !$steps[$index]['condition'])
            <x-form-button
                    :action="route('exchanges.complete', $exchange)"
                    class="font-sans text-sm font-semibold text-primary-600 hover:text-primary-900"
            >&looparrowleft; Mark as Done
            </x-form-button>
        @endif
    </div>

{{--    If the current user posted this exchange request & there is an accepted offer --}}
    @if($index == 1 && $steps[$index]['condition'] && $exchange->user_id == auth()->user()->id)
        <div class="text-sm font-normal w-5/6 ml-auto mb-2 font-sans">
            @include('exchanges._offer-card', ['offer' => $exchange->accepted_offer])
        </div>
    @endif

{{--    If the pickup location and time has been set --}}
    @if($index == 2 && $steps[$index]['condition'])
        <p class="font-sans text-sm font-normal text-gray-600 text-right mb-2">{{ $exchange->pickup_location }} - {{ $exchange->pickup_time->format('d M Y - g:i A') }}</p>
    @endif

{{--    If the exchange is completed--}}
    @if($index == 3 && $steps[$index]['condition'])
        <x-img class="h-20 w-20 object-contain my-3" :src="asset('images/fireworks.png')" />
        <p class="font-sans text-lg font-semibold text-green-600 leading-tight mb-2">The exchange has been marked as completed.</p>
    @endif
@endforeach