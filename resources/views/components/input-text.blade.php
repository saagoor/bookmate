@props(['name', 'type' => 'text'])

<div {{ $attributes->only('class') }}>

    <x-label :for="$name">{{ $slot }}</x-label>

    <x-input
        class="block w-full mt-1"
        :name="$name"
        :type="$type"
        :attributes="$attributes->except('class')" />
        
    @error(str_replace('[]', '', $name))
        <p class="text-sm font-semibold text-red-600">{{ $message }}</p>
    @enderror
</div>
