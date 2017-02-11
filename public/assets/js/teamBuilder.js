var FOCUS = window.FOCUS || {};

Vue.component('signups', {
    template: '#signups-template',

    props: [
        'cycle', 'gender', 'count', 'title',
        'signups', 'notOnATeam', 'weekCounts',
        'gendered'
    ],

    computed: {
        count:  function() {
            return this.notOnATeam.length;
        },

        notOnATeam: function() {
            var filtered = this.signups;
            if (this.gender !== undefined) {
                filtered = _.filter(this.signups, function(signup){
                    if (signup.gender.toLowerCase() === this.gender) {
                        return signup.pivot.team_id === null;
                    }
                }, this);
            }
            return filtered;
        },

        gendered: function() {
            var filtered = this.signups;
            if (this.gender !== undefined) {
                filtered = _.filter(this.signups, function(signup){
                    return signup.gender.toLowerCase() === this.gender;
                }, this);
            }
            return filtered;
        },

        weekCounts: function() {
            var arr = [];
            for (var i=0, len=this.cycle.weeks.length; i < len; i++) {
                var weekId = this.cycle.weeks[i].id;
                var count = 0;
                _.each(this.notOnATeam, function(signup) {
                    if (this.isAvailable(signup, weekId)) {
                        count++;
                    }
                }, this);

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
            var player = _.findWhere(this.signups, {id:signupId});
            player.pivot.team_id = teamId;
        }
    },

    created: function() {
    }
});


Vue.component('signup', {
    template: '#signup-template',

    props: ['signup', 'cycle', 'onATeam', 'teamOptions', 'selected'],

    // data: function() {
    //     return {
    //         selected:"0"
    //     };
    // },

    computed: {
        onATeam: function() {
            return this.signup.pivot.team_id !== null;
        },

        selected: function() {
            return this.signup.pivot.team_id ? this.signup.pivot.team_id : 0;
        },

        teamOptions: function() {
            var content = [];
            // content.push({ text: 'Team', value: 0, disabled: 'disabled', selected: 'selected'});
            // var content = '<option value disabled="disabled" selected="selected">Team</option>';
            _.each(this.cycle.teams, function(team) {
                var data = {};
                data.text = team.name;
                data.value = team.id;
                if (this.signup.gender.toLowerCase() == 'male' &&
                    (team.division.toLowerCase() == 'mixed' || team.division.toLowerCase() == 'mens')) {
                    content.push(data);
                }
                if (this.signup.gender.toLowerCase() === 'female' &&
                    (team.division.toLowerCase() == 'mixed' || team.division.toLowerCase() == 'womens')) {
                    content.push(data);
                }
                // content.push({ text: team.name, value: team.id});
                // content+= '<option value='+team.id+'>' + team.name + '</option>';
            }, this);
            return content;
        }
    },

    methods: {
        addToTeam: function(event) {
            console.log('clicked add to team', this, event);

            if (event.target.type === 'select-one') {
                this.signup.pivot.team_id = event.target.value;
                // this.$dispatch('signupAddedToATeam', this.signup.id, event.target.value);
                this.updateTeamOnServer(this.signup);
            }
        },

        toggleCaptain: function(event) {
            console.log('clicked toggleCaptain', this, event);

            // if (this.signup.pivot.captain == 0) {
            //     this.signup.pivot.captain = 1;
            //     console.log('was not captain', this.signup.pivot);
            // }

            // if (this.signup.pivot.captain == 1) {
            //     this.signup.pivot.captain = 0;
            //     console.log('was captain', this.signup.pivot);
            // }
            //
            this.signup.pivot.captain = ! this.signup.pivot.captain;

            this.updateCaptainOnServer(this.signup);
        },

        availabilityIconClass: function(week) {
            var availability = _.find(this.signup.availability, function(signupWeek){
                 return signupWeek.id == week.id;
            });

            if (availability.pivot.attending == 1) {
                return 'fa fa-check fa-fw text-success';
            }
            return 'fa fa-times fa-fw text-danger';
        },

        updateTeamOnServer: function(signup) {
            $.ajax({
                type: "PUT",
                url: '../../api/cyclesignups/' + signup.pivot.id,
                contentType: "application/json",
                data: JSON.stringify({"team_id": signup.pivot.team_id})
            });
        },

        updateCaptainOnServer: function(signup) {
            $.ajax({
                type: "PUT",
                url: '../../api/cyclesignups/' + signup.pivot.id,
                contentType: "application/json",
                data: JSON.stringify({"captain": signup.pivot.captain})
            });
        }
    },

    created: function() {
        // var arr = $.map(JSON.parse(this.list), function(el) { if (el.) return el; });

        // this.list = JSON.stringify(arr);
        // this.list = JSON.parse(this.list);
    }
});

Vue.component('team', {
    template: '#team-template',

    props: [
        'cycle', 'gender', 'count',
        'notOnATeam', 'weekCounts',
        'title', 'teamId', 'signups',
        'division'
    ],

    computed: {
        players: function() {
            var filtered = _.filter(this.signups, function(signup){
                    return signup.pivot.team_id == this.teamId;
                }, this);
            return filtered;
        },

        // title: function() {
        //     return 'team name';
        // },

        count: function() {
            return this.players.length;
        },

        // gendered: function() {
        //     var filtered = this.signups;
        //     if (this.gender !== undefined) {
        //         filtered = _.filter(this.signups, function(signup){
        //             return signup.gender.toLowerCase() === this.gender;
        //         }, this);
        //     }
        //     return filtered;
        // },

        weekCounts: function() {
            var arr = [];
            for (var i=0, len=this.cycle.weeks.length; i < len; i++) {
                var weekId = this.cycle.weeks[i].id;
                var count = 0;
                _.each(this.players, function(signup) {
                    if (this.isAvailable(signup, weekId)) {
                        count++;
                    }
                }, this);

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
            }, this);
            // debugger;
            if (week.pivot.attending == 1) {
                return true;
            }

            return false;
        }
    },

    // events: {
    //     teamPlacement: function(signupId, teamId) {
    //         var player = _.findWhere(this.signups, {id:signupId});
    //         player.pivot.team_id = teamId;
    //     }
    // },

    // created: function() {
    //     console.log(this.teamId);
    //     $.getJSON('../../api/teams/' + this.teamId, function(team) {
    //         console.log(team.players);
    //         this.list = team.players;
    //     }.bind(this));
    // }
});

var data = {
    cycle: FOCUS.cycle,
    signups: FOCUS.cycle.signups
    };

new Vue({
    el: '#app',

    data: data,

    events: {
        signupAddedToATeam: function(signupId, teamId) {
            var player = _.findWhere(this.signups, {id:signupId});
            player.pivot.team_id = teamId;
            // this.$broadcast('teamPlacement', signupId, teamId);
            $.ajax({
                type: "PUT",
                url: '../../api/cyclesignups/' + player.pivot.id,
                contentType: "application/json",
                data: JSON.stringify({"team_id": teamId})
            });
        },
        toggleSignupCaptain: function(signupId) {
            var player = _.findWhere(this.signups, {id:signupId});
            player.pivot.captain = captain;
            // this.$broadcast('toggleCaptain', signupId, captain);
            $.ajax({
                type: "PUT",
                url: '../../api/cyclesignups/' + player.pivot.id,
                contentType: "application/json",
                data: JSON.stringify({"captain": 1})
            });
        }
    }
});
