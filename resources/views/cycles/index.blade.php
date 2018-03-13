@extends('layouts.default')
@section('title','FOCUS League – Cycles')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                <h3 class="text-center">Cycles</h3>
                <div class="list-group text-center">
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
            </div>
        </div>
    </div>
@stop