@extends('users.dashboard.template')

@section('content')

    <div class="mb-4">
        <h1 class="text-xl font-semibold sm:text-2xl">Your Challanges</h1>
        <p>The challanges you have created or has participated to.</p>
    </div>

    <div class="flex flex-col gap-6">

        @foreach ($challanges as $challange)
            <x-challange-card :challange="$challange" />
        @endforeach

    </div>

    <div class="my-6">
        {{ $challanges->links() }}
    </div>

@endsection
