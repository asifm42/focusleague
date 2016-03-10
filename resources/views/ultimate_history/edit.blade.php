@extends('layouts.default')
@section('title','FOCUS League – Edit Player Utlimate History')
@section('styles')

@stop
@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Edit Utlimate History</h4>
            <h3 class="hidden-xs hidden-sm">Edit Utlimate History</h3>
            <p>Make changes to your Utlimate History.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('ultimate_history.forms.create', ['edit' => true])
            </div>
        </div>
    </div>
@stop