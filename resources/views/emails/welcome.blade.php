@extends('layouts.email')

@section('content')
    <p><b>Welcome to FOCUS League!</b> Your email address has now been verified and you can sign into your account at <a href="{!! route('sessions.create') !!}">{!! route('sessions.create') !!}</a>.</p>

    <p>Make sure to check out the <b>FAQ page</b> so there are no surprises.</p>

    <p>Should you ever encounter problems with your account or forget your password, we will contact you at this address.</p>

    <p>Game on!</p>
@stop