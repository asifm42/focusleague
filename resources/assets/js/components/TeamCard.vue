<template>
    <div class="card">
        <div class="card-header">
                <span class="badge float-right">{{ count }}</span>
                {{ team.name }}
                <span v-html="teamDivisionIcon(team.division)"></span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-striped mb-0">
                    <tbody>
                    <tr class="text-center">
                        <th>Name</th>
                        <th class="text-center">Div1</th>
                        <th class="text-center">Div2</th>
                        <th class="text-center" v-for="(week, key) in cycle.weeks" :key="week.id">Wk{{ key+1 }}</th>
                        <th class="text-center"><i class="fa fa-star"></i></th>
                        <th></th>
                    </tr>
                    </tbody>
                     <tbody v-for="signup in players" v-if="team.division.toLowerCase() !== 'womens'">
                        <tr is="signup" :signup="signup" :cycle="cycle" v-if="signup.gender.toLowerCase() === 'male'"></tr>
                    </tbody>
                    <tr class="warning" v-if="team.division.toLowerCase() === 'mixed'">
                        <th colspan="5">Females</th>
                    </tr>
                    <tbody v-for="signup in players" v-if="team.division.toLowerCase() !== 'mens'">
                        <tr is="signup" :signup="signup" :cycle="cycle" v-if="signup.gender.toLowerCase() === 'female'"></tr>
                    </tbody>
                    <tbody>
                    <tr class="info">
                        <th class="text-center" colspan=3>Total</th>
                        <th class="text-center" v-for="count, key in weekCounts" :key='key'>{{count}}</th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'cycle', 'team'
        ],

        computed: {
            players: function() {

                return this.cycle.signups.filter(signup => {
                    return signup.pivot.team_id == this.team.id
                });
            },

            count: function() {
                return this.players.length;
            },

            weekCounts: function() {
                var arr = [];
                for (var i=0, len=this.cycle.weeks.length; i < len; i++) {
                    var weekId = this.cycle.weeks[i].id;
                    var count = 0;
                    for (let player of this.players) {
                        if (this.isAvailable(player, weekId)) {
                            count++;
                        }
                    }

                    arr.push(count);
                }

                return arr;
            },
        },

        methods: {
            isAvailable: function(signup, weekId) {
                var wkId = weekId;
                var week = _.find(signup.availability, function(week) {
                    return week.id == wkId;
                });
                // debugger;
                if (week.pivot.attending == 1) {
                    return true;
                }

                return false;
            },
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

        // events: {
        //     teamPlacement: function(signupId, teamId) {
        //         var player = _.findWhere(this.signups, {id:signupId});
        //         player.pivot.team_id = teamId;
        //     }
        // },

        created: function() {
            console.log('teamname', this.teamName);
            // $.getJSON('../../api/teams/' + this.teamId, function(team) {
            //     console.log(team.players);
            //     this.list = team.players;
            // }.bind(this));
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>