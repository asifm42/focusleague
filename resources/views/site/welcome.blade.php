@extends('layouts.default')
@section('title','FOCUS League – Welcome')
@section('styles')

@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="text-center hidden-md hidden-lg">
                    <div><img src="{{ asset('assets/img/logo.png') }}" class="logo-welcome-mobile"></div>
                    <h5>Fostering Organized Competitive Ultimate Series</h5>
                    <!-- <h5><span class = "emphasize">F</span>ostering <span class = "emphasize">O</span>rganized <strong>C</strong>ompetitive <strong>U</strong>ltimate <strong>S</strong>eries</h5> -->
                    <h6>Every Tuesday, 8p-10p, starting March 15 at the Houston Sports Park</h6>
                    <div class="jumbotron">
                        <h4>The Mission</h4>
                        <p>To structure would-be pickup games into a league and increase the availability of competitive Ultimate in Houston.</p>
                    </div>
                </div>
                <div class="text-center hidden-xs hidden-sm">
                    <div><img src="{{ asset('assets/img/logo.png') }}" class="logo-welcome-desktop"></div>
                    <h3>Fostering Organized Competitive Ultimate Series</h3>
                    <h5>Every Tuesday, 8p-10p, starting March 15 at the Houston Sports Park</h5>
                    <div class="jumbotron">
                        <h4>The Mission</h4>
                        <p>To structure would-be pickup games into a league and increase the availability of competitive Ultimate in Houston.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection