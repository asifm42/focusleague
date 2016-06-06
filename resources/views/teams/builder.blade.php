@extends('layouts.default')
@section('title','FOCUS League – Team Builder')

@section('styles')

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.css">
    <style>
        .panel-body {
            padding:0;
        }

        .table {
            margin-bottom:0;
        }
    /*
        .menu-btn {
            position:fixed;
            right:15px;
            bottom:15px;
            z-index: 1000;
        }

        .affix-top,.affix{
            position: static;
        }

        "@"media (min-width: 979px) {
          #sidebar.affix-top {
            position: static;
            width:228px;
          }

          #sidebar.affix {
            position: fixed;
            top:30px;
            width:228px;
          }
        }

        #sidebar li.active {
            border:0 #eee solid;
            border-right-width:4px;
        }
*/
    </style>
@stop

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h4 class="hidden-md hidden-lg">Cycle {{ $cycle->name }} Team Builder</h4>
                    <h3 class="hidden-xs hidden-sm">Cycle {{ $cycle->name }} Team Builder</h3>
                    <p>Create and add/remove players to teams</p>
                </div>
            </div>
        </div>
    </div>
<div id="app">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-3">

                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">Teams</li>
                @foreach($cycle->teams as $team)
                    <li class = "list-group-item">{{ $team->name }} - {{ $team->division }} - <a href={{ route('teams.edit', $team->id) }}>Edit</a></li>
                @endforeach
                    <li class = "list-group-item"> <a href={{ route('teams.create') }}>Add Team</a></li>
                </ul>

                @if (!$cycle->teams_published)
                    <a href="{{ route('cycle.teams.publish', $cycle->id) }}" class="btn btn-default btn-lg btn-block">Publish teams</a>
                @else
                    <button type="button" class="btn btn-default btn-lg btn-block" data-toggle="modal" data-target="#announceTeamsModal">
                        Email Team Announcement
                    </button>
                    <a href="{{ route('cycle.teams.unpublish', $cycle->id) }}" class="btn btn-default btn-lg btn-block">Unpublish teams</a>
                @endif
            </div>
            <div class="col-xs-12 col-md-6">
                <signups title="Male signups"  :signups="signups" gender="male" :cycle="cycle"></signups>
                <signups title="Female signups" :signups="signups" gender="female" :cycle="cycle"></signups>
            </div>
        </div>
        <?php
            $teamCount = 0;
        ?>
        @foreach($cycle->teams as $team)
            <?php
                $teamCount++;
            ?>
            @if ($teamCount === 1 || ($teamCount % 2) !== 0)
                <div class="row">
            @endif

            <div class="col-xs-12 col-md-6">
                <team title={{ $team->name }} team-id={{ $team->id }} division={{ $team->division }} :signups="signups"  :cycle="cycle"></team>
            </div>

            @if (($teamCount % 2) === 0 || ($teamCount) === $cycle->teams->count())
                </div>
            @endif
        @endforeach

    </div>

    <template id="signups-template">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">@{{ title }}<span class="badge pull-right">@{{ count }}</span></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped">
                        <tbody>
                        <tr class="text-center">
                            <th>Name</th>
                            <th class="text-center">Div1</th>
                            <th class="text-center">Div2</th>

                            @foreach($cycle->weeks as $key=>$week)
                                <th class="text-center">Wk{{ $key+1 }}</th>
                            @endforeach

                            <th class="text-center"><i class="fa fa-star"></i></th>

                            <th></th>
                        </tr>
                        </tbody>
                        <tbody v-for="signup in notOnATeam">
                            <tr is="signup" :signup="signup" :cycle="cycle"></tr>
                        </tbody>
                        <tbody>
                        <tr class="info">
                            <th class="text-center" colspan=3>Total</th>
                            <th class="text-center" v-for="count in weekCounts" Use track-by="$index">@{{count}}</th>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </template>
    <template id="signup-template">
        <td style="padding-left:5px">
            <a title="@{{ signup.name }}" href="users/@{{ signup.id }}">@{{ signup.name }}</a>
            <span v-if="signup.pivot.captain"><i class="fa fa-star text-warning"></i></span>
            <span v-if="signup.pivot.note"><i class="fa fa-sticky-note text-warning"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        data-container="body"
                        data-trigger="focus click hover"
                        data-html="true"
                        data-title="@{{ signup.pivot.note }}"></i>
            </span>
        </td>
        <td class="text-center">
            <span v-if="signup.pivot.div_pref_first.toLowerCase() === 'mens'">
                <i class="fa fa-male fa-fw text-primary"></i>
            </span>
            <span v-if="signup.pivot.div_pref_first.toLowerCase() === 'mixed'">
                <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
            </span>
            <span v-if="signup.pivot.div_pref_first.toLowerCase() === 'womens'">
                <i class="fa fa-female fa-fw text-info"></i>
            </span>
        </td>
        <td class="text-center">
            <span v-if="signup.pivot.div_pref_second.toLowerCase() === 'mens'">
                <i class="fa fa-male fa-fw text-primary"></i>
            </span>
            <span v-if="signup.pivot.div_pref_second.toLowerCase() === 'mixed'">
                <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
            </span>
            <span v-if="signup.pivot.div_pref_second.toLowerCase() === 'womens'">
                <i class="fa fa-female fa-fw text-info"></i>
            </span>
        </td>

        <td class="text-center" v-for="week in cycle.weeks"><i class=@{{availabilityIconClass(week)}}></i></td>

        <td class="text-center" @click="toggleCaptain">
            <i class="fa fa-thumbs-up fa-fw text-primary" v-if="signup.pivot.will_captain"></i>
            <i class="fa fa-thumbs-down text-default" v-else></i>
        </td>

        <td class="text-center" {{--@click="addToTeam"--}}>
            <select name="addTeam" class="form-control" v-model="selected" v-on:change="addToTeam($event)">
                <option value disabled selected>Team</option>
                <option v-for="option in teamOptions" :value="option.value" :disabled="option.disabled" :selected="option.selected">
                    @{{ option.text }}
                </option>
            </select>
        </td>
    </template>
     <template id="team-template">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    @{{ title }}
                    <span v-if="division.toLowerCase() === 'mens'">
                        <i class="fa fa-male fa-fw text-primary"></i>
                    </span>
                    <span v-if="division.toLowerCase() === 'mixed'">
                        <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
                    </span>
                    <span v-if="division.toLowerCase() === 'womens'">
                        <i class="fa fa-female text-info"></i>
                    </span>
                    <span class="badge pull-right">@{{ count }}</span>
                </h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped">
                        <tbody>
                        <tr class="text-center">
                            <th>Name</th>
                            <th class="text-center">Div1</th>
                            <th class="text-center">Div2</th>

                            @foreach($cycle->weeks as $key=>$week)
                                <th class="text-center">Wk{{ $key+1 }}</th>
                            @endforeach

                            <th class="text-center"><i class="fa fa-star"></i></th>

                            <th></th>
                        </tr>
                        </tbody>
                        <tbody v-for="signup in players" v-if="division.toLowerCase() !== 'womens'">
                            <tr is="signup" :signup="signup" :cycle="cycle" v-if="signup.gender.toLowerCase() === 'male'"></tr>
                        </tbody>
                        <tr class="warning" v-if="division.toLowerCase() === 'mixed'">
                            <th colspan="5">Females</th>
                        </tr>
                        <tbody v-for="signup in players" v-if="division.toLowerCase() !== 'mens'">
                            <tr is="signup" :signup="signup" :cycle="cycle" v-if="signup.gender.toLowerCase() === 'female'"></tr>
                        </tbody>
                        <tbody>
                        <tr class="info">
                            <th class="text-center" colspan=3>Total</th>
                            <th class="text-center" v-for="count in weekCounts" Use track-by="$index">@{{count}}</th>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </template>
