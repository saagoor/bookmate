@props([
    'image' => null, 
    'name' => 'image', 
    'multiple'  => false,
    'imageClass' => 'w-32 h-20',
    'buttonLabel'   => 'Select Image',
])

<div {{ $attributes->only('class') }}>

    <x-label :for="$name">{{ $slot }}</x-label>

    <div x-data="{
            imageName: null, 
            imagePreview: null,
            updateImage(){
                this.imageName = this.$refs.image.files[0].name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL($refs.image.files[0]);
            }
        }"
        class="col-span-6 sm:col-span-4">

        <!-- Image File Input -->
        <input name="{{ $name }}"
            type="file"
            class="hidden"
            x-ref="image"
            @if ($multiple)
                multiple
            @endif
            x-on:change="updateImage()" />

        @if($image)
            <!-- Current image -->
            <div class="mt-2"
                x-show="! imagePreview">
                <img src="{{ $image }}"
                    alt=""
                    class="object-cover {{ $imageClass }} bg-gray-200 rounded">
            </div>
        @endif

        <!-- New image Preview -->
        <div class="mt-1"
            x-show="imagePreview">
            <span class="block {{ $imageClass }} bg-center bg-no-repeat bg-cover rounded"
                x-bind:style="'background-image: url(\'' + imagePreview + '\');'">
            </span>
        </div>

        <x-button class="mt-1 mr-1 !bg-white !text-gray-700 !border !border-gray-300"
            type="button"
            x-on:click.prevent="$refs.image.click()">
            {{ __($buttonLabel) }}
        </x-button>
    </div>
    @error(str_replace('[]', '', $name))
        <p class="mt-0.5 text-sm font-semibold text-red-600">{{ $message }}</p>
    @enderror
</div>
