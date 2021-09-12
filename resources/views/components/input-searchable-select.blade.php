@props([
'name' => '',
'value' => old($name),
'roundedImage' => true,
'options' => App\Models\Writer::all(['id', 'name', 'image', 'email']),
'properties' => []
])

@php
$properties = (object) array_merge(
    [
        'id' => 'id',
        'title' => 'name',
        'subtitle' => 'email',
        'image' => 'image_url',
    ],
    $properties,
);
@endphp
<div {{ $attributes->only('class') }}>

    @if ($slot)
        <x-label :for="$name">{{ $slot }}</x-label>
    @endif

    <div x-data="searchableSelector()"
        @click.away="close()"
        class="relative">
        <div class="w-full">
            <div class="relative">
                <input type="hidden"
                    name="{{ $name }}"
                    x-model="selected.{{ $properties->id }}">
                <x-input name=""
                    x-bind:value="selected.{{ $properties->title }}"
                    placeholder="Select {{ $slot }}"
                    readonly
                    @focus="open()"
                    class="w-full" />
                <button type="button"
                    @click="toggle()"
                    class="absolute w-6 h-6 text-gray-600 transform -translate-y-1/2 outline-none cursor-pointer top-1/2 right-1.5">
                    <x-heroicon-o-chevron-down x-show="!show" />
                    <x-heroicon-o-chevron-up x-show="show" />
                </button>
            </div>
        </div>
        <div x-cloak
            x-show="show"
            class="absolute z-40 w-full bg-white rounded-md shadow-2xl top-full lef-0 max-h-select">
            <div class="flex flex-col w-full">
                <div class="px-4 py-2 border-b border-primary-200">
                    <x-input name=""
                        x-ref="filter"
                        x-model="filter"
                        x-on:input="filterOptions()"
                        @keydown.enter.stop.prevent="selectOption()"
                        @keydown.arrow-up.prevent="focusPrevOption()"
                        @keydown.arrow-down.prevent="focusNextOption()"
                        class="w-full py-1"
                        placeholder="Search...." />
                </div>
                <div class="overflow-y-auto max-h-60">
                    <template x-for="(item, index) in getResults()"
                        :key="index">
                        <template x-if="typeof item != undefined">
                            <div @click="onOptionClick(index)"
                                :class="classOption(item.{{ $properties->id }}, index)"
                                :aria-selected="focusedOptionIndex === index">
                                <div
                                    class="flex items-center gap-3 px-3 py-2 border-l-2 border-transparent hover:border-primary-400">

                                    <img class="bg-primary-100 {{ $roundedImage ? 'w-10 h-10 rounded-full' : 'w-10 h-10 rounded' }}"
                                        x-bind:src="item.{{ $properties->image }}">

                                    <div class="flex-1">
                                        <p x-text="item.{{ $properties->title }}"></p>
                                        <p class="text-xs text-gray-500 truncate"
                                            x-text="item.{{ $properties->subtitle }}"></p>
                                    </div>

                                </div>
                            </div>
                        </template>
                    </template>
                    <template x-if="getResults().length <= 0">
                        <p class="px-4 py-3">Sorry, no matching result found.</p>
                    </template>
                </div>
            </div>
        </div>
    </div>

    @error($name)
        <p class="text-sm font-semibold text-red-600">{{ $message }}</p>
    @enderror
</div>

@push('head')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('searchableSelector', () => ({
                filter: '',
                show: false,
                focusedOptionIndex: -1,
                options: @json($options),
                results: [],
                selected: {},
                close() {
                    this.show = false;
                    this.focusedOptionIndex = this.selected ? this.focusedOptionIndex : -1;
                },
                open() {
                    this.show = true;
                    this.$nextTick(() => {
                        this.$refs.filter.focus();
                    });
                },
                toggle() {
                    this.show ? this.close() : this.open();
                },
                getResults() {
                    if (this.filter == '') {
                        return this.options;
                    }
                    return this.results;
                },
                classOption(id, index) {
                    const isSelected = id == this.selected.id;
                    const isFocused = (index == this.focusedOptionIndex);
                    return {
                        'cursor-pointer w-full border-primary-100 border-b hover:bg-primary-200': true,
                        'bg-primary-200': isSelected,
                        'bg-primary-200': isFocused
                    };
                },
                filterOptions() {
                    if (!this.options || !this.options.length) {
                        return [];
                    }
                    this.results = [];
                    let temp = {};
                    for (let i = 0; i < this.options.length; i++) {
                        temp = this.options[i];
                        if (typeof temp == undefined) {
                            continue;
                        }
                        if (
                            (temp.{{ $properties->title }} && temp.{{ $properties->title }}
                                .toLowerCase().indexOf(this.filter.toLowerCase()) > -1) ||
                            (temp.{{ $properties->subtitle }} && temp.{{ $properties->subtitle }}
                                .toLowerCase().indexOf(this.filter.toLowerCase()) > -1)
                        ) {
                            this.results.push(temp);
                        }
                        if (this.results.length >= 5) break;
                    }
                },
                onOptionClick(index) {
                    this.focusedOptionIndex = index;
                    this.selectOption();
                },
                selectOption() {
                    if (!this.show) {
                        return;
                    }
                    this.focusedOptionIndex = this.focusedOptionIndex ?? 0;
                    this.selected = this.getResults()[this.focusedOptionIndex];
                    this.close();
                },
                focusPrevOption() {
                    const lastIndex = this.getResults().length - 1;
                    if (this.focusedOptionIndex >= lastIndex) {
                        return this.focusedOptionIndex = 0;
                    }
                    return this.focusedOptionIndex++;
                },
                focusNextOption() {
                    const lastIndex = this.getResults().length - 1;
                    if (this.focusedOptionIndex <= 0) {
                        return this.focusedOptionIndex = lastIndex;
                    }
                    return this.focusedOptionIndex--;
                },
                init() {
                    @if ($value)
                        this.selected = this.options.find(item => item.id == {{ $value }});
                    @endif
                }
            }))
        })
    </script>

@endpush
