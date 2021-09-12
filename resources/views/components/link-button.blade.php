@props(['color' => 'primary'])

@php
$classes = 'inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm font-semibold text-sm focus:outline-none focus:ring ring-opacity-50 disabled:opacity-25 transition ease-in-out duration-150';
switch ($color) {
    case 'primary':
        $classes .= ' bg-primary-500 text-gray-default hover:bg-primary-600 active:bg-primary-600 focus:border-primary-400 ring-primary-400';
        break;

    case 'light':
        $classes .= ' bg-white text-gray-default hover:bg-gray-100 border-gray-200 focus:border-primary-200 ring-primary-300';
        break;

    case 'gray':
    default:
        $classes .= ' bg-gray-800 text-white hover:bg-gray-700 active:bg-gray-700 focus:border-gray-900 ring-gray-300';
        break;
}
@endphp
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
