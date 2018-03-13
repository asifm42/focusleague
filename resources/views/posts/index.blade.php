@extends('layouts.default')
@section('title','FOCUS League – News')

@section('content')
    <div class="page-header">
        <div class="container">
            <h3 class="">News</h3>
            <p>News updates for the FOCUS League community</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 ">
                @foreach($posts as $post)
                    <div class="card mt-4 mb-4">
                        <div class="card-header">
                            <h5 class="">{{ $post->title }}</h5>
                            <p><small>{{ $post->created_at->toFormattedDateString() }} by {{ $post->author->nickname }}</small></p>
                        </div>
                        <div class="card-body">
                            <p>{!! html_entity_decode($post->content) !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection