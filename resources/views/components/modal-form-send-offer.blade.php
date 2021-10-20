@props(['exchange'])
@php
    $books = App\Models\Book::getForSelector();
@endphp

<x-modal-form
        :action="route('exchanges.offers.store', $exchange)"
        title="Send an Offer"
        submit-text="Send Your Offer"
>

    <div
            class="mb-5"
    >
        <div
                class="flex gap-3 mb-3"
                x-data="bookPriceFetcher"
                x-bind="trigger"
        >
            <x-input-searchable-select
                    class="flex-1"
                    name="book_id"
                    :rounded-image="false"
                    :options="$books"
                    :properties="[
                                                    'image' => 'cover_url',
                                                    'subtitle'  => 'writer',
                                                ]"
            >Your Book
            </x-input-searchable-select>
            <div
                    x-show="loaded"
                    x-cloak
                    class="pt-5 font-semibold"
            >
                <p class="text-xs uppercase">Current Price</p>
                <p>
                    <x-heroicon-s-currency-bangladeshi/>
                    <span x-ref="price">-1</span>
                </p>
            </div>
        </div>

        <div class="flex gap-3">

            <x-input-select
                    class="flex-1"
                    name="book_print"
                    label="Book Print"
            >
                <option value="original">Original Print</option>
                <option value="nilkhet">Nilkhet Print</option>
                <option value="news">News Print</option>
            </x-input-select>

            <x-input-select
                    class="flex-1"
                    name="book_age"
                    label="Book Age"
            >
                <option value="1">&lt; 1 Month</option>
                <option value="3">&lt; 3 Month</option>
                <option value="6">&lt; 6 Month</option>
                <option value="12">&lt; 1 Year</option>
                <option value="24">&lt; 2 Year</option>
                <option value="60">&lt; 5 Year</option>
            </x-input-select>

            <x-input-text
                    class="relative flex-1"
                    name="book_edition"
                    type="number"
                    placeholder="1"
            >Book Edition
            </x-input-text>

        </div>
        <p x-text="book.name"></p>
    </div>

    <div class='mb-5'>
        <p class="mb-3 text-xs font-semibold tracking-wider text-center text-gray-500 uppercase">
            Markings or Writings Inside Book</p>
        <div class="flex gap-3 text-center">
            <x-input-select
                    class="flex-1"
                    name="markings_percentage"
                    placeholder="10%"
                    label="Markings Percentage"
            >
                <option value="0">0% of pages</option>
                <option value="5">5% of pages</option>
                <option value="10">10% of pages</option>
                <option value="20">20% of pages</option>
                <option value="30">30% of pages</option>
                <option value="40">40% of pages</option>
                <option value="50">50% of pages</option>
                <option value="80">80% of pages</option>
                <option value="100">100% of pages</option>
            </x-input-select>

            <x-input-select
                    class="flex-1"
                    name="markings_density"
                    label="Markings Density">
                <option value="0">0% of each page</option>
                <option value="5">5% of each page</option>
                <option value="10">10% of each page</option>
                <option value="20">20% of each page</option>
                <option value="30">30% of each page</option>
                <option value="40">40% of each page</option>
                <option value="50">50% of each page</option>
            </x-input-select>

            <x-input-text
                    class="max-w-min"
                    name="missing_pages"
                    type="number"
                    placeholder="0"
            >Missing Pages
            </x-input-text>
        </div>
    </div>

    <div class="mb-3">
        <x-input-text
                type="file"
                name="previews"
                button-label="Select Previews"
                multiple
        >Picture Previews
        </x-input-text>
    </div>

</x-modal-form>