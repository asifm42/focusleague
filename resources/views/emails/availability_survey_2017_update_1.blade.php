@component('emails.layouts.message', ['user' => $user])

<p>We have had 35 responses to the <a href="https://goo.gl/forms/lhMzqCJDsBk1Vhl33">availability survey</a> of which 15-20 players are available for July 11, 18, 25, &amp; Aug 1. While that is not enough for two games, we are close to having enough for one mixed game. We are going to leave the survey open for now to see if we have any more interest.</p>

<p><a href="https://goo.gl/forms/lhMzqCJDsBk1Vhl33">Please take a minute to take the availability survey</a> if you haven't yet. Let us know even if you can't make it out any more this season; any response is better than no response.</p>

<p><strong>There will be no games on Tuesday, June 27 or Tuesday, July 4th.</strong></p>

<p>This is an informal survey. If we continue FOCUS League this year, we will take sign-ups for each cycle through the website as usual.</p>

@component('mail::button', ['url' => "https://goo.gl/forms/lhMzqCJDsBk1Vhl33", 'color' => 'blue'])
Let us know your availability
@endcomponent

@endcomponent