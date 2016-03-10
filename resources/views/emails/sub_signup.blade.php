@extends('layouts.email')

@section('content')
    <p>Thanks for signing up as a sub for Cycle {{ $cycle['name'] }} - Week {{ $week_index }} on {{ $date }}!</p> As mentioned before, a sub spot is not guaranteed. We'll be in touch soon if we need your talent.

    <p>Your sub fee is $10. We'll charge your account when we place you on a team.</p>

    <p>See who else is signed up and other <a href="{{ route('cycles.view', $cycle['id']) }}">cycle details here</a>.</p>

    <p>Once again, thanks for playing, the FOCUS League wouldn't be possible without your participation.</p>
@endsection