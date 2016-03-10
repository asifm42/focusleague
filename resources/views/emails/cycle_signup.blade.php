@extends('layouts.email')

@section('content')
    <p>Thanks for signing up for Cycle {{ $cycle['name'] }}!</p>
    @if($signup['will_captain'])
        <p>And thank you for willing to be a captain. We'll be in touch soon to let you know if we need your leadership.</p>
    @endif

    @if($signup['div_pref_first'] === $signup['div_pref_second'] || empty($signup['div_pref_second']))
        <p>Looks like you have signed up for the {{ $signup['div_pref_first'] }} division and plan to sit out if we don't have that division.</p>
    @else
        <p>Looks like you are willing to play in either division with your first preferance being {{ $signup['div_pref_first'] }}. We appreciate your flexibility.</p>
    @endif

    <p>We plan to see you at HSP on </p>
    <ul>
        @foreach($dates_attending as $date)
            <li>{{ $date }}</li>
        @endforeach
    </ul>
@if(count($dates_missing))
    <p>We'll miss you on </p>
    <ul>
        @foreach($dates_missing as $date)
            <li>{{ $date }}</li>
        @endforeach
    </ul>
@endif

    <p>Your cycle fee is {{ $cost }}. We'll charge your account when we place you on a team.

    <p>If you need to change any of that, you can <a href="{{ route('cycle.signup.edit', $cycle['id']) }}">edit your sign-up info here</a>.</p>
{{----}}
{{--
    @if ($user->balance > 0)
        <p>Your current balance is {{ $user->balance() }}. Please make sure you pay before your first game. Otherwise, You can pay via<br />
        - Paypal to asifm42@gmail.com<br />
        - Chase Quickpay to asifm42@gmail.com<br />
        - Square Cash at cash.me/asifm42<br />
        - Check to "Asif Mohammed"<br />
        - Cash to Asif or your captain</p>
    @else

    @endif
--}}
    <p>See who else is signed up and other <a href="{{ route('cycles.view', $cycle['id']) }}">cycle details here</a>.</p>

    <p>You'll get another email when you are placed on a team. Once again, thanks for playing, the FOCUS League wouldn't be possible without your participation.</p>

    <p>See you at the fields.</p>

@endsection