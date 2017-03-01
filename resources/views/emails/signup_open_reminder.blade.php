@component('emails.layouts.message')
<p>Just a quick friendly reminder to sign-up for Cycle {{ $cycle->name }}! We would hate to not see your beautiful face out there.</p>

@component('mail::button', ['url' => route('cycle.signup.create', $cycle->id), 'color' => 'blue'])
SIGN UP FOR CYCLE {{ $cycle->name }}
@endcomponent

<p>Thanks for your support!</p>
@slot('unsubscribe')
<p><a href="%tag_unsubscribe_url%">Unsubscribe</a> from Cycle {{ $cycle->name }} sign-up reminders.</p>
@endslot
@endcomponent