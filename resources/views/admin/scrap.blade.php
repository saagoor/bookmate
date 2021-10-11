<x-admin-layout title="Scrap">
    <div class="max-w-xl px-4 mx-auto my-8">
        <div class="p-4 card">
            <form action=""
                method="POST">
                @csrf
                <div class="flex items-end gap-2">
                    <x-input-text name="book_name"
                        placeholder="হিজিবিজি">Book Name</x-input-text>
                    <x-button class="mb-0.5">Get Price</x-button>
                </div>
            </form>
        </div>
        <table class="card">

        </table>
    </div>
</x-admin-layout>
