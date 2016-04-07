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
                    <div class="jumbotron hidden" style="background-color: #ffff99;" >
                        <h4>Game Status for Tuesday, Mar 29</h4>
                        <p>We are aware of the potential rainout. As of 4:45pm, Games are on schedule. If HSP is closed, games will be canceled. HSP will communicate park closure via their <a href="http://www.houstonsportspark.com">website</a> and <a href="https://twitter.com/HoustonSportsPk?ref_src=twsrc%5Etfw">twitter feed</a>.</p>
                    </div>
                    <h6>Tuesdays, 8p-10p, at the <a href="https://www.google.com/maps/place/Houston+Sports+Park/@29.6379651,-95.3959319,15z/data=!4m2!3m1!1s0x0:0xfb9729c16219059c">Houston Sports Park</a></h6>

                    <h4><a href="{{ route('cycles.view', 'current') }}">Sign up for Cycle 2016-02 is now open!</a></h4>

                    @if(auth()->check())
                        <a href="{{ route('users.dashboard') }}" class ="btn btn-primary btn-lg" style="margin-bottom:15px;"><i class="fa fa-tachometer"></i>&nbsp; Dashboard</a>
                    @else
                        <a href="{{ route('users.create') }}" class ="btn btn-primary btn-lg" style="margin-bottom:15px;">Get your player account here</a>
                    @endif

                    <div class="jumbotron">
                        <h4>The Mission</h4>
                        <p>To structure would-be pickup games into a league and increase the availability of competitive Ultimate in Houston.</p>
                    </div>
                </div>
                <div class="text-center hidden-xs hidden-sm">
                    <div><img src="{{ asset('assets/img/logo.png') }}" class="logo-welcome-desktop"></div>
                    <h3>Fostering Organized Competitive Ultimate Series</h3>
                    <div class="jumbotron hidden" style="background-color: #ffff99;">
                        <h3>Game Status for Tuesday, Mar 29</h3>
                        <p>We are aware of the potential rainout. As of 4:45pm, Games are on schedule. If HSP is closed, games will be canceled. HSP will communicate park closure via their <a href="http://www.houstonsportspark.com">website</a> and <a href="https://twitter.com/HoustonSportsPk?ref_src=twsrc%5Etfw">twitter feed</a>.</p>
                    </div>
                    <h5>Tuesdays, 8p-10p, at the <a href="https://www.google.com/maps/place/Houston+Sports+Park/@29.6379651,-95.3959319,15z/data=!4m2!3m1!1s0x0:0xfb9729c16219059c">Houston Sports Park</a></h5>

                    <h4><a href="{{ route('cycles.view', 'current') }}">Sign up for Cycle 2016-02 is now open!</a></h4>

                    @if(auth()->check())
                        <a href="{{ route('users.dashboard') }}" class ="btn btn-primary btn-lg" style="margin-bottom:15px;"><i class="fa fa-tachometer"></i>&nbsp; Dashboard</a>
                    @else
                        <a href="{{ route('users.create') }}" class ="btn btn-primary btn-lg" style="margin-bottom:15px;">Get your player account here</a>
                    @endif

                    <div class="jumbotron">
                        <h4>The Mission</h4>
                        <p>To structure would-be pickup games into a league and increase the availability of competitive Ultimate in Houston.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection