<template>
    <div class="card">
        <div class="card-header">{{ title }}<span class="badge float-right">{{ count }}</span></div>

        <div class="card-body p-0">
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
                <tbody>
                    <tr is="signup" v-for="signup in notOnATeam" :cycle="cycle" :signup="signup" :key="signup.id"></tr>
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
</template>



    <!-- <template id="signups-template">
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
    </template> -->
















<script>
    export default {

    props: [
        'cycle', 'gender', 'title'
    ],

    computed: {
        count:  function() {
            return this.notOnATeam.length;
        },

        notOnATeam: function() {
            if (this.cycle == '') return [];
            if (this.gender !== undefined) {
                return this.cycle.signups.filter(signup => {
                    return signup.gender.toLowerCase() === this.gender && signup.pivot.team_id === null;
                })
            } else {
                return this.cycle.signups;
            }
        },

        weekCounts: function() {
            var arr = [];
            if (this.cycle == '') return [];
            for (var i=0, len=this.cycle.weeks.length; i < len; i++) {
                var weekId = this.cycle.weeks[i].id;
                var count = 0;
                for (let signup of this.notOnATeam) {
                    if (this.isAvailable(signup, weekId)) {
                        count++;
                    }
                }

                arr.push(count);
            }

            return arr;
        },
    },

    methods: {
        addToTeam: function (payload) {
            this.$emit('addToTeam', payload);
        },
        isAvailable: function(signup, weekId) {
            var wkId = weekId;
            var week = _.find(signup.availability, function(week) {
                return week.id == wkId;
            }, this);
            // debugger;
            if (week.pivot.attending == 1) {
                return true;
            }

            return false;
        }
    },

    events: {
        teamPlacement: function(signupId, teamId) {
            // var player = _.findWhere(this.signups, {id:signupId});
            // player.pivot.team_id = teamId;
        }
    },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
      transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
      opacity: 0;
    }

    time.icon.icon-sm {
        font-size:0.6em;
    }
</style>