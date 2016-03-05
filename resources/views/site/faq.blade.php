@extends('layouts.default')
@section('title','FOCUS League – FAQ')
@section('styles')

@stop
@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Frequently Asked Questions</h4>
            <h3 class="hidden-xs hidden-sm">Frequently Asked Questions</h3>
            <p>Helpful information about the league</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <div class="panel-group" id="faq_list" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_1">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_1" aria-expanded="false" aria-controls="faq_1">
                                    What is the FOCUS League?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_1">
                            <div class="panel-body">
                                <p>The FOCUS League is a competitive Ultimate league in Houston intended for players with intermediate to advanced skills in the sport of Ultimate. The purpose of this league is to structure would-be pick-up games into a series of 4 week cycles and increase the availability of competitive Ultimate in Houston. Registered players will be divided into X number of teams and remain together for a 4 week cycle. Each team will have a team captain(s) who will lead the team in developing the team offense and defense (i.e., teams will call offensive plays, call defenses with a marking direction, work on zones, crumbles, and any other strategic points of interest of the team).</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_2">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_2" aria-expanded="false" aria-controls="faq_2">
                                    What is the format?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_2">
                            <div class="panel-body">
                                <p>The ideal format is to have one Mens 7v7 game and one Mixed (4/3 or 5/2) or Womens 7v7 game. However, the format for each cycle will be determined by the number and gender ratio of registered players. It could be two Mens 5v5 games and one Womens 5v5 game. It could be two 7v7 Mixed games. It could be one Mens 5v5 game, one Mixed 5v5 game and one Womens 5v5 game. It could be two Mens 7v7 games. It could be...you get the idea.</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_3">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_3" aria-expanded="false" aria-controls="faq_3">
                                    What if I don’t want to play in a certain division (i.e mens, womens, mixed)?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_3">
                            <div class="panel-body">
                                <p>When signing up for a cycle, you will be able to indicate your first and second preference for a division. By leaving the second one blank, you will be indicting that you would prefer to sit out the cycle if there are not enough signups to support a game for your division.</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_4">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_4" aria-expanded="false" aria-controls="faq_4">
                                    What is the schedule?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_4">
                            <div class="panel-body">
                                <p>Games will be hosted at the Houston Sports Park on Tuesday nights, 8p-10p. The number of games each night will be determined by the format.</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_5">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_5" aria-expanded="false" aria-controls="faq_5">
                                    Who can play?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_5">
                            <div class="panel-body">
                                <p>The FOCUS league is open to competitive male and female players who want to improve their skills through playing high level Ultimate in the framework of a team by practicing the same skills for 4 weeks with the same group of similarly minded players. We may cap the number of signups on a given cycle depending on availability</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_6">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_6" aria-expanded="false" aria-controls="faq_6">
                                    What if I am a beginner?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_6">
                            <div class="panel-body">
                            <p>You are still able to play as The FOCUS league does not exclude anyone (unless registration is capped due to capacity). However, the FOCUS league is intended for the experienced player. If you do not understand terms/concepts like force, flick, backhand, hammer, scoober, huck, cut, vertical stack offense, horizontal offense, man defense, zone defense, zone crumble, zone cup, foul, pick, poach, etc, as they relate to Ultimate then you may not find the FOCUS league an enjoyable experience. If you cannot throw a 15 yard leading flick and backhand with accuracy to a receiver, then you may not find the FOCUS league an enjoyable experience.</p>

                            <p>If you feel that the FOCUS League is not for you, the <a href="http://www.houstonultimate.org">Houston Ultimate Community (HUC)</a> hosts a variety of beginner/recreational leagues and tournaments.</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_7">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_7" aria-expanded="false" aria-controls="faq_7">
                                    How do I sign up?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_7">
                            <div class="panel-body">
                                <p>You will need a player account and each cycle will have its own registration form online.</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_8">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_8" aria-expanded="false" aria-controls="faq_8">
                                    When will sign ups open?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_8">
                            <div class="panel-body">
                                <p>Sign ups for player accounts and the first cycle will open on March 9th. After that, each cycle sign up will open 6-7 days prior to the first day of that cycle.</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_9">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_9" aria-expanded="false" aria-controls="faq_9">
                                    How much does it cost?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_9">
                            <div class="panel-body">
                                <p>Subs - $10/week</p>
                                <p>Sign up for 2 weeks - $18</p>
                                <p>Sign up for 3 weeks - $21</p>
                                <p>Sign up for 4 weeks - $24</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_10">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_10" aria-expanded="false" aria-controls="faq_10">
                                    How do I make a payment?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_10">
                            <div class="panel-body">
                                <p>We will be accepting Paypal, Chase Quickpay, Square Cash, Check or cash. More details to follow soon.</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_11">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_11" aria-expanded="false" aria-controls="faq_11">
                                    Why are you charging money?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_11">
                            <div class="panel-body">
                                <p>Most of the funds go towards securing fields at the Houston Sports Park which is the premier sports park in Houston with professional sports field maintenance and their field rental prices reflect that. The remaining funds go towards administrative costs.</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_12">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_12" aria-expanded="false" aria-controls="faq_12">
                                    What are the team captain's duties?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_12">
                            <div class="panel-body">
                                <p>Each team will have a team captain(s) who will lead the team in developing the team offense and defense (i.e., teams will call offensive plays, call defenses with a marking direction, work on zones, crumbles, and any other strategic points of interest of the team). They will also be involved in balancing the teams for the respective cycle and will also serve as a liaison between the admins and the players; helping take attendance and collecting dues.</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_13">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_13" aria-expanded="false" aria-controls="faq_13">
                                    What are the benefits of being a team captain?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_13" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_13">
                            <div class="panel-body">
                                <p>You get help split up the teams. You will have influence over what the team will be working on that current cycle. And you get a 25% discount on the respective cycle fee.</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_14">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_14" aria-expanded="false" aria-controls="faq_14">
                                    How do I sign up as a team captain?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_14">
                            <div class="panel-body">
                                <p>Captains must be able to play at least 3 of the 4 weeks of the cycle. You can indicate that you are interested in being a captain when signing up for the cycle. We will notify you if we need you to captain before the cycle sign up closes.</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_15">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_15" aria-expanded="false" aria-controls="faq_15">
                                    What does FOCUS stand for?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_15" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_15">
                            <div class="panel-body">
                                <p><strong>F</strong>ostering <strong>O</strong>rganized <strong>C</strong>ompetitive <strong>U</strong>ltimate <strong>S</strong>eries</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading_16">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_16" aria-expanded="false" aria-controls="faq_16">
                                    What is Ultimate?
                                </a>
                            </h4>
                        </div>
                        <div id="faq_16" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_16">
                            <div class="panel-body">
                                <blockquote style="font-size:1em;">
                                    <p>Ultimate, originally known as ultimate frisbee, is a non-contact team field sport played with a flying disc. Points are scored by passing the disc to a teammate in the opposing end zone. Other basic rules are that players must not take steps while holding the disc, and interceptions, incomplete passes, and passes out of bounds are turnovers. Rain, wind, or occasionally other adversities can make for a testing match with rapid turnovers, heightening the pressure of play.</p>
                                    <footer><a href="https://en.wikipedia.org/wiki/Ultimate_(sport)">Wikipedia <cite title="Ultimate (sport)">Ultimate (sport)</cite></a></footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop