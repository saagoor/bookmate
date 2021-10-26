<x-skeleton>
    <header class="min-h-screen">
        <div class="container">
            <div class="flex items-center justify-between">
                <a href="{{ route('index') }}">
                    <x-application-logo class="block w-auto pb-4 text-gray-600 fill-current h-14 sm:h-16" />
                </a>
                @guest
                    <nav>
                        <x-link-button color="light"
                            class="bg-opacity-50 bg-primary-50 text-sm sm:text-base sm:font-semibold py-1.5 sm:py-3 px-3 sm:px-6 shadow-sm"
                            href="{{ route('login') }}">{{ __('Login') }}</x-link-button>
                        <x-link-button color="light"
                            class="bg-opacity-50 bg-primary-50 text-sm sm:text-base sm:font-semibold py-1.5 sm:py-3 px-3 sm:px-6 shadow-sm"
                            href="{{ route('register') }}">{{ __('Register') }}</x-link-button>
                    </nav>
                @endguest
            </div>
        </div>
        <div class="container">
            <div class="max-w-4xl py-10 mx-auto text-center sm:py-14 lg:py-16">
                <h1 class="text-4xl font-black tracking-wide font-heading sm:text-6xl lg:text-7xl">Enrich your
                    knowledge by <br><span class="text-primary-500">reading books.</span></h1>
                <p
                    class="mt-3 text-lg text-gray-500 sm:mt-5 sm:text-xl sm:max-w-xl sm:mx-auto md:mt-5 md:text-2xl lg:mx-auto">
                    Give books away, get books you want!
                </p>
                <div class="flex flex-col justify-center gap-4 mt-10 sm:items-center sm:flex-row sm:mt-14 lg:mt-16">
                    <x-link-button color="primary"
                        class="px-4 py-2 font-semibold sm:py-3 lg:py-4 sm:px-6 lg:px-8 sm:text-lg lg:text-xl"
                        href="{{ route('exchanges.index') }}">Browse Books</x-link-button>
                    <x-link-button color="light"
                        class="px-4 py-2 font-semibold sm:py-3 lg:py-4 sm:px-6 lg:px-8 sm:text-lg lg:text-xl"
                        href="{{ route('register') }}">Join Community</x-link-button>
                </div>
            </div>
        </div>
    </header>
</x-skeleton>