</div>
@stop

@section('scripts')
    @if (app()->environment('production'))
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.24/vue.min.js"></script>
    @else
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.24/vue.js"></script>
    @endif
<script>
    var FOCUS = window.FOCUS || {};

    _.extend( FOCUS, {
        env: '{{ App::environment() }}',
        cycle: {!! $cycle->toJson() !!}
    } );


</script>
    @if (app()->environment('production'))
        <script src="{{ url('assets/js/teamBuilder.min.js') }}"></script>
    @else
        <script src="{{ url('assets/js/teamBuilder.js') }}"></script>
    @endif
    <script>
        $('document').ready(function() {
            // $('#sideNav li a').click(function() {
            //     $('#sideNav').offcanvas('toggle');
            //     $('#sideNav li').removeClass('active')
            //     $(this).parent().addClass('active');
            // })
            // $('#sidebar li a').click(function() {
            //     $('#sidebar li').removeClass('active')
            //     $(this).parent().addClass('active');
            // })

            // $('#sidebar').affix({
            //       offset: {
            //         top: 245
            //       }
            // });

            // var $body   = $(document.body);
            // var navHeight = $('.navbar').outerHeight(true) + 10;

            // $body.scrollspy({
            //     target: '#leftCol',
            //     offset: navHeight
            // });

// template:'<div class="list-group popover"><a class="list-group-item"><a href="#">Action</a></li><li><a href="#">Another action</a></li><li class="list-group-item"><a href="#">Something else here</a></li></ul>',
// <div class="list-group popover"><a class="list-group-item" href="#">Action</a><a class="list-group-item" href="#">Something else here</a></div>
//

            $('[data-toggle="tooltip"]').tooltip();

            $('body').popover({
                selector: '[data-toggle="popover"]',
                template:'<div class="popover"><div class="btn-group popover-content" role="group" aria-label="team-selection"></div><div class="arrow"></div></div>',
                html:true,
                trigger: 'focus'
            });
        });
    </script>
@stop

@section('modals')
<div class="modal fade" id="announceTeamsModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="announceTeamsModalLabel">Email Team Announcement</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure that you are ready to announce teams via email?</p>
      </div>
      <div class="modal-footer">
        <a href="{{ route('cycle.teams.announce', $cycle->id) }}" class="btn btn-primary ">Email Team Announcement</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop