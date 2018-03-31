@extends('layouts.default')
@section('title','FOCUS League – Create Transaction')
@section('styles')
<style>
    .amount > .input-group > .input-group-addon {
        padding:0 2px 0 0;
    }
</style>
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h4 class="text-center">Create a transaction</h4>
        </div>
        <div class="row justify-content-center">
            <div class="col col-sm-8 col-md-6">
                @include('transactions.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
@endsection