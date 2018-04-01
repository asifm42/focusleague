<template>
<tr>
    <td class="pl-3 align-middle"><!-- style="padding-left:5px"> -->
        <a title="signup.name" href="/users/signup.id">{{ nicknameOrShortName }}</a>
        <span v-if="signup.pivot.captain"><i class="fa fa-star text-warning"></i></span>
        <span v-if="signup.pivot.note"><i class="fa fa-sticky-note text-warning"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    data-container="body"
                    data-trigger="focus click hover"
                    data-html="true"
                    data-title="signup.pivot.note"></i>
        </span>
    </td>

    <td class="text-center align-middle">
        <span v-html="teamDivisionIcon(signup.pivot.div_pref_first)"></span>
    </td>
    <td class="text-center align-middle">
        <span v-html="teamDivisionIcon(signup.pivot.div_pref_second)"></span>
    </td>

    <td class="text-center align-middle" v-for="week in cycle.weeks"><i :class="availabilityIconClass(week)"></i></td>


    <td class="text-center align-middle" @click="toggleCaptain">
        <i class="fa fa-thumbs-up fa-fw text-primary" v-if="signup.pivot.will_captain"></i>
        <i class="fa fa-thumbs-down text-default" v-else></i>
    </td>

    <td class="text-center align-middle">
    <!--     <select name="teamSelect" class="form-control form-control-sm" v-model="selected" v-on:change="teamSelectChange($event)">
            <option disabled value>Team</option>
            <option v-for="option in teamOptions" :value="option.value" :key="option.value">
                {{ option.text }}
            </option>
        </select> -->

        <div class="dropdown">
            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-users"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <h6 class="dropdown-header">Move to</h6>
                <a class="dropdown-item" v-for="option in teamOptions" :value="option.value" href="#" v-if="signup.pivot.team_id !== parseInt(option.value)" @click.prevent="addToTeam(parseInt(option.value))">
                    {{ option.text }}
                </a>
                <div class="dropdown-divider" v-if="onATeam"></div>
                <a class="dropdown-item" value="0" href="#" v-if="onATeam" @click.prevent="removeFromTeam">Back To Signups</a>
            </div>
        </div>
    </td>
</tr>
</template>


<script>
    export default {

    props: [
        'cycle', 'signup'
    ],
    // data: function () {
    //     return {
    //         'selected': 0
    //     }
    // },
    computed: {
        onATeam: function() {
            return this.signup.pivot.team_id !== null;
        },

        // selected: {
        //     get: function () {
        //         return this.signup.pivot.team_id ? this.signup.pivot.team_id : 0;
        //     },
        //     set: function (v) {
        //         ''
        //     }
        // },

        teamOptions: function() {
            var content = [];

            for (let team of this.cycle.teams) {
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
            }

            return content;
        },

        nicknameOrShortName: function () {
            var pieces = [];
            console.log('nickname', this.signup.nickname);
            if (this.signup.nickname) {
                return this.signup.nickname;
            } else if (this.signup.name.split(' ').length > 1) {
                pieces = this.signup.name.split(' ');
                return pieces[0].charAt(0).toUpperCase() + pieces[0].slice(1) + pieces[1].charAt(0).toUpperCase() + pieces[1].slice(1,3);
            } else {
                return this.signup.name;
            }
        }
    },

    methods: {
        // teamSelectChange: function(event) {
        //     console.log('user selected a team', this, event);

        //     if (event.target.type === 'select-one') {
        //         var teamId = parseInt(event.target.value);
        //         if (teamId === 0) {
        //             // remove from team
        //             return this.removeFromTeam();
        //         }
        //         if (teamId > 0) {
        //             return this.addToTeam(teamId)
        //         }
        //     }
        // },
        addToTeam: function(teamId) {
            console.log('adding to team', this, teamId);

            this.signup.pivot.team_id = teamId;
            this.updateTeamOnServer(this.signup);
        },
        removeFromTeam: function() {
            console.log('removing from team', this);

            this.signup.pivot.team_id = null;
            this.updateTeamOnServer(this.signup);
        },
        toggleCaptain: function(event) {
            console.log('clicked toggleCaptain', this, event);

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
            if (signup.pivot.team_id == null) {
                axios.delete('/api/cyclesignups/' + signup.pivot.id + '/team')
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
            } else {
                axios.put('/api/cyclesignups/' + signup.pivot.id + '/team', {
                    'team_id': signup.pivot.team_id
                })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
            }
        },

        updateCaptainOnServer: function(signup) {
            axios.put('/api/cyclesignups/' + signup.pivot.id, {
                'captain': signup.pivot.captain
            })
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.log(error);
            });
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


        mounted() {
            console.log('Component mounted.')
        }
    }
</script>