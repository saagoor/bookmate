@props(['user'])
<div  {{ $attributes->merge(['class' => 'flex items-center gap-3 border-b border-gray-100 px-4 py-2']) }}>
    <img src="{{ $user->profile_photo_url }}" alt=""
        class="rounded-full w-12 h-12 bg-cool-gray-200">
    <div class="text-muted">
        <p class="font-bold leading-tight">{{ $user->name }}</p>
        <p class="text-sm leading-tight">{{ $user->email }}</p>
    </div>
</div>
