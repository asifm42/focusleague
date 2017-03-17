@extends('layouts.default')
@section('title','FOCUS League – FAQ')
@section('styles')

@stop
@section('content')
    <div class="page-header">
        <div class="container">
            <h4>Frequently Asked Questions</h4>
            <p>Helpful information about the league</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-10">
                <div class="panel-group" id="faq_list" role="tablist" aria-multiselectable="true">

@component('site.question', [ 'id' => '1'])
    @slot('question')
        What is the FOCUS League?
    @endslot
    @slot('answer')
        <p>The FOCUS League is a competitive Ultimate league in Houston intended for players with intermediate to advanced skills in the sport of Ultimate. The mission of this league is to structure would-be pick-up games into a series of 3-4 week cycles and increase the availability of competitive Ultimate in Houston. Registered players will be divided into X number of teams and remain together for a 3-4 week cycle. Each team will have a team captain(s) who will lead the team in developing the team offense and defense (i.e., teams will call offensive plays, call defenses with a marking direction, work on zones, crumbles, and any other strategic points of interest of the team).</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '2'])
    @slot('question')
        What is the spirit of the FOCUS League?
    @endslot
    @slot('answer')
        <p>The spirit of the FOCUS League stresses the highest level of sportsmanship and fun, hard, fair, competitive play. Players are expected to be competitive while respecting their teammates AND their opponents and avoiding dangerous, "win at all costs" plays.</p>

        </p>Note: Anyone not accounting for themselves in accordance with the spirit of the league may be asked by the League Organizers to excuse themselves from the league indefinitely.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '3'])
    @slot('question')
        What is the format?
    @endslot
    @slot('answer')
        <p>The ideal format is to have one Mens 7v7 game and one Mixed (4/3 or 5/2) or Womens 7v7 game. However, the format for each cycle will be determined by the number and gender ratio of registered players. It could be two Mens 5v5 games and one Womens 5v5 game. It could be two 7v7 Mixed games. It could be one Mens 5v5 game, one Mixed 5v5 game and one Womens 5v5 game. It could be two Mens 7v7 games. It could be...you get the idea.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '4'])
    @slot('question')
        What if I don’t want to play in a certain division (i.e mens, womens, mixed)?
    @endslot
    @slot('answer')
        <p>When signing up for a cycle, you will be able to indicate your first and second preference for a division. By leaving the second one blank, you will be indicting that you would prefer to sit out the cycle if there are not enough signups to support a game for your division.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '5'])
    @slot('question')
        What is the schedule?
    @endslot
    @slot('answer')
        <p>Games will be hosted at the <a href="https://www.google.com/maps/place/Houston+Sports+Park/@29.6379651,-95.3981206,17z/data=!3m1!4b1!4m5!3m4!1s0x8640ead4ea8ecac5:0xfb9729c16219059c!8m2!3d29.6379651!4d-95.3959319">Houston Sports Park</a> on Tuesday nights, 8p-10p. The number of games each night will be determined by the format.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '6'])
    @slot('question')
        Who can play?
    @endslot
    @slot('answer')
        <p>The FOCUS League is open to spirited, competitive male and female players who want to improve their skills through playing high level Ultimate in the framework of a team by practicing the same skills for 3-4 weeks with the same group of similarly minded players. We may cap the number of signups on a given cycle depending on availability.</p>

        <p>The FOCUS League takes the <a href="http://www.usaultimate.org/spirit">“Spirit of the Game”</a> very seriously. The league stresses the highest level of sportsmanship and fun, hard, fair, competitive play. Players are expected to be competitive while respecting their teammates AND their opponents and avoiding dangerous, "win at all costs" plays.</p>

        <p>Note: Anyone not accounting for themselves in accordance with the spirit of the league may be asked by the League Organizers to excuse themselves from the league indefinitely.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '7'])
    @slot('question')
        What if I am a beginner?
    @endslot
    @slot('answer')
        <p>You are still able to sign up and give the FOCUS League a try. However, keep in mind that the FOCUS League is intended for the experienced player. If you do not understand terms/concepts like force, flick, backhand, hammer, scoober, huck, cut, vertical stack offense, horizontal offense, man defense, zone defense, zone crumble, zone cup, foul, pick, poach, etc, as they relate to Ultimate then you may not find the FOCUS League an enjoyable experience. If you cannot throw a 15 yard leading flick and backhand with accuracy to a receiver, then you may not find the FOCUS League an enjoyable experience.</p>

        <p>If you are still unsure if this league is for you, feel free to get in touch with us to discuss it.</p>

        <p>If you feel that the FOCUS League is not for you, the <a href="http://www.houstonultimate.org">Houston Ultimate Community (HUC)</a> hosts a variety of beginner/recreational leagues and tournaments.</p>

        <p>Note: While the league organizers do not want to exclude anyone, if a large disparity in level of play develops, the league organizers may request less skilled players to excuse themselves. In the unlikely event this occurs it will include a refund of the remaining game fees.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '8'])
    @slot('question')
        How do I sign up?
    @endslot
    @slot('answer')
        <p>You will need a player account (<a href="{{ route('users.create') }}">get one here</a>) and each cycle will have its own registration form online. You can find a link to sign up as a player or a sub for the current cycle on the cycle details page or the <a href="{{ route('users.dashboard') }}">player dashboard</a>.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '9'])
    @slot('question')
        When will sign ups open?
    @endslot
    @slot('answer')
        <p>Cycle sign-ups will typically open 6-7 days prior to the first day of that cycle. Sign-ups will typically close at 3p on the first day of the cycle.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '10'])
    @slot('question')
        What if I can't play all 3-4 weeks?
    @endslot
    @slot('answer')
        <p>You must be available at least 2 of the 3-4 weeks to sign up. Otherwise, you can sign up as a weekly sub. Weekly subs are not guaranteed play until they are notified.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '11'])
    @slot('question')
        What's a sub?
    @endslot
    @slot('answer')
        <p>If a player can't make at least 2 of the 3-4 weeks in the cycle or they have missed the sign-up period, then they can sign up as a weekly sub. If there is a spot open for that night, the sub will be notified via email or phone. Sub sign-up links can be found on the cycle details page or on the <a href="{{ route('users.dashboard')}}">player dashboard</a>.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '12'])
    @slot('question')
        How much does it cost?
    @endslot
    @slot('answer')
        <p>Subs - ${{ config('focus.cost.cycle.sub') }}/week</p>
        <p>Sign up for 2 weeks - ${{ config('focus.cost.cycle.two_weeks') }}</p>
        <p>Sign up for 3 weeks - $25</p>
        <p>Sign up for 4 weeks - $30</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '13'])
    @slot('question')
        Can I get a refund if I miss a week?
    @endslot
    @slot('answer')
        <p>Generally, the answer is no as most leagues do not offer refunds for missed games. Additionally, we would like for you to honor your commitment as we have balanced the teams based on your stated availability.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '14'])
    @slot('question')
        How do I make a payment?
    @endslot
    @slot('answer')
         @component('site.payment_methods')
            <p>We accept the following methods of payment (listed in order of preference). Please put "Cycle *name* fees" (i.e. Cycle 2016-01 fees) in the note if possible.</p>
         @endcomponent
    @endslot
