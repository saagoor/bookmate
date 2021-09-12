@php
    $title = "Post a Book Reading Challange"
@endphp
<x-app-layout :title="$title">
    
    <div class="container max-w-md py-6">

        <h1 class="mb-4 text-xl font-semibold sm:text-2xl">{{ $title }}</h1>

        <div class="">
            <form action="">
                @csrf

                <x-input-select-book class="mb-3">Book</x-input-select-book>

                <div class="mb-3">
                    <x-label>Challange Finish Date</x-label>
                    <x-pikaday name="finish_at"
                        type="date"
                        format="DD MMMM YYYY"
                        :value="old('finish_at')"
                        :option="[]"
                        placeholder="01 January 2001"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-75" />

                    @error('finish_at')
                        <p class="text-sm font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <x-flat-pickr name="birthday" />

            </form>
        </div>
    </div>

</x-app-layout>