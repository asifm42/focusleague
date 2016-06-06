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
                <div class="list-group">
                    @foreach($cycles as $cycle)
                        @if($current_cycle && $cycle->id === $current_cycle->id)
                            <a href={{ route('cycles.view', $cycle->id) }} class="list-group-item active">
                                <span class="badge">current</span>
                                {{ $cycle->name }}
                            </a>
                        @elseif($next_cycle && $cycle->id === $next_cycle->id)
                            <a href={{ route('cycles.view', $cycle->id) }} class="list-group-item">
                                <span class="badge">next</span>
                                <span class="text-primary">{{ $cycle->name }}</span>
                            </a>
                        @else
                            <a href={{ route('cycles.view', $cycle->id) }} class="list-group-item text-success">
                                <span class="text-primary">{{ $cycle->name }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
{{--
                <ul class="list-unstyled">
                    @foreach($cycles as $cycle)
                        @if($current_cycle && $cycle->id === $current_cycle->id)
                            <li><a href={{ route('cycles.view', $cycle->id) }}>{{ $cycle->name }} (current)</a></li>
                        @elseif($next_cycle && $cycle->id === $next_cycle->id)
                            <li><a href={{ route('cycles.view', $cycle->id) }}>{{ $cycle->name }} (next)</a></li>
                        @else
                            <li><a href={{ route('cycles.view', $cycle->id) }}>{{ $cycle->name }}</a></li>
                        @endif
                    @endforeach
                </ul>
--}}
            </div>
        </div>
    </div>
@stop