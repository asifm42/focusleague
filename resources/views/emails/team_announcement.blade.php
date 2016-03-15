@extends('layouts.email')

@section('content')
    <p>Cycle {{ $cycle['name'] }} teams have been set!</p>

    <p>The format for the cyle is {{ $cycle['format'] }}.<p>

    <p>You are on team <em>{{ ucwords($team['name']) }}</em> in the {{ ucfirst($team['division']) }} division.</p>

    @if (count($captains) > 1)
        <p>Your captains are:</p>
        <ul>
            @foreach($captains as $captain)
                <li>{{ $captain['nickname'] }} - {{ $captain['email'] }}</li>
            @endforeach
        </ul>
    @elseif (count($captains) == 1)
        <p>Your captain is {{ $captains[0]['nickname'] }} and can be reached at {{ $captains[0]['email'] }}.</p>
    @else
        <p>We are working on selecting a captain since no one volunteered. Please let us know if you have changed your mind and are willing to captain this cycle.</p>
    @endif

    <p>Your fees for this cycle is ${{ $cost }}.00. Please use one of the following methods of payment (listed in order of preferance). Please put "Cycle {{ $cycle['name'] }} fees" in the note if possible.</p>
    <ul>
        <li>Paypal to asifm42@gmail.com</li>
        <li>Chase Quickpay to asifm42@gmail.com</li>
        <li>Square Cash at <a href="https://cash.me/asifm42">cash.me/asifm42</a></li>
        <li>Check to "Asif Mohammed"</li>
        <li>Cash to Asif at the fields</li>
    </ul>

    <p>More details such as your team's schedule and other teams can be found on the <a href="{{ route('cycles.view', $cycle['id']) }}">cycle details</a> page.</p>

    <p>Games are at the <a href="https://goo.gl/maps/QCZxXVm6Ua32">Houston Sports Park</a>.</p>

    <p>Please bring a white and non-grey dark jersey. Captains will be flipping for jersey color prior to start time.</p>

    <p>Let's play hard. Let's play fair.</p>
@endsection