@component('emails.layouts.message', ['user' => $user ])
<p>
    Aww yeah, time to dust off those cleats and start preppin' for the 2020 season. Come get some competitive reps at FOCUS League! Games will be on Thursdays, 8p-10p at the Houston Sports Park.
</p>
<p>
    <b>Cycle 2020-01 registration will open this Friday, February 28th.</b> First game will be on Thursday, March 5th. See the <a href="https://focusleague.com">website</a> for the full schedule.
</p>

<p>
    Now would be a good time to <a href="{{ route('users.ultimate_history.edit', $user->id) }}">update your Ultimate history.</a> This will help us balance teams.</p>
</p>

@component('mail::button', ['url' => route('users.ultimate_history.edit', $user->id), 'color' => 'green'])
UPDATE YOUR ULTIMATE HISTORY
@endcomponent

<p>
    Help us spread the word! Tell your friends. Follow us on <a href="https://twitter.com/focusleague">Twitter</a>. Like us on <a href="https://facebook.com/focusleague">Facebook</a>.
</p>
<p>Lets play hard and lets play fair!</p>
@endcomponent