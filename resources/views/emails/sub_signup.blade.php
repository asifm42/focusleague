@component('emails.layouts.message', [ 'user' => $sub->user ])
<p>Thanks for signing up as a sub for Cycle {{ $sub->week->cycle->name }} - Week {{ $sub->week->index() }} on {{ $sub->week->starts_at->toFormattedDateString() }}!</p>

<p>As mentioned before, a sub spot is not guaranteed. We'll be in touch soon if we need your talent.</p>

<p>Your sub fee is ${{ config('focus.cost.cycle.sub') }}. We'll charge your account if and when we place you on a team.</p>

<p>See who else is signed up and other <a href="{{ route('cycles.view', $sub->week->cycle->id) }}">cycle details here</a>.</p>

<p>Once again, thanks for playing, the FOCUS League wouldn't be possible without your participation.</p>
@endcomponent