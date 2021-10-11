@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-gray-700 truncate']) }}>
    {{ $value ?? $slot }}
</label>
