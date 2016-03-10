@extends('layouts.default')
@section('title','FOCUS League – Error')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <h2>
                <i class="fa fa-exclamation-triangle"></i>
                <strong>Whoops!</strong>
            </h2>
            <div class="well error">
                <p>Sorry for the inconvienence but it seems like you have stumbled across an unexpected error. We have been notified of the error and will be investigating it soon.</p>

                <p>Most of these errors can be resolved by <a href="{{ url('signout') }}">signing out</a> and signing back in.</p>

                <p>If you encounter this error repeatedly, please feel free to reach out to our support team at <a href="mailto:support@focusleague.com">support@focusleague.com</a>.</p>
            </div>
        </div>
    </div>
</div>

@stop