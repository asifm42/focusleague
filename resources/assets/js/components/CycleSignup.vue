<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <transition name="fade" mode="out-in">
                    <div class="jumbotron" v-if="show == 'intro'" key="intro">
                        <h4>Great to have you, {{ user.nickname }}!</h4>
                        <p>We just need some information to sign you up for Cycle {{ cycle.name }}.</p>

                        <button class="btn btn-primary btn-block" v-on:click="clickContinue">Let's get started!</button>
                    </div>
                    <div v-if="show == 'div_pref'" key="div_pref">
                    <div class="card" >
                        <div class="card-body">
                            <h4 class="text-center">Division Preference</h4>
                            <div class="row">
                                <div class="col">
                                    <div class="w-100 m-1">
                                        <div class="card text-center w-100" :class="{'bg-success':div_pref('genderOnly')}" data-div_pref="genderOnly" @click="clickPref">
                                            <div class="card-body">
                                                <p class="card-text" :class="{'text-white':div_pref('genderOnly')}">
                                                    {{ user.gender == 'Male' ? 'Mens' : 'Womens' }} only
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="w-100 m-1">
                                        <div class="card text-center w-100" :class="{'bg-success':div_pref('mixedOnly')}" data-div_pref="mixedOnly" @click="clickPref">
                                            <div class="card-body">
                                                <p class="card-text" :class="{'text-white':div_pref('mixedOnly')}">
                                                    Mixed only
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100 m-1"></div>
                                <div class="col">
                                    <div class="w-100 m-1">
                                        <div class="card text-center w-100" :class="{'bg-success':div_pref('genderFlexible')}" data-div_pref="genderFlexible" @click="clickPref">
                                            <div class="card-body">
                                                <p class="card-text" :class="{'text-white':div_pref('genderFlexible')}">
                                                    Prefer {{ user.gender == 'Male' ? 'Mens' : 'Womens' }}<br />Will play Mixed
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="w-100 m-1">
                                        <div class="card text-center w-100" :class="{'bg-success':div_pref('mixedFlexible')}" data-div_pref="mixedFlexible" @click="clickPref">
                                            <div class="card-body">
                                                <p class="card-text" :class="{'text-white':div_pref('mixedFlexible')}">
                                                    Prefer Mixed<br />Will play {{ user.gender == 'Male' ? 'Mens' : 'Womens' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <button class="btn btn-secondary btn-block" v-on:click="clickBack"><i class="fa fa-long-arrow-left fa-fw" aria-hidden="true"></i> Back</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary btn-block" v-on:click="clickContinue">Next <i class="fa fa-long-arrow-right fa-fw" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="row mt-3" v-if="editMode">
                        <div class="col">
                            <button class="btn btn-warning btn-block" v-on:click="clickBackToConfirm">Back to Confirm</button>
                        </div>
                    </div>
                </div>
                <div v-if="show == 'availability'" key="availability">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <h4 class="text-center mb-5">Which weeks are you available?</h4>

                                <div class="card-deck" style="flex-direction:row;">
                                    <div class="card mx-1 mx-sm-2 text-center" :class="{'bg-success':weekAttending(week.id), 'bg-danger':!weekAttending(week.id)}" @click="clickWeek" v-for="week in cycle.weeks" :key="week.id" :data-week_id="week.id" :fontsize="timeFontSize">
                                        <div class="card-body px-3 px-sm-4 py-2 m-1 m-sm-2">
                                            <div class="row justify-content-center">
                                                <div>
                                                    <time :datetime="datetime(week.starts_at)" class="icon" :class="{'icon-sm':timeFontSize}">
                                                      <em>{{ dayOfWeek(week.starts_at) }}</em>
                                                      <strong>{{ month(week.starts_at) }}</strong>
                                                      <span>{{ dayOfMonth(week.starts_at) }}</span>
                                                    </time>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center mt-1">
                                                <i class="fa fa-fw fa-check-circle text-white" v-if="weekAttending(week.id)"></i>
                                                <i class="fa fa-fw fa-times-circle " v-if="!weekAttending(week.id)"></i>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <button class="btn btn-secondary btn-block" v-on:click="clickBack"><i class="fa fa-long-arrow-left fa-fw" aria-hidden="true"></i> Back</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary btn-block" v-on:click="clickContinue" :disabled="this.numOfWeeksSigningUp == 0 ? true : false">Next <i class="fa fa-long-arrow-right fa-fw" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="row mt-3" v-if="editMode">
                        <div class="col">
                            <button class="btn btn-warning btn-block" v-on:click="clickBackToConfirm">Back to Confirm</button>
                        </div>
                    </div>
                </div>

                <div class="jumbotron" v-if="show == 'sub_message'" key="sub_message">
                    <h4 class="text-center">Sub sign-up</h4>
                    <div class="text-warning" v-html="sub_message">
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <button class="btn btn-primary btn-block" v-on:click="clickContinue">Got it. Let's Continue.</button>
                        </div>
                    </div>
                    <div class="row mt-3" v-if="editMode">
                        <div class="col">
                            <button class="btn btn-warning btn-block" v-on:click="clickBackToConfirm">Back to Confirm</button>
                        </div>
                    </div>
                </div>

                <div v-if="show == 'captain'" key="captain">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center">Captain</h4>
                            <p>Awesome. Since you are available all 3 weeks, you're eligible to captain. Interested?</p>

                            <div role="tab" id="duties_q">
                                <h6>
                                    <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#duties_a" aria-expanded="'false'" aria-controls="duties_a">
                                        What are the team captain's duties?
                                    </a>
                                </h6>
                            </div>
                            <div id="duties_a" class="collapse" role="tabpanel" aria-labelledby="duties_q">
                                <div>
                                   <p>Each team will have a team captain(s) who will lead the team in developing the team offense and defense (i.e., teams will call offensive plays, call defenses with a marking direction, work on zones, crumbles, and any other strategic points of interest of the team). They will also be involved in balancing the teams for the respective cycle and will also serve as a liaison between the admins and the players; helping take attendance and collecting dues.</p>
                                </div>
                            </div>

                            <div role="tab" id="benifits_q">
                                <h6>
                                    <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#benifits_a" aria-expanded="'false'" aria-controls="benifits_a">
                                        What are the benefits of being a team captain?
                                    </a>
                                </h6>
                            </div>
                            <div id="benifits_a" class="collapse" role="tabpanel" aria-labelledby="benifits_q">
                                <div>
                                   <p>A chance to practice your team captain and leadership skills. You get to help split up the teams. You will have influence over what the team will be working on that current cycle. And you get a 25% discount on the respective cycle fee.</p>
                                </div>
                            </div>

                            <div class="card-deck">
                                <div class="card text-center" :class="{'bg-success':will_captain}" data-answer="true" @click="clickCaptain">
                                    <div class="card-body">
                                        <p class="card-text" :class="{'text-white':will_captain}">Yeah, I'll Captain!</p>
                                    </div>
                                </div>
                                <div class="card text-center" :class="{'bg-danger':will_captain == false}" data-answer="false" @click="clickCaptain">
                                    <div class="card-body">
                                        <p class="card-text" :class="{'text-white':will_captain == false}">Nah, just play.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <button class="btn btn-secondary btn-block" v-on:click="clickBack"><i class="fa fa-long-arrow-left fa-fw" aria-hidden="true"></i> Back</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary btn-block" v-on:click="clickContinue" :disabled="this.will_captain == null ? true : false">Next <i class="fa fa-long-arrow-right fa-fw" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="row mt-3" v-if="editMode">
                        <div class="col">
                            <button class="btn btn-warning btn-block" v-on:click="clickBackToConfirm">Back to Confirm</button>
                        </div>
                    </div>
                </div>

                <div v-if="show == 'payment'" key="payment">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center">Payment Method</h4>
                            <p class="card-text">Once you are placed on a team, your account will be charged ${{ fees }}.</p>

                            <div class="form-group">
                                <label for="payment_type" class="required">How do you plan to pay?</label>
                                <select name="payment_type" class="form-control" id="payment_type" aria-describedby="payment_typeHelp" placeholder='Required payment type' v-model="payment_method" required>
                                        <option disabled value="" selected>Choose method</option>
                                        <option value="chase_quickpay">Chase Quickpay</option>
                                        <option value="venmo">Venmo</option>
                                        <option value="square_cash">Square Cash</option>
                                        <option value="paypal">Paypal</option>
                                        <option value="check">Check</option>
                                        <option value="cash">Cash</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <button class="btn btn-secondary btn-block" v-on:click="clickBack"><i class="fa fa-long-arrow-left fa-fw" aria-hidden="true"></i> Back</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary btn-block" v-on:click="clickContinue" :disabled="this.payment_method == '' ? true : false">Next <i class="fa fa-long-arrow-right fa-fw" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="row mt-3" v-if="editMode">
                        <div class="col">
                            <button class="btn btn-warning btn-block" v-on:click="clickBackToConfirm">Back to Confirm</button>
                        </div>
                    </div>
                </div>


                <div class="jumbotron" v-if="show == 'late_message'" key="late_message">
                    <h4 class="text-center">Late Sign-up</h4>
                    <div class="text-danger" v-html="late_message">
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <button class="btn btn-primary btn-block" v-on:click="clickContinue">Got it. Let's Continue.</button>
                        </div>
                    </div>
                    <div class="row mt-3" v-if="editMode">
                        <div class="col">
                            <button class="btn btn-warning btn-block" v-on:click="clickBackToConfirm">Back to Confirm</button>
                        </div>
                    </div>
                </div>

                <div v-if="show == 'note'" key="note">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-center">Anything else you want to tell us?</h6>
                            <div class="form-group">
                              <textarea class="form-control" id="note" rows="6" placeholder="Optional note" @change="noteChange"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <button class="btn btn-secondary btn-block" v-on:click="clickBack"><i class="fa fa-long-arrow-left fa-fw" aria-hidden="true"></i> Back</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary btn-block" v-on:click="clickContinue">Next <i class="fa fa-long-arrow-right fa-fw" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="row mt-3" v-if="editMode">
                        <div class="col">
                            <button class="btn btn-warning btn-block" v-on:click="clickBackToConfirm">Back to Confirm</button>
                        </div>
                    </div>
                </div>
                <div v-if="show == 'confirm'" key="confirm">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-center">Ok {{ user.nickname }}. Did we get everything right?</h5>

                            <dl>
                                <dt class="text-muted">
                                    Division Preference
                                    <button type="button" v-if="this.cycleSignupAllowed && this.cycleSignupOpen" class="align-baseline btn btn-link d-inline btn-sm" @click="clickConfirmEdit" data-show="div_pref">Edit</button>
                                </dt>
                                <dd class="ml-2">
                                    {{ this.division_preference }}
                                </dd>

                                <dt class="text-muted">
                                    Weeks {{ this.subSignup ? 'Subbing' : 'Playing' }}
                                    <button type="button" class="align-baseline btn btn-link d-inline btn-sm" @click="clickConfirmEdit" data-show="availability">Edit</button>
                                </dt>
                                <dd class="ml-2" v-html="this.weeksAttendingList"></dd>

                                <dt class="text-muted" v-if="this.numOfWeeksSigningUp >= 3">
                                    Willing to captain?
                                    <button type="button" v-if="this.cycleSignupAllowed && this.cycleSignupOpen" class="align-baseline btn btn-link d-inline btn-sm" @click="clickConfirmEdit" data-show="captain">Edit</button>
                                </dt>
                                <dd class="ml-2" v-if="this.numOfWeeksSigningUp >= 3">
                                    {{ this.will_captain ? "Yes. (Thank You! We'll let you know.)" : "No" }}
                                </dd>

                                <dt class="text-muted">
                                    Payment Method
                                    <button type="button" class="align-baseline btn btn-link d-inline btn-sm" @click="clickConfirmEdit" data-show="payment">Edit</button>
                                </dt>
                                <dd class="ml-2" v-html="this.paymentConfirmation"></dd>

                                <dt class="text-muted">
                                    Note
                                    <button type="button" class="align-baseline btn btn-link d-inline btn-sm" @click="clickConfirmEdit" data-show="note">Edit</button>
                                </dt>
                                <dd class="ml-2" v-if="this.note != null" v-html="this.note"></dd>
                                <dd class="ml-2 text-muted font-italic" v-else>no note</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <button v-if="status == 'creating'" class="btn btn-success btn-block" v-on:click="clickFinish">Yup, sign me up!</button>
                            <button v-if="status == 'sending'" class="btn btn-success btn-block" disabled>Working <i class="fa fa-spinner fa-spin fa-fw"></i></button>
                            <button v-if="status == 'updating'" class="btn btn-success btn-block" v-on:click="clickFinish">Yup, save it!</button>
                        </div>
                    </div>
                </div>

                    <div class="jumbotron" v-if="show == 'success'" key="success">
                        <h5>You're all signed up, {{ user.nickname }}.</h5>
                        <h5>See you at the fields!</h5>
                        <div class="row mt-3">
                            <div class="col-6">
                                <button class="btn btn-secondary btn-block" v-on:click="clickDashboard">Dashboard</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-primary btn-block" v-on:click="clickCycleDetails">Cycle Details</button>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import _ from 'lodash';

    export default {
        props: ['user', 'cycle'],
        data: function () {
            return {
                'show': 'intro',
                'editMode': null,
                'weeksAttending': [],
                'subSignup': false,
                'division_preference_first': '',
                'division_preference_second': '',
                'payment_method': "",
                'will_captain': null,
                'note': null,
                'status': 'creating'
            }
        },
        methods: {
            buildPayload: function() {
                let payload = {};
                if (this.subSignup == false) {
                    payload['div_pref_first'] = this.division_preference_first;

                    payload['div_pref_second'] = this.division_preference_second;

                    payload['will_captain'] = this.captainPayload();

                    payload['weeks'] = this.weekPayload();

                    payload['payment_method'] = this.payment_method;

                } else {
                    payload['weeks'] = _.map(_.filter(this.weekPayload(), function(week) {return week.attending}), 'id');
                }

                payload['note'] = this.note;

                return payload;
            },
            weekPayload: function() {
                let weeks = [];

                for(var i=0, len = this.cycle.weeks.length; i<len; i++) {
                    weeks.push({
                        'id': this.cycle.weeks[i].id,
                        'attending': this.weekAttending(this.cycle.weeks[i].id)
                    });
                }

                return weeks;
            },
            captainPayload: function() {
                if (this.will_captain && this.numOfWeeksSigningUp >= 3) {
                    return true;
                }

                return false;
            },
            clickConfirmEdit: function (event) {
                this.editMode = true;
                // this.back = 'confirm';
                this.show = this.back = event.currentTarget.dataset.show;

                // if (this.editMode == true) {
                //     if (this.show == 'availability' && this.subSignup) {
                //         this.back = 'availability';
                //         return this.show = 'sub_message'
                //     }

                //     if (this.show == 'availability'
                //         && this.numOfWeeksSigningUp >=3
                //         && this.will_captain == null)
                //     {
                //         this.back = 'availability';
                //         return this.show = 'captain';
                //     }

                //     this.back = this.show;
                //     return this.show = 'confirmation';
                // }


            },
            clickFinish: function() {
                console.log('cycles/' + this.cycle.name + '/signups');
                let url = '/api/cycles/' + this.cycle.name + '/signups';

                if (this.subSignup) {
                    url = '/api/cycles/' + this.cycle.name + '/subs';
                }
                this.status = 'sending';
                axios.post(url, this.buildPayload())
                    .then(response => {
                        console.log(response.data);
                        this.status = 'updating';
                        if (response.data.status == 'success') {
                            this.show = 'success'
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
                return true;
            },
            clickCycleDetails: function() {
                window.location.href = "/cycles/" + this.cycle.name;
                return;
            },
            clickBack: function() {
                if (this.show != this.back) return this.show = this.back;

                if (this.show == 'note') {
                    if (this.signingUpForToday) {
                        if (this.cycleSignupLate
                            || this.cycleSignupSuperLate
                            || this.subSignupSuperLate)
                        this.show = 'late_message';
                        return;
                    }

                    return this.back = this.show = 'payment';
                }

                if (this.show == 'late_message') {
                    return this.back = this.show = 'payment';
                }

                if (this.show == 'payment') {
                    if (this.subSignup) {
                        return this.back = this.show = 'sub_message'
                    }

                    if (this.cycleSignupAllowed
                        && this.cycleSignupOpen
                        && this.numOfWeeksSigningUp >= 3) {
                        return this.back = this.show = 'captain';

                    }

                    return this.back = this.show = 'availability';
                }

                if (this.show == 'sub_message' || this.show == 'captain') {
                    return this.back = this.show = 'availability';
                }

                if (this.show == 'availability') {
                    return this.back = this.show = 'div_pref';
                }

                if (this.show == 'div_pref') {
                    return this.show = 'intro';
                }
            },
            clickBackToConfirm: function() {
                this.back = 'note';
                return this.show = 'confirm';
            },
            clickDashboard: function() {
                window.location.href = "/dashboard/";
                return;
            },
            clickContinue: function() {
                if (this.show == 'intro') {
                    this.back = 'intro';
                    return this.show = 'div_pref'
                }

                if (this.show == 'div_pref') {
                    this.back = 'div_pref';
                    return this.show = 'availability'
                }

                if (this.show == 'availability') {
                    this.back = 'availability';

                    if (this.subSignup) {
                        return this.show = 'sub_message';
                    }

                    if (this.cycleSignupAllowed
                        && this.cycleSignupOpen
                        && this.numOfWeeksSigningUp >= 3) {
                        return this.show = 'captain';
                    }

                    return this.show = 'payment';
                }

                if (this.show == 'sub_message') {
                    this.back = 'sub_message';
                    return this.show = 'payment';
                }

                if (this.show == 'captain') {
                    this.back = 'captain';
                    return this.show = 'payment';
                }

                if (this.show == 'payment') {
                    this.back = 'payment';

                    if (this.signingUpForToday) {
                        if (this.cycleSignupLate
                            || this.cycleSignupSuperLate
                            || this.subSignupSuperLate)
                        return this.show = 'late_message';
                    }

                    return this.show = 'note';
                }

                if (this.show == 'late_message') {
                    this.back = 'late_message';
                    return this.show = 'note';
                }

                if (this.show == 'note') {
                    this.back = 'note';
                    return this.show = 'confirm';
                }
            },
            clickWeek(event) {
                const index = _.indexOf(this.weeksAttending, parseInt(event.currentTarget.dataset.week_id));
                if (index != -1) {
                    this.weeksAttending.splice(index, 1);
                } else {
                    this.weeksAttending.push(parseInt(event.currentTarget.dataset.week_id));
                }

                if (this.weeksAttending.length == 1 || (!this.cycleSignupAllowed && this.subSignupAllowed)) {
                    this.subSignup = true;
                }

                if (this.cycleSignupAllowed && this.weeksAttending.length > 1) {
                    this.subSignup = false;
                }
            },
            clickPref(event) {
                console.log('clickPref', event.currentTarget.dataset.div_pref);
                if (event.currentTarget.dataset.div_pref == 'genderOnly') {
                    if (_.toLower(this.user.gender) == 'male') {
                        this.division_preference_first = 'mens';
                        this.division_preference_second = 'mens';
                        return;
                    } else {
                        this.division_preference_first = 'womens';
                        this.division_preference_second = 'womens';
                        return;
                    }
                } else if (event.currentTarget.dataset.div_pref == 'mixedOnly') {
                    this.division_preference_first = 'mixed';
                    this.division_preference_second = 'mixed';
                    return;
                } else if (event.currentTarget.dataset.div_pref == 'genderFlexible') {
                    if (_.toLower(this.user.gender) == 'male') {
                        this.division_preference_first = 'mens';
                    } else {
                        this.division_preference_first = 'womens';
                    }

                    this.division_preference_second = 'mixed';
                    return;
                } else if (event.currentTarget.dataset.div_pref == 'mixedFlexible') {
                    this.division_preference_first = 'mixed';

                    if (_.toLower(this.user.gender) == 'male') {
                        this.division_preference_second = 'mens';
                    } else {
                        this.division_preference_second = 'womens';
                    }

                    return;
                }
            },
            clickCaptain(event){
                if (event.currentTarget.dataset.answer == 'true') {
                    return this.will_captain = true;
                }
                return this.will_captain = false;
            },
            // selectPaymentMethod(event) {
            //     console.log('selectPaymentMethod', event.currentTarget.value);
            //     this.payment_method = event.currentTarget.value;
            // },
            noteChange(event) {
                console.log('noteChange', event.currentTarget.value);
                this.note = event.currentTarget.value;
            },
            month: function(value) {
                return moment(value).format('MMMM');
            },
            dayOfMonth: function(value) {
                return moment(value).format('D');
            },
            dayOfWeek: function(value) {
                return moment(value).format('dddd');
            },
            datetime: function(value) {
                return moment(value).format('YYYY-MM-DD');
            },
            isToday: function(momentObj) {
                return momentObj.startOf('day', 'd').isSame(moment().startOf('day'), 'd');
            },
            weekAttending: function(weekId) {
                if (this.weeksAttending.find(function(element)
                    {
                        return element == this;
                    }, weekId)
                ) {
                    return true;
                }

                return false;
            },
            div_pref(divPref) {
                let divPrefPart1 = 'gender';
                let divPrefPart2 = 'Flexible';

                if (this.division_preference_first == 'mixed') {
                    divPrefPart1 = 'mixed';
                }

                if (this.division_preference_first == this.division_preference_second) {
                    divPrefPart2 = 'Only';
                }

                console.log('div_pref', divPref == (divPrefPart1 + divPrefPart2));
                return divPref == (divPrefPart1 + divPrefPart2);
            }
        },
        computed: {
            timeFontSize() {
                return this.cycle.weeks.length > 3;
            },
            division_preference() {

                if (this.division_preference_first == this.division_preference_second) {
                    return _.upperFirst(this.division_preference_first) + " only";
                } else {
                    return _.upperFirst(this.division_preference_first) + "/" + _.upperFirst(this.division_preference_second);
                }
            },
            weeksAttendingList() {
                if (this.cycle.weeks.length == this.numOfWeeksSigningUp ){
                    return "All " + this.numOfWeeksSigningUp + " weeks";
                }

                let weeksAttendingSorted = _.sortBy(this.weeksAttending, [function(o) { return o.week; }]);
                let html = '<ul class="mb-1">';
                for(let i=0, len=weeksAttendingSorted.length; i < len; i++) {
                    let week = _.find(this.cycle.weeks, {'id':weeksAttendingSorted[i]});
                    html += "<li>"+ moment(week.starts_at).format("dddd, MMMM Do") + "</li>";
                }
                return html += "</ul>";
            },
            paymentConfirmation() {
                let paymentMethod = _.startCase(_.toLower(this.payment_method.replace(/_/g, " ")));

                return 'Will pay <strong>$' + this.fees + '</strong> via <strong>' + paymentMethod + '</strong>.';
            },
            numOfWeeksSigningUp() {
                return this.weeksAttending.length;
            },
            firstWeekOfCycle() {
                return this.cycle.weeks[0];
            },
            cycleSignupAllowed() {
                // time is before start time with a 30 minute grace period
                console.log('cycleSignupAllowed', moment().isBefore(moment(this.cycle.starts_at).add(30, 'minutes')));
                return moment().isBefore(moment(this.cycle.starts_at).add(30, 'minutes'));
            },
            cycleSignupOpen() {
                // time is before signup closes time
                const closesAt = moment(this.cycle.signup_closes_at);
                return moment().isBefore(closesAt);
            },
            cycleSignupLate() {
                // time is between after signup closes time and 90 minutes before game time
                const closesAt = moment(this.cycle.signup_closes_at);
                const lateCutoff = moment(this.cycle.starts_at).subtract(90, 'minutes');

                console.log('lateCutoff', moment().isBetween(closesAt, lateCutoff));
                return moment().isBetween(closesAt, lateCutoff);
            },
            cycleSignupSuperLate() {
                // time is between after 90 minutes before game time and 30 minutes after start time
                const lateCutoff = moment(this.cycle.starts_at).subtract(90, 'minutes');
                const superLateCutoff = moment(this.cycle.starts_at).add(30, 'minutes');

                console.log('superLate', moment().isBetween(lateCutoff, superLateCutoff));
                return moment().isBetween(lateCutoff, superLateCutoff);
            },
            gameToday() {
                let gameToday = _.find(this.cycle.weeks, function(week) {
                    return moment().startOf('day').diff(moment(week.starts_at).startOf('day')) == 0 ;
                });

                if (gameToday) return gameToday;

                return false;
            },
            subSignupAllowed() {
                // as long as its
                console.log('subSignupAllowed', moment().isBefore(moment(this.cycle.ends_at)));
                return moment().isBefore(moment(this.cycle.ends_at));
            },
            subSignupLate() {
                if (!this.gameToday) return false;
                const closesAt = moment(this.gameToday.starts_at).subtract(3, 'hours');
                const lateCutoff = moment(this.gameToday.starts_at).subtract(90, 'minutes');

                console.log('subSignupLate', moment().isBetween(closesAt, lateCutoff));
                return moment().isBetween(closesAt, lateCutoff);
            },
            subSignupSuperLate() {
                if (!this.gameToday) return false;
                const lateCutoff = moment(this.gameToday.starts_at).subtract(90, 'minutes');
                const superLateCutoff = moment(this.gameToday.starts_at);

                console.log('subSignupSuperLate', moment().isBetween(lateCutoff, superLateCutoff));
                return moment().isBetween(lateCutoff, superLateCutoff);
            },
            signingUpForToday() {
                let signUpForToday = false;

                if (this.gameToday) {
                    signUpForToday = this.weeksAttending.find(function(element){
                        return element == this;
                    }, this.gameToday.id)
                }

                return signUpForToday ? true : false;
            },
            fees() {
                if (this.subSignup) {
                    return this.numOfWeeksSigningUp * 10;
                }

                if (this.numOfWeeksSigningUp == 4) {
                    return 30;
                }
                if (this.numOfWeeksSigningUp == 3) {
                    return 25;
                }
                if (this.numOfWeeksSigningUp == 2) {
                    return 18;
                }
                if (this.numOfWeeksSigningUp == 1) {
                    return 10;
                }

            },
            sub_message() {
                let message = '';

                if (this.numOfWeeksSigningUp == 1) {
                    if (this.signingUpForToday) {
                        message = "<p>Since you're only available tonight, we'll have to count you as a sub which means we can't guarantee a spot at this time.</p>";
                        message += "<p>We may not place you on a team up until a few minutes before game time.</p>";
                        message += "<p>Keep an eye on your email/phone as we will definitely email/text you an update before game time.</p>";
                    } else {
                        message = "<p>Since you're only available one week, we'll have to count you as a sub which means we can't guarantee a spot at this time.</p>";
                        message += "<p>We may not place you on a team up until a few minutes before game time.</p>";
                        message += "<p>On game day, keep an eye on your email/phone as we will definitely email/text you an update before game time.</p>";
                    }

                    return message;
                } else {
                   if (this.subSignupAllowed) {
                        message = "<p>Since the cycle has already started, we'll count you as sub for each week and can't guarantee a spot at this time.</p>";
                        message += "<p>We may not place you on a team up until a few minutes before game time each week.</p>";
                        message += "<p>On each game day, keep an eye on your email/phone as we will definitely email/text you an update before game time.</p>";

                        return message;
                   }
                }
            },
            late_message() {
                let message = '';

                if (! this.signingUpForToday) {
                    if (this.cycleSignupAllowed && this.cycleSignupLate) {
                        return "<p>Cycle sign-up closed earlier, but we should be able to fit you in.</p>";
                    }
                }

                // At this point, they are signing up for today.

                // if they are signing up for than one week of a cycle and they are late, show them the late message.
                if (this.numOfWeeksSigningUp > 1
                    && this.cycleSignupAllowed
                    && this.cycleSignupLate) {
                        message = "<p>Sign-up closed earlier, but we should be able to fit you in for tonight.</p>";
                        message += "<p>Keep an eye out for an email/text confirming your spot before heading out.</p>";

                        return message;
                }

                // at this point, if they are signing up for tonight and are super late, show them super late message
                if (this.cycleSignupSuperLate || this.subSignupSuperLate) {
                        message = "<p>Whoa! Game time is " + moment(this.gameToday.starts_at).fromNow() + " and we're probably on our way to fields.</p>";
                        message += "<p>We may still have some spots for tonight but can't guarantee it.</p>";
                        message += "<p>Finish your sign-up and try texting us to see if a spot is open.</p>";

                        return message;
                }
            }
        },
        mounted() {
            console.log('Cycle Signup Component mounted.')

            // this.weeksAttending = _.map(this.cycle.weeks, 'id');
            this.division_preference_first = this.user.division_preference_first;
            this.division_preference_second = this.user.division_preference_second
                ? this.user.division_preference_second
                : this.user.division_preference_first ;

                this.editMode = false;
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
