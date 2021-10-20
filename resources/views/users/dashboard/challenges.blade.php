@extends('users.dashboard.template')

@section('content')

    <div class="mb-4">
        <h1 class="text-xl font-semibold sm:text-2xl">Your Challenges</h1>
        <p>The challenges you have created or has participated to.</p>
    </div>

    <div class="flex flex-col gap-6">

        @foreach ($challenges as $challenge)
            <x-challenge-card :challenge="$challenge" />
        @endforeach

    </div>

    <div class="my-6">
        {{ $challenges->links() }}
    </div>

@endsection
