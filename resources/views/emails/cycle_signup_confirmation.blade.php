@component('emails.layouts.message', ['user' => $signup->user ])
<p>Thanks for signing up for Cycle {{ $cycle->name }}!</p>

@if($signup->will_captain)
<p>And thank you for willing to be a captain. We'll be in touch soon to let you know if we need your leadership.</p>
@endif

@if($signup->div_pref_first === $signup->div_pref_second || empty($signup->div_pref_second))
<p>Looks like you have signed up for the {{ $signup->div_pref_first }} division and plan to sit out if we don't have that division.</p>
@else
<p>Looks like you are willing to play in either division with your first preferance being {{ $signup->div_pref_first }}. We appreciate your flexibility.</p>
@endif

<p>We plan to see you at HSP on </p>
<ul>
@foreach($attendingDates as $date)
    <li>{{ $date }}</li>
@endforeach
</ul>
@if(count($missingDates))
<p>We'll miss you on </p>
<ul>
    @foreach($missingDates as $date)
        <li>{{ $date }}</li>
    @endforeach
</ul>
@endif

<p>Your cycle fee is ${{ $signup->cost() }}. We'll charge your account when we place you on a team.</p>

<p>If you need to change any of that, you can <a href="{{ route('cycle.signup.edit', $cycle->id) }}">edit your sign-up info here</a>.</p>

<p>See who else is signed up and other <a href="{{ route('cycles.view', $cycle->id) }}">cycle details here</a>.</p>

<p>You'll get another email when you are placed on a team. Once again, thanks for playing, the FOCUS League wouldn't be possible without your participation.</p>

<p>See you at the fields.</p>
@endcomponent