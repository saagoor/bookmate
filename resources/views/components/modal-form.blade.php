@props([
    'title' => '',
    'action' => '',
    'method' => 'POST',
    'submitText' => 'Submit',
    'cancelText' => 'Cancel',
    'icon' => 'heroicon-o-exclamation',
])
<x-modal>
    <form action="{{ $action }}"
        method="post"
        enctype="multipart/form-data">
        @csrf
        @method($method)
        <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div
                    class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto rounded-full bg-primary-100 sm:mx-0 sm:h-10 sm:w-10">
                    @svg($icon, ['class' => 'w-6 h-6 text-primary-600'])
                </div>
                <div class="flex-1 mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    @if ($title)
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 sm:text-xl"
                            id="modal-title">
                            {{ $title }}
                        </h3>
                    @endif
                    <div class="mt-2">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        <div class="gap-2 px-4 py-3 bg-gray-100 sm:px-6 sm:flex sm:flex-row-reverse">
            @if ($submitText)
                <x-button>
                    {{ $submitText }}
                </x-button>
            @endif

            @if ($cancelText)
                <x-button type="reset"
                    @click="show = false"
                    color="light">
                    {{ $cancelText }}
                </x-button>
            @endif
        </div>
    </form>
</x-modal>
