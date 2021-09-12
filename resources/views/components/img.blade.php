@props(['src' => '', 'placeholder' => asset('images/placeholder.jpg')])
<img {{ $attributes->merge(['class' => 'object-cover']) }}
    data-src="{{ $src }}"
    src="{{ $placeholder }}">