@endcomponent

@component('site.question', ['id' => '15'])
    @slot('question')
        Why are you charging money?
    @endslot
    @slot('answer')
        <p>Most of the funds go towards securing fields at the Houston Sports Park which is the premier sports park in Houston with professional sports field maintenance and their field rental prices reflect that. The remaining funds go towards administrative costs.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '16'])
    @slot('question')
        What do I bring to the games?
    @endslot
    @slot('answer')
        <ul class="list-unstyled">
            <li>A white &amp; a non-grey dark jersey. Unless you are notified otherwise.</li>
            <li>Water and/or nutrition</li>
            <li>Hard, spirited, competitive play</li>
            <li>Fun attitude</li>
        </ul>
    @endslot
@endcomponent

@component('site.question', ['id' => '17'])
    @slot('question')
        What are the team captain's duties?
    @endslot
    @slot('answer')
        <p>Each team will have a team captain(s) who will lead the team in developing the team offense and defense (i.e., teams will call offensive plays, call defenses with a marking direction, work on zones, crumbles, and any other strategic points of interest of the team). They will also be involved in balancing the teams for the respective cycle and will also serve as a liaison between the admins and the players; helping take attendance and collecting dues.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '18'])
    @slot('question')
        What are the benefits of being a team captain?
    @endslot
    @slot('answer')
        <p>A chance to practice your team captain and leadership skills. You get to help split up the teams. You will have influence over what the team will be working on that current cycle. And you get a 25% discount on the respective cycle fee.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '19'])
    @slot('question')
        How do I sign up as a team captain?
    @endslot
    @slot('answer')
        <p>Captains can only miss 1 week of the 3-4 week cycle. You can indicate that you are interested in being a captain when signing up for the cycle. We will try to notify you if we need you to captain before the cycle sign up closes but it may be right before the first game.</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '20'])
    @slot('question')
        What does FOCUS stand for?
    @endslot
    @slot('answer')
        <p><strong>F</strong>ostering <strong>O</strong>rganized <strong>C</strong>ompetitive <strong>U</strong>ltimate <strong>S</strong>eries</p>
    @endslot
@endcomponent

@component('site.question', ['id' => '21'])
    @slot('question')
        What is Ultimate?
    @endslot
    @slot('answer')
        <blockquote style="font-size:1em;">
            <p>Ultimate, originally known as ultimate frisbee, is a non-contact team field sport played with a flying disc. Points are scored by passing the disc to a teammate in the opposing end zone. Other basic rules are that players must not take steps while holding the disc, and interceptions, incomplete passes, and passes out of bounds are turnovers. Rain, wind, or occasionally other adversities can make for a testing match with rapid turnovers, heightening the pressure of play.</p>
            <footer><a href="https://en.wikipedia.org/wiki/Ultimate_(sport)">Wikipedia <cite title="Ultimate (sport)">Ultimate (sport)</cite></a></footer>
        </blockquote>
    @endslot
@endcomponent
                </div>
            </div>
        </div>
    </div>
@stop