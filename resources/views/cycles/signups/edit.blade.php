@extends('layouts.default')
@section('title','FOCUS League – Edit Cycle Signup')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <h5 class="text-center">Cycle {{ $cycle->name }} {{ !empty($signup) ? 'Player' : 'Sub'}} Sign-up</h5>
                <p class="text-center my-2"><span class="badge badge-warning">Editing</span></p>
            </div>
        </div>
    </div>
    @if(!empty($signup))
        <cycle-signup
            :user="{{ $user->toJson() }}"
            :cycle="{{ $cycle->toJson() }}"
            :signuporiginal="{{ $signup->toJson() }}"
            :availability="{{ $availability->toJson() }}"
        ></cycle-signup>
    @elseif(!empty($weeks_subbing))
        <cycle-signup
            :user="{{ $user->toJson() }}"
            :cycle="{{ $cycle->toJson() }}"
            :suboriginal="{{ $weeks_subbing->toJson() }}"
        ></cycle-signup>
    @endif
@endsection