@props(['name', 'type' => 'text', 'value' => old($name, request($name)), 'disabled' => false])

<input {{ $disabled ? 'disabled' : '' }}
    id="{{ $name }}"
    name="{{ $name }}"
    type="{{ $type }}"
    value="{{ $value }}"
    {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-75']) !!}>
