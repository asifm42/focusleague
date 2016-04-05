@extends('layouts.default')
@section('title','FOCUS League – Cycles')

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h4 class="hidden-md hidden-lg">Cycles</h4>
                    <h3 class="hidden-xs hidden-sm">Cycles</h3>
                    <p>List of cycles</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-3">
                <ul class="list-unstyled">
                    @foreach($cycles as $cycle)
                        @if($cycle->id === $current_cycle->id)
                            <li><a href={{ route('cycles.view', $cycle->id) }}>{{ $cycle->name }} (current)</a></li>
                        @else
                            <li><a href={{ route('cycles.view', $cycle->id) }}>{{ $cycle->name }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop