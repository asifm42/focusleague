@extends('layouts.email')

@section('content')
    <p>Someone has requested to reset the password for the focusleague.com account associated with this email address.</p>

    <p>If this was you, please start the reset process by clicking the link below. Please note this link will expire in {{ config('auth.reminder.expire', 60) }} minutes.</p>

    <p><a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}" class="btn-primary" itemprop="url" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 15px; color: #FFF; text-decoration: none; line-height: 1.4; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; text-transform: capitalize; background: #43ac6a; margin: 0; border-color: #3c9a5f; border-style: solid; border-width: 1px; padding: 8px 12px;">Reset password</a></p>

    <p>Or copy and paste this link: {{ $link }}</p>

    <p>If you did not make this request, then please disregard this email.</p>
@endsection
