<div class="flex flex-col items-center min-h-screen pt-6 sm:justify-center sm:pt-0">
    <div>
        {{ $logo }}
    </div>

    <div class="container">
        <div class="w-full px-6 py-4 mx-auto mt-6 overflow-hidden rounded-lg shadow-md bg-primary-50 sm:max-w-sm">
            {{ $slot }}
        </div>
    </div>
</div>
