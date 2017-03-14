{{ $slot }}
<ul>
<li>Paypal to {{ 'asifm42@gmail.com' }} or <a href="https://www.paypal.me/asifm42/{{ $balance or '' }}">paypal.me/asifm42</a> </li>
<li>Venmo to {{ '@asifm42' }}</li>
<li>Square Cash at <a href="https://cash.me/asifm42/{{ $balance or '' }}">cash.me/asifm42</a> (pay with your debit card, no account needed)</li>
<li>Chase Quickpay to {{ 'asifm42@gmail.com' }}</li>
<li>Check to "Asif Mohammed"</li>
<li><strong>Exact cash</strong> to Asif Mohammed, Nick Carranza or your team captain at the fields. Please <a href="{{ route('contact.create') }}">contact us</a> with the amount and who you paid so we can credit your balance properly.</li>
</ul>