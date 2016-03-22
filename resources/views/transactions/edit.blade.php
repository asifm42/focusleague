@extends('layouts.default')
@section('title','FOCUS League – Edit Transaction')
@section('styles')

@stop
@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Edit Transaction</h4>
            <h3 class="hidden-xs hidden-sm">Edit Transaction</h3>
            <p>Make changes to a Transaction.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('transactions.forms.create', ['edit' => true])
            </div>
        </div>
    </div>
@stop