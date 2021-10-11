@extends('users.dashboard.template')

@section('content')
    <div class="text-xl">
        <p>Welcome,</p>
        <h1 class="font-sans font-semibold">{{ auth()->user()->name }}</h1>
    </div>
@endsection
