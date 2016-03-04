@extends('layouts.email')

@section('content')
    <p>
        Well, we hope this is
        @if ((strpos($name, ' ')))
            {{ strstr($name, ' ', true) }}.
        @else
            {{ $name }}.
        @endif
            Someone tried to register an account at focusleague.com using the name, {{ $name }} and email, {{ $email }}.
    </p>
    <p>If this was you, please confirm your email address by clicking the link below. We will be communicating most league information via email and it is important that we have an accurate email address.</p>

    <p><a href="{{ url('users/verify?confirmation_code=' . $confirmation_code) }}" class="btn-primary" itemprop="url" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 15px; color: #FFF; text-decoration: none; line-height: 1.4; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; text-transform: capitalize; background: #43ac6a; margin: 0; border-color: #3c9a5f; border-style: solid; border-width: 1px; padding: 8px 12px;">Confirm email address</a></p>

    <p>If this was not you, then please disregard this email.</p>
@endsection