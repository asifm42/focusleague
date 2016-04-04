@extends('layouts.email')

@section('content')
    <p>Looks like you have an outstanding balance of {{ $balance }} on your account. We would greatly appreciate it if you can take care of the payment asap using one of the following methods of payment (listed in order of preference).</p>

    <ul>
        <li>Paypal to {{ 'asifm42@gmail.com (please try to avoid fees)' }}</li>
        <li>Chase Quickpay to asifm42@gmail.com</li>
        <li>Square Cash at <a href="https://cash.me/asifm42">cash.me/asifm42</a> (pay with your debit card, no account needed)</li>
        <li>Check to "Asif Mohammed"</li>
        <li>Exact cash to Asif at the fields</li>
    </ul>

    <p>You can view your <a href={{ route('balance.details', $user['id']) }}>balance details</a> here. If you feel that the balance is incorrect or we missed a payment then please reply back with the details and we will fix it asap.</p>

    <p>Thanks for playing in the FOCUS League. It wouldn't exist without your support.</p>
@stop
