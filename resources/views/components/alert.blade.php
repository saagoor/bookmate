@props(['type' => 'danger'])

@php
$alertClasses = 'py-2 pl-4 pr-10 rounded-lg font-semibold ';
$alertActionClasses = 'inline-flex items-center justify-center p-1 h-5 w-5 rounded-full absolute top-2 right-2 ';

switch ($type) {
    case 'success':
        $alertClasses .= 'bg-green-300 text-green-900';
        $alertActionClasses .= 'bg-green-500 text-green-900';
        break;

    case 'warning':
        $alertClasses .= 'bg-yellow-300 text-yellow-900';
        $alertActionClasses .= 'bg-yellow-500 text-yellow-900';
        break;

    case 'danger':
    default:
        $alertClasses .= 'bg-red-300 text-red-900';
        $alertActionClasses .= 'bg-red-500 text-red-900';
        break;
}
@endphp

<div x-data="{show: true}" x-show="show"
    class="{{ $alertClasses }}">
    <p>{{ $slot }}</p>
    <button type="button"
        class="{{ $alertActionClasses }}"
        x-on:click="show = false">&times;</button>
</div>
