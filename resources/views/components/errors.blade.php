<div x-cloak
    x-data="{
        show: true,
        loading: true,
        init(){
            setTimeout(() => this.loading = false, 500); 
            setTimeout(() => this.show = false, 5000);
        }
    }"
    x-show="show && !loading"
    class="fixed z-50 w-full max-w-sm transition transform -translate-x-1/2 top-4 left-1/2 duration-400 ease"
    x-transition:enter="ease-in duration-150"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-out duration-500"
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="-translate-y-full opacity-0">
    <div>
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif
        
        @if (session('warning'))
            <x-alert type="warning">{{ session('warning') }}</x-alert>
        @endif

        @if (session('error'))
            <x-alert type="danger">{{ session('error') }}</x-alert>
        @endif
        
        @if (session('danger'))
            <x-alert type="danger">{{ session('danger') }}</x-alert>
        @endif
    </div>
    <div>
        @if ($errors->any())
            <x-alert type="warning">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif
    </div>

</div>
