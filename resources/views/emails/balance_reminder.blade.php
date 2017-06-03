@component('emails.layouts.message', ['user' => $user])
@component('site.payment_methods', ['balance' => $user->getBalanceInDollars()])
<p>Looks like you have an outstanding balance of {{ $user->getBalanceString() }} on your account. We would greatly appreciate it if you can take care of the payment asap using one of the following methods of payment (listed in order of preference).</p>
@endcomponent

<p>You can view your <a href={{ route('balance.details') }}>balance details</a> here. If you feel that the balance is incorrect or we missed a payment then please reply back with the details and we will fix it asap.</p>

<p>Thanks for playing in the FOCUS League. It wouldn't exist without your support.</p>
@endcomponent
