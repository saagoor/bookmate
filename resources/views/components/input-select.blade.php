@props(['name', 'label' => null])

<div {{ $attributes->only('class') }}>

    @if ($label)
        <x-label :for="$name">{{ $label }}</x-label>
    @endif

    <select id="{{ $name }}"
        name="{{ $name }}"
        {!! $attributes->merge(['class' => 'block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-75']) !!}>
        {{ $slot }}
    </select>

    @error($name)
        <p class="text-sm font-semibold text-red-600">{{ $message }}</p>
    @enderror
</div>
