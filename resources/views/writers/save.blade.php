@php
$title = $writer->id ? 'Edit Writer' : 'Add New Writer';
$formAction = $writer->id ? route('admin.writers.update', $writer) : route('admin.writers.store');
@endphp
<x-admin-layout :title="$title">
    <div class="container max-w-md">
        <div class="p-4 my-4 bg-white rounded-lg shadow md:p-6 md:my-6">

            <h1 class="mb-3 text-2xl font-semibold text-center">{{ $title }}</h1>

            <form action="{{ $formAction }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                @if ($writer->id)
                    @method('PUT')
                @endif

                <x-input-image class="mb-3"
                    name="image"
                    :image="$writer->image_url"
                    image-class="w-40 h-40">Image</x-input-image>

                <x-input-text class="mb-3"
                    name="name"
                    :value="old('name', $writer->name)"
                    placeholder="John Doe">Name</x-input-text>

                <div class="mb-3">
                    <x-label>Date of Birth</x-label>
                    <x-pikaday name="date_of_birth"
                        type="date"
                        format="DD MMMM YYYY"
                        :value="old('date_of_birth', $writer->date_of_birth)"
                        placeholder="01 January 2001"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-75" />

                    @error('date_of_birth')
                        <p class="text-sm font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <x-input-text class="mb-3"
                    name="location"
                    :value="old('location', $writer->location)"
                    placeholder="Panthapath, Dhaka 1215">Location</x-input-text>

                <x-button type="submit"
                    class="px-6 py-3">Save Writer</x-button>

            </form>
        </div>
    </div>
</x-admin-layout>
