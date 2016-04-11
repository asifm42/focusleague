@extends('layouts.email')

@section('content')

    <p>We noticed that you played in the last cycle but haven't signed up for Cycle {{ $cycle->name }} yet. We just wanted to check in with you to make sure you enjoyed your experience last cycle. If you have any feedback on the league, we would love to hear it. Please feel free to share your thoughts with us by replying to this email.</p>

    <p>If signing-up simply slipped your mind, no sweat! It's not too late to <a href="{{ route('cycle.signup.create', $cycle->id ) }}">SIGN UP FOR CYCLE {{ $cycle->name }}</a>.</p>

    <p>Thanks for your support!</p>
@stop