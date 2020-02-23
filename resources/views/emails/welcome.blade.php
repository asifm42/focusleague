@component('emails.layouts.message', ['user' => $user ])
<p><b>Welcome to FOCUS League!</b> Your email address has now been verified and you can sign into your account at <a href="{!! route('sessions.create') !!}">{!! route('sessions.create') !!}</a>.</p>

<p>You can view your info and current cycle details on <a href="{{ route('users.dashboard') }}">your dashboard</a>. BUT before you can do that, we need you <a href="{{ route('ultimate_history.create') }}">share your Ultimate history with us.</a> This will help us balance teams.</p>

@component('mail::button', ['url' => route('ultimate_history.create'), 'color' => 'green'])
SHARE YOUR ULTIMATE HISTORY
@endcomponent

<p>Make sure to check out the <a href="{{ route('site.faq') }}">FAQ page</a> so there are no surprises.</p>

<p>Should you ever encounter problems with your account or forget your password, we will contact you at this address.</p>

<p>Lets play hard and lets play fair!</p>
@endcomponent