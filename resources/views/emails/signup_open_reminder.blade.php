@extends('layouts.email')

@section('content')

    <p>Just a quick friendly reminder to sign-up for Cycle {{ $cycleArr['name'] }}!{{-- at {{ $cycle->signup_closes_at->toDayDateTimeString() }}.--}} We would hate to not see your beautiful face out there.</p>

    <p><a href="{{ route('cycle.signup.create', $cycleArr['id']) }}">SIGN UP FOR CYCLE {{ $cycleArr['name'] }}</a></p>

    <p>Thanks for your support!</p>
@stop


@section('unsubscribe')

    <p><a href="%tag_unsubscribe_url%">Unsubscribe</a> from Cycle {{ $cycleArr['name'] }} sign-up reminders.</p>

@stop