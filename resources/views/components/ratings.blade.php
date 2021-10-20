@props(['rating'])

<div {{ $attributes }}>
    @for ($i = 1; $i <= 5; $i++)

        @if ($i <= $rating)
            <x-bi-star-fill />
        @elseif($i <= ($rating + 0.5))
            <x-bi-star-half />
        @else
            <x-bi-star />
        @endif

    @endfor
</div>
