@php
$title = $publisher->id ? 'Edit Publisher' : 'Add New Publisher';
$formAction = $publisher->id ? route('admin.publishers.update', $publisher) : route('admin.publishers.store');
@endphp
<x-admin-layout :title="$title">
    <div class="container max-w-md">
        <div class="p-4 my-4 bg-white rounded-lg shadow md:p-6 md:my-6">

            <h1 class="mb-3 text-2xl font-semibold text-center">{{ $title }}</h1>

            <form action="{{ $formAction }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                @if ($publisher->id)
                    @method('PUT')
                @endif

                <x-input-image class="mb-3"
                    name="image"
                    :image="$publisher->image_url"
                    image-class="w-40 h-40">Image</x-input-image>

                <x-input-text class="mb-3"
                    name="name"
                    :value="old('name', $publisher->name)"
                    placeholder="John Doe">Name</x-input-text>

                <x-input-text class="mb-3"
                    name="phone"
                    :value="old('phone', $publisher->phone)"
                    placeholder="+8801775755272">Phone</x-input-text>

                <x-input-text class="mb-3"
                    name="email"
                    type="email"
                    :value="old('email', $publisher->email)"
                    placeholder="john@doe.com">Email</x-input-text>


                <x-input-text class="mb-3"
                    name="location"
                    :value="old('location', $publisher->location)"
                    placeholder="Panthapath, Dhaka 1215">Location</x-input-text>

                <x-button type="submit"
                    class="px-6 py-3">Save Publisher</x-button>

            </form>
        </div>
    </div>
</x-admin-layout>
