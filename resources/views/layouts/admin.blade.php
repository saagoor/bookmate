@php
// dd($attributes);
@endphp
<x-skeleton :attributes="$attributes">
    @if ($showErrors)
        <x-errors />
    @endif
    <div class="flex">
        {{-- Sidebar --}}
        <div class="sticky top-0 self-start min-h-screen px-2 py-4 bg-white border-r shadow-sm w-52">
            <div class="p-4 mb-4">
                <a href="/">
                    <x-application-logo class="w-5/6" />
                </a>
            </div>
            <nav class="flex flex-col gap-y-1">

                <x-sidebar-nav-link icon="heroicon-o-home"
                    :href="route('admin.dashboard')"
                    :active="request()->routeIs('admin.dashboard')">Dahsboard</x-sidebar-nav-link>

                <x-sidebar-nav-link icon="heroicon-o-book-open"
                    :href="route('admin.books')"
                    :active="request()->routeIs('admin.books')">Books</x-sidebar-nav-link>

                <x-sidebar-nav-link icon="heroicon-o-user-group"
                    :href="route('admin.writers')"
                    :active="request()->routeIs('admin.writers')">Writers</x-sidebar-nav-link>

                <x-sidebar-nav-link icon="heroicon-o-printer"
                    :href="route('admin.publishers')"
                    :active="request()->routeIs('admin.publishers')">Publishers</x-sidebar-nav-link>

                <hr>

                <x-sidebar-nav-link icon="heroicon-o-hand"
                    :href="route('admin.exchanges')"
                    :active="request()->routeIs('admin.exchanges')">Exchanges</x-sidebar-nav-link>

                <hr>

                <x-sidebar-nav-link icon="heroicon-o-users"
                    :href="route('admin.users')"
                    :active="request()->routeIs('admin.users')">Users</x-sidebar-nav-link>

            </nav>
        </div>
        <div class="flex-1">
            <nav x-data="{ open: false }"
                class="px-4 bg-white border-b-2">
                <!-- Primary Navigation Menu -->
                <div class="flex items-center justify-between gap-4 h-14">

                    @if ($showSearch)
                        <div>
                            <form action=""
                                method="get">
                                <label class="relative block">
                                    <span class="absolute z-10 transform -translate-y-1/2 top-1/2 left-1.5">
                                        <x-heroicon-o-search class="h-3.5 -mt-0.5" />
                                    </span>

                                    <x-input class="block w-full py-1 pl-7"
                                        name="search"
                                        placeholder="Search....." />

                                    @if (request()->has('search'))
                                        <x-link-button :href="url()->current()"
                                            class="absolute right-1.5 z-10 w-5 h-5 !p-0.5 rounded-full transform -translate-y-1/2 top-1/2">
                                            <x-heroicon-o-x class="mt-0" />
                                        </x-link-button>
                                    @endif
                                </label>
                            </form>
                        </div>
                    @endif

                    <!-- Navigation Links -->
                    <div class="hidden h-full space-x-8 sm:-my-px sm:flex">
                        <x-nav-link :href="route('books.index')"
                            :active="request()->routeIs('books.index')">
                            {{ __('Books') }}
                        </x-nav-link>
                        <x-nav-link :href="route('books.index')"
                            :active="request()->routeIs('')">
                            {{ __('Challanges') }}
                        </x-nav-link>
                        <x-nav-link :href="route('books.index')"
                            :active="request()->routeIs('')">
                            {{ __('Discussions') }}
                        </x-nav-link>
                    </div>

                    <div class="hidden space-x-4 sm:flex">
                        @isset($actions)
                            <div class="self-center">
                                {{ $actions }}
                            </div>
                        @endisset

                        @auth
                            <!-- Settings Dropdown -->
                            <div class="self-center">
                                <x-dropdown align="right"
                                    width="48">
                                    <x-slot name="trigger">
                                        <button
                                            class="flex items-center text-sm font-semibold text-gray-700 transition duration-150 ease-in-out hover:text-gray-800 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:border-gray-300">
                                            <div>{{ Auth::user()->name }}</div>

                                            <div class="ml-1">
                                                <x-heroicon-o-chevron-down class="w-4 h-4" />
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <!-- Authentication -->
                                        <form method="POST"
                                            action="{{ route('logout') }}">
                                            @csrf

                                            <x-dropdown-link :href="route('logout')"
                                                onclick="
                                                                                            event.preventDefault();
                                                                                            this.closest('form').submit();
                                                                                        ">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @endauth

                    </div>

                    <!-- Hamburger -->
                    <div class="flex items-center -mr-2 sm:hidden">
                        <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                            <svg class="w-6 h-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }"
                                    class="inline-flex"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }"
                                    class="hidden"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': open, 'hidden': ! open}"
                    class="hidden sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        @auth
                            <x-responsive-nav-link :href="route('admin.dashboard')"
                                :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-responsive-nav-link>
                        @endauth
                        @guest
                            <x-responsive-nav-link :href="route('login')"
                                :active="request()->routeIs('login')">
                                {{ __('Login') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('register')"
                                :active="request()->routeIs('register')">
                                {{ __('Register') }}
                            </x-responsive-nav-link>
                        @endguest
                    </div>

                    @isset($actions)
                        <div class="flex gap-2 px-4 py-2 border-t border-gray-100">
                            {{ $actions }}
                        </div>
                    @endisset

                    @auth
                        <!-- Responsive Settings Options -->
                        <div class="pt-4 pb-1 border-t border-gray-100">
                            <div class="px-4">
                                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <!-- Authentication -->
                                <form method="POST"
                                    action="{{ route('logout') }}">
                                    @csrf

                                    <x-responsive-nav-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-responsive-nav-link>
                                </form>
                            </div>
                        </div>
                    @endauth

                </div>
            </nav>

            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
</x-skeleton>
