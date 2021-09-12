@if (request()->routeIs('admin.users.edit'))
    <x-admin-layout title="Edit User">
        @include('users._edit-form', ['title' => 'Edit User'])
    </x-admin-layout>
@endif