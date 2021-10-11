<x-app-layout>

    <div class="container relative">
        <div class="flex">
            <div class="relative self-center flex-1 py-10">
                <h1 class="mb-6 text-2xl font-black !leading-tight lg:mb-10 sm:text-4xl lg:text-7xl">
                    Get <span class="text-primary-500">New Book</span> <br> in Exchange of <br> Your <span class="text-red-400">Old Book</span>
                </h1>

                <x-link-button class="px-6 py-3 text-lg" :href="route('exchanges.index')">
                    Exchange Books
                    <x-heroicon-s-arrow-right class="ml-4" />
                </x-link-button>

                <div>
                    <x-heroicon-s-book-open class="absolute left-0 w-40 h-40 transform -rotate-45 opacity-20 top-full" />
                    <div class="absolute bottom-0 transform -rotate-12 right-1/4 opacity-20">
                        <svg class="w-24 h-24 fill-current" height="512" viewBox="0 0 509.035 509.035" width="512" xmlns="http://www.w3.org/2000/svg">
                            <path d="M509.032 38.266c-.032-12.515-13.829-20.17-24.467-13.537-120.825 75.354-247.846 192.407-306.319 193.954-49.274-44.23-88.855-60.793-120.9-50.628C29.683 176.83 10.516 205.07.378 251.99c-2.841 13.152 10.897 23.739 22.889 17.643 25.909-13.169 44.635-13.591 62.494-1.382 34.42 27.501 29.27 115.717 74.682 139.303 29.759 15.457 66.558 16.663 109.63 3.637 6.961 35.506 42.005 62.156 72.533 81.509 3.91 2.479 8.823 3.203 13.439 1.727 72.484-23.179 130.193-84.06 95.481-149.315-3.521-6.62-11.164-9.908-18.396-7.906-28.913 8.005-59.475 5.638-93.381-7.24l-14.497-9.551c147.667-14.259 184.149-133.178 183.78-282.149z"/>
                            <path d="M187.586 184.44c29.099-9.479 73.521-40.8 98.779-58.867-8.252-42.184-30.014-77.864-60.654-107.268-8.827-8.474-23.546-4.274-26.578 7.576l-35.825 139.955c7.92 5.503 16.01 11.701 24.278 18.604z"/>
                        </svg>              
                    </div>
                </div>

            </div>
            <div class="w-1/3">
                <x-img class="w-full" :src="asset('images/reader.jpg')" />
            </div>
        </div>
    </div>

</x-app-layout>
