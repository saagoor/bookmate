@auth
    {{-- If the current user posted this --}}
    @if ($exchange->user_id == auth()->user()->id)
        @php
            $exchange->loadCount('offers');
        @endphp
        <div class="px-4 py-4 mb-6 bg-primary-300 sm:px-6 card">
            <p class="mb-3 text-2xl font-bold">{{ $exchange->offers_count }} Offer Received</p>
            {{-- Show offer viewer right sheet --}}
            <x-exchange-offers :exchange="$exchange" />
        </div>
        {{-- End if the current user posted this --}}
    @else
        {{-- If the current user sent an offer --}}
        @if ($exchange->current_users_offer)
            <div class="flex items-center gap-3 p-4 mb-6 bg-green-100 rounded-md shadow">
                <x-heroicon-s-check class="w-8 h-8 mr-2 border-2 rounded-full -mt-1.5 text-green-500 border-green-200"/>
                <div>
                    <p class="font-semibold leading-tight">
                        You have sent an exchange offer.
                    </p>
                    <p class="text-sm">Offered Book: {{ $exchange->current_users_offer->book->name ?? '' }}</p>
                </div>
            </div>
            {{-- And if the current user's offer is accepted --}}
            @if ($exchange->accepted_offer_id == $exchange->current_users_offer->id)
                <div class="p-4 mb-6 text-sm font-semibold leading-tight bg-green-100 rounded-md shadow">
                    <div class="flex items-center gap-3">
                        <x-heroicon-s-check
                                class="w-8 h-8 mr-2 border-2 rounded-full -mt-1.5 text-green-500 border-green-200"/>
                        <p class="flex-1">{{ $exchange->user->name }} has accepted your exchange offer.</p>
                    </div>
                </div>
            @endif
            {{-- End if the current user sent an offer --}}
        @endif
        <div class="flex flex-col gap-3 mb-6 sm:flex-row">
            {{-- If the exchange hasn't accepted an offer --}}
            {{-- and the current user did not send any offer --}}
            {{-- then show him the send offer form --}}
            @if (!$exchange->accepted_offer_id && !$exchange->current_users_offer)
                <div class="flex-1"
                     x-data="{show: {{ $errors->any() ? 'true' : 'false' }}}">
                    <x-button
                            type="button"
                            color="light"
                            @click.prevent="show = true"
                            class="w-full py-3 text-base sm:text-lg"
                    >
                        <x-heroicon-o-hand class="mr-2 -mt-0.5 transform rotate-90"/>
                        Send Offer
                    </x-button>

                    <x-modal-form
                            :action="route('ebooks.offers.store', $exchange)"
                            title="Send an Offer"
                            submit-text="Send Your Offer"
                    >

                        <div class="mb-5">
                            <x-input-searchable-select
                                    class="flex-1"
                                    name="book_id"
                                    :rounded-image="false"
                                    :options="App\Models\Book::getForSelector()"
                                    :properties="[
                                        'image' => 'cover_url',
                                        'subtitle'  => 'writer',
                                    ]"
                            >Your Book
                            </x-input-searchable-select>
                        </div>

                        <x-input-text type="file" name="ebook" accept=".pdf,.epub">Upload Your eBook</x-input-text>

                    </x-modal-form>
                </div>
            @endif
            <x-button
                    class="flex-1 py-3 text-base sm:text-lg"
                    x-on:click="openConversation({{ $exchange->user }})">
                <x-heroicon-o-chat class="mr-2 -mt-0.5"/>
                Contact Owner
            </x-button>
        </div>
        {{-- End else if the current user did not post this exchange request--}}
    @endif
    {{-- If the current user posted this or sent an offer --}}
    {{-- then show them the progress of this exchange --}}
    @if($exchange->user_id == auth()->user()->id || $exchange->current_users_offer)
        <div class="card mb-6 p-4 bg-white border-4 border-dashed border-primary-400">
            <p class="font-semibold mb-2">Exchange Progress</p>
            <aside class="text-lg font-bold leading-loose font-heading">
                @php
                    $steps = [];
                    if($exchange->user_id == auth()->user()->id){
                        $steps = [
                            [
                                'content' => 'Offers Received',
                                'condition' => $exchange->offers_count
                            ],
                            [
                                'content' => 'Offer Accepted',
                                'condition' => $exchange->accepted_offer_id
                            ],
                            [
                                'content' => 'eBook Available for Download',
                                'condition' => $exchange->accepted_offer_id
                            ],
                        ];
                    }else if($exchange->current_users_offer){
                        $steps = [
                            [
                                'content' => 'Offer Sent',
                                'condition' => $exchange->current_users_offer
                            ],
                            [
                                'content' => 'Offer Accepted',
                                'condition' => $exchange->accepted_offer_id == $exchange->current_users_offer->id
                            ],
                            [
                                'content' => 'eBook Available for Download',
                                'condition' => $exchange->accepted_offer_id == $exchange->current_users_offer->id
                            ],
                        ];
                    }
                @endphp
                <x-exchange-steps :steps="$steps" :exchange="$exchange" />
            </aside>
        </div>
        {{-- End if the current user posted this or sent an offer --}}
    @endif
    {{-- End if auth --}}
@else
    <div class="p-4 mb-6 sm:p-6 card">
        <p class="text-lg">
            Please
            <a href="{{ route('login') }}"><span class="font-semibold">Login</span></a>
            or
            <a href="{{ route('register') }}"><span class="font-semibold">Register</span></a>
            to send exchange offer.
        </p>
    </div>
@endauth
