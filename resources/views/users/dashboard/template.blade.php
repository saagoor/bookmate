<x-app-layout title="Dashboard">

    <div class="container my-10">
        <div class="flex gap-8">
            <div class="sticky flex flex-col self-start gap-2 px-2 py-4 bg-white rounded-lg w-60">
                <x-sidebar-nav-link icon="heroicon-s-home"
                    :href="route('dashboard.index')"
                    :active="request()->routeIs('dashboard.index')">Dashboard</x-sidebar-nav-link>

                <x-sidebar-nav-link icon="heroicon-s-hand"
                    :href="route('dashboard.exchanges')"
                    :active="request()->routeIs('dashboard.exchanges')">Exchanges</x-sidebar-nav-link>

                <x-sidebar-nav-link icon="heroicon-s-users"
                    :href="route('dashboard.challenges')"
                    :active="request()->routeIs('dashboard.challenges')">Challenges</x-sidebar-nav-link>
            </div>
            <div class="flex-1">
                @yield('content')
            </div>
        </div>
    </div>

</x-app-layout>
