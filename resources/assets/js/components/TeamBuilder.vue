<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <h5>Cycle {{ cycle.name }} Team Builder</h5>
                <p>Create and add/remove players to teams</p>
            </div>
        </div>


       <div class="row">
            <div class="col col-sm-3">

                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">Teams</li>
                    <li class="list-group-item" v-for="team in cycle.teams" :key="team.id">
                        {{ team.name }}
                        <span v-html="teamDivisionIcon(team.division)"></span>
                        <a class="float-right" :href="'/teams/' + team.id + '/edit'">Edit</a>
                    </li>
                     <li class = "list-group-item"> <a href="/teams/create">Add Team</a></li>
                </ul>

                <button v-if="!cycle.teams_published" type="button" class="btn btn-primary btn-lg btn-block js-publish-teams mt-3" data-toggle="modal" data-target="#publishTeamsModal">
                        Publish Teams
                </button>
                <div v-else>
                <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#announceTeamsModal">
                        Email Team Announcement
                </button>
                <a :href="'/cycles/' + cycle.id + '/teams/unpublish'" class="btn btn-default btn-lg btn-block">Unpublish teams</a>
                    <!-- <a href="{{ route('cycle.teams.unpublish', $cycle->id) }}" class="btn btn-default btn-lg btn-block">Unpublish teams</a> -->
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col col-sm-6">
                <signups-card title="Male signups"  gender="male" :cycle="cycle"
                ></signups-card>
            </div>
            <div class="col col-sm-6">
                 <signups-card title="Female signups"  gender="female" :cycle="cycle"
                ></signups-card>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-sm-6" v-for="team in cycle.teams" :key="team.id" >
                <team-card :team="team" :cycle="cycle"></team-card>
            </div>
        </div>
 <!--
            @php
                $teamCount = 0;
            @endphp
        @foreach($cycle->teams as $team)

            @php
                $teamCount++;
            @endphp

            @if ($teamCount === 1 || ($teamCount % 2) !== 0)
                <div class="row mt-3">
            @endif

            <div class="col-12 col-sm-6">
                <team-card :team="{{ $team->toJson() }}" :signups="{{$cycle->signups->toJson()}}"  :cycle="{{$cycle->toJson()}}"></team-card>
            </div>

            @if (($teamCount % 2) === 0 || ($teamCount) === $cycle->teams->count())
                </div>
            @endif
        @endforeach -->
    </div>
</template>


<script>
    export default {
        props: [
            'cycleid', 'cyclePayload'
        ],
        data() {
            return {
                cycle: this.cyclePayload
            }
        },
        methods: {
            teamDivisionIcon: function(division) {
                division = division.toLowerCase();

                switch (division) {
                    case 'mens':
                        return '<i class="fa fa-male fa-fw text-primary"></i>';
                        break;
                    case 'mixed':
                        return '<i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>';
                        break;
                    case 'womens':
                        return '<i class="fa fa-female fa-fw text-info"></i>';
                        break;
                    default:
                        return;
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>