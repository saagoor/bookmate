@props(['active' => false, 'icon'])
@php
$classes = 'flex py-2 px-3 rounded-md text-sm font-semibold hover:bg-gray-100 transition duration-150 ease-in-out';

if($active){
    $classes .= ' bg-gray-100';
}
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span class="w-8">
        @isset($icon)
            @svg($icon, ['class' => 'h-5 -mt-px'])
        @endisset
    </span>
    <span class="flex-1">
        {{ $slot }}
    </span>
</a>
