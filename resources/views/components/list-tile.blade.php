@props(['image', 'title', 'subtitle', 'roundedImage' => true])
<div {{ $attributes->merge(['class' => 'flex items-center gap-3 border-b border-gray-100 px-4 py-2']) }}>
    <img src="{{ $image }}"
        class="w-12 h-12 {{ $roundedImage ? 'rounded-full' : 'rounded-md' }}" />
    <div class="text-muted">
        <p class="font-bold leading-tight">{{ $title }}</p>
        @if ($subtitle)
            <p class="text-sm leading-tight">{{ $subtitle }}</p>
        @endif
    </div>
</div>
