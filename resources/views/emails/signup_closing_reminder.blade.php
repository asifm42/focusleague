@extends('layouts.email')

@section('content')

    <p>Just a quick friendly reminder that sign-up for Cycle {{ $cycle->name }} is closing soon!{{-- at {{ $cycle->signup_closes_at->toDayDateTimeString() }}.--}} We would hate to not see your beautiful face out there.</p>

    <p><a href="{{ route('cycle.signup.create', $cycle->id) }}">SIGN UP FOR CYCLE {{ $cycle->name }}</a></p>

    <p>Thanks for your support!</p>
@stop