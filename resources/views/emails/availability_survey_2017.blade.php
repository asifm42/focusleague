@component('emails.layouts.message', ['user' => $user])
<p>There are so many opportunities in the community for Ultimate during the summer. We have the HUC Summer League, Nasa League, club team practices, weekend tournaments, etc. Is there room for FOCUS League? You decide! </p>

<p>As always, FOCUS League will continue to offer competitive Ultimate if the community supports it. Numbers were dangerously low this past cycle. So please <a href="https://goo.gl/forms/lhMzqCJDsBk1Vhl33">take a minute to fill out this google form</a> and let us know if you still plan on coming out to FOCUS League for the remaining Tuesdays this season.</p>

<p><strong>Please try to fill out the form by midnight Wednesday, June 21st</strong>. We will make a decision by Thursday afternoon. If we have enough numbers, then we will continue. If we don't have the numbers, then we will shut it down and start it back up next Spring.</p>

<p>This is an informal survey. If we continue FOCUS League this year, we will take sign-ups for each cycle through the website as usual.</p>

@component('mail::button', ['url' => "https://goo.gl/forms/lhMzqCJDsBk1Vhl33", 'color' => 'blue'])
Take the survey
@endcomponent

@endcomponent