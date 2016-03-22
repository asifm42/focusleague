@extends('layouts.default')
@section('title','FOCUS League – Create Transaction')

@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Create a transaction</h4>
            <h3 class="hidden-xs hidden-sm">Create a transaction</h3>
            <p>Create a new transaction</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('transactions.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
@endsection