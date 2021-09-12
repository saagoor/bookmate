@props(['name', 'label' => false])

<div {{ $attributes->only('class') }}>

    @if($label)
        <x-label :for="$name">{{ $label }}</x-label>
    @endif

    <textarea class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-75"
        name="{{ $name }}"
        {{ $attributes->except('class') }}>{{ $slot }}</textarea>

    @error($name)
        <p class="text-sm font-semibold text-red-600">{{ $message }}</p>
    @enderror
</div>
