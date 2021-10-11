@php
$title = 'Post a Book to Exchange';

$books = App\Models\Book::with('authors')
    ->without(['writers', 'translators'])
    ->latest('name')
    ->get(['id', 'name', 'cover']);

@endphp
<x-app-layout :title="$title">

    <div class="container max-w-xl py-6 md:py-10">
        <main x-data="{
            step: 1,
            steps: 3,
            next(){
                if(this.step > this.steps - 1){
                    return this.$el.form.submit();
                }
                this.step++;
            },
            prev(){
                if(this.step <= 1){
                    return;
                }
                this.step--;
            },
            book: {},
            expected_book: {},
        }">
            <h1 class="mb-4 text-3xl font-semibold md:mb-6">{{ $title }}</h1>

            <form action="{{ route('exchanges.store') }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf

                <div x-show="step == 1"
                    class="p-6 mb-3 card bg-gray-50"
                    x-on:bookSelected="alert('fook')">
                    <div class="flex gap-3 mb-3"
                        x-data="bookPriceFetcher"
                        x-bind="trigger">
                        <x-input-searchable-select class="flex-1"
                            name="book_id"
                            :rounded-image="false"
                            :options="$books"
                            :properties="[
                                'image' => 'cover_url',
                                'subtitle'  => 'writer',
                            ]">Your Book</x-input-searchable-select>
                        <div x-show="loaded"
                            x-cloak
                            class="pt-5 font-semibold">
                            <p class="text-xs uppercase">Current Price</p>
                            <p>
                                <x-heroicon-s-currency-bangladeshi /> <span x-ref="price">-1</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3">

                        <x-input-select class="flex-1"
                            name="book_print"
                            label="Book Print">
                            <option value="original">Original Print</option>
                            <option value="nilkhet">Nilkhet Print</option>
                            <option value="news">News Print</option>
                        </x-input-select>

                        <x-input-select class="flex-1"
                            name="book_age"
                            label="Book Age">
                            <option value="1">&lt; 1 Month</option>
                            <option value="3">&lt; 3 Month</option>
                            <option value="6">&lt; 6 Month</option>
                            <option value="12">&lt; 1 Year</option>
                            <option value="24">&lt; 2 Year</option>
                            <option value="60">&lt; 5 Year</option>
                        </x-input-select>

                        <x-input-text class="relative flex-1"
                            name="book_edition"
                            type="number"
                            placeholder="1">Book Edition
                        </x-input-text>

                    </div>
                    <p x-text="book.name"></p>
                </div>

                <div x-show="step == 2"
                    x-cloak
                    class="p-6 mb-3 card bg-gray-50">
                    <p class="mb-2 text-xs font-semibold tracking-wider text-center text-gray-500 uppercase">
                        Markings or Writings Inside Book</p>
                    <div class="flex gap-3 text-center">
                        <x-input-select class="flex-1"
                            name="markings_percentage"
                            placeholder="10%"
                            label="Markings Percentage">
                            <option value="0">0%</option>
                            <option value="5">5%</option>
                            <option value="10">10%</option>
                            <option value="20">20%</option>
                            <option value="30">30%</option>
                            <option value="40">40%</option>
                            <option value="50">50%</option>
                            <option value="80">80%</option>
                            <option value="100">100%</option>
                        </x-input-select>

                        <x-input-select class="flex-1"
                            name="book_print"
                            label="Markings Density">
                            <option value="very_few">Very Few</option>
                            <option value="few">Few</option>
                            <option value="lot">A Lot</option>
                            <option value="too_much">Too Much</option>
                        </x-input-select>

                        <x-input-text class="max-w-min"
                            name="book_edition"
                            type="number"
                            placeholder="1">Missing Pages
                        </x-input-text>
                    </div>
                </div>

                <div x-show="step == 3"
                    x-cloak
                    class="p-6 mb-3 card bg-gray-50">
                    <div class="flex gap-3 mb-3"
                        x-data="bookPriceFetcher"
                        x-bind="trigger">
                        <x-input-select-book class="flex-1"
                            :books="$books"
                            name="expected_book_id">Expected Book</x-input-select-book>

                        <div x-show="loaded"
                            x-cloak
                            class="self-end font-semibold">
                            <p class="text-xs uppercase">Current Price</p>
                            <p>
                                <x-heroicon-s-currency-bangladeshi /> <span x-ref="price">-1</span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <x-input-text type="file"
                            name="previews[]"
                            button-label="Select Previews"
                            multiple>Picture Previews</x-input-text>
                    </div>

                    <x-input-textarea name="description"
                        placeholder="(Optional) Writer a short description......."
                        label="Description">{{ old('description') }}</x-input-textarea>
                </div>

                <div class="flex justify-between">
                    <x-button @click.prevent="prev()"
                        x-show="step > 1"
                        x-cloak
                        color="light"
                        class="text-base">
                        <span class="mr-2 font-light scale-x-150">&LeftAngleBracket;</span>
                        <span>Previous</span>
                    </x-button>
                    <x-button @click.prevent="next()"
                        class="items-center text-base">
                        <span x-text="step < steps ? 'Next' : 'Post Request'">Next</span>
                        <span x-show="step < steps"
                            class="ml-2 font-light scale-x-150">&RightAngleBracket;</span>
                    </x-button>
                </div>

            </form>
        </main>
    </div>
</x-app-layout>
