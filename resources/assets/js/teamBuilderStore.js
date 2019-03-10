var store = {
  debug: true,
  state: {
    cycle: ''
  },
  addToTeam (team, signupId) {
    if (this.debug) console.log('addToTeam triggered', team, signupId);
    signup = this.cycle.signups.find(signup => signup.id == signupId);
    signup.pivot.team_id = team.id;
  }
}

export default new Store;