<form accept-charset="utf-8" class="form-vertical" method="POST"
    @if ($edit === true)
        action="{{ route('users.update', $user->id) }}"
    @else
        action="{{ route('users.store') }}"
    @endif
    >

    @if ($edit === true)
        {!! method_field('patch') !!}
    @endif

    <div class="card mt-4 mb-4">
        <div class="card-body">
            <div class="form-group {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="required">Name</label>
                <input name="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" id="name" aria-describedby="nameHelp" placeholder="Required first & last name" required value={{ old('name', $user->name) }}>
                <small id="nameHelp" class="form-text text-muted">Please provide first and last name.</small>
                <div id="nameFeedback" class="invalid-feedback">{{ $errors->has('name') ? $errors->first('name') : '' }}</div>
            </div>

            <div class="form-group {{ $errors->has('nickname') ? 'has-danger' : ''}}">
                <label for="nickname">Nickname</label>
                <input name="nickname" type="text" class="form-control {{ $errors->has('nickname') ? 'is-invalid' : ''}}" id="nickname" aria-describedby="nicknameHelp" placeholder="Optional nickname" value={{ old('nickname', $user->nickname) }}>
                <small id="nicknameHelp" class="form-text text-muted">We will mostly address you by this name through out the system. Leave it blank to use your first name + the first 3 letters of your last name.</small>
                <div id="nicknameFeedback" class="invalid-feedback">{{ $errors->has('nickname') ? $errors->first('nickname') : '' }}</div>
            </div>

            <div class="form-group {{ $errors->has('email') ? 'has-danger' : ''}}">
                <label for="email" class="required">Email</label>
                <input name="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" id="email" aria-describedby="emailHelp" required placeholder="Required email" value={{ old('email', $user->email) }} {{ $edit ? 'readonly' : '' }}>
                <div id="emailFeedback" class="invalid-feedback">{{ $errors->has('email') ? $errors->first('email') : '' }}</div>
            </div>

            <div class="form-group {{ $errors->has('cell_number') ? 'has-danger' : ''}}">
                <label for="cell_number" class="required">Cell number</label>
                <input name="cell_number" type="text" class="form-control cell_number-js {{ $errors->has('cell_number') ? 'is-invalid' : ''}}" id="cell_number" aria-describedby="cell_numberHelp" placeholder="Required cell number" value={{ old('cell_number', $user->cell_number) }}>
                <small id="cell_numberHelp" class="form-text text-muted">For last-minute text communications.</small>
                <div id="cell_numberFeedback" class="invalid-feedback">{{ $errors->has('cell_number') ? $errors->first('cell_number') : '' }}</div>
            </div>
            <div class="form-group {{ $errors->has('mobile_carrier') ? 'has-danger' : ''}}">
                <label for="mobile_carrier" class="required">Mobile Carrier</label>
                <select name="mobile_carrier" class="form-control {{ $errors->has('mobile_carrier') ? 'is-invalid' : ''}}" id="mobile_carrier" aria-describedby="mobile_carrierHelp" placeholder="Required mobile carrier" required>
                    <option disabled {{ old('mobile_carrier') ? '' : 'selected' }}>Required mobile carrier</option>
                    <option value="att" {{ old('mobile_carrier', $user->mobile_carrier) == 'att' ? 'selected' : '' }}>AT&amp;T</option>
                    <option value="tmobile" {{ old('mobile_carrier', $user->mobile_carrier) == 'tmobile' ? 'selected' : '' }}>T-Mobile</option>
                    <option value="verizon" {{ old('mobile_carrier', $user->mobile_carrier) == 'verizon' ? 'selected' : '' }}>Verizon</option>
                    <option value="sprint" {{ old('mobile_carrier', $user->mobile_carrier) == 'sprint' ? 'selected' : '' }}>Sprint</option>
                    <option value="other" {{ old('mobile_carrier', $user->mobile_carrier) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                <small id="mobile_carrierHelp" class="form-text text-muted">For last-minute text communications.</small>
                <div id="mobile_carrierFeedback" class="invalid-feedback">{{ $errors->has('mobile_carrier') ? $errors->first('mobile_carrier') : '' }}</div>
            </div>
            <div class="form-group {{ $errors->has('gender') ? 'has-danger' : ''}}">
                <label for="gender" class="required">Gender</label>
                <select name="gender" class="form-control gender-js {{ $errors->has('gender') ? 'is-invalid' : ''}}" id="gender" aria-describedby="genderHelp" placeholder="Required gender" required>
                    <option disabled  {{ old('gender') ? '' : 'selected' }}>Required gender</option>
                    <option value="male" {{ old('gender', strtolower($user->gender)) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', strtolower($user->gender)) == 'female' ? 'selected' : '' }}>Female</option>
                </select>
                <div id="genderFeedback" class="invalid-feedback">{{ $errors->has('gender') ? $errors->first('gender') : '' }}</div>
            </div>
            <div class="form-group {{ $errors->has('birthday') ? 'has-danger' : ''}}">
                <label for="birthday" class="required">Birthday</label>
                <input name="birthday" type="date" class="form-control {{ $errors->has('birthday') ? 'is-invalid' : ''}}" id="birthday" aria-describedby="birthdayHelp" placeholder="Required birthday" required value="{{ old('birthday', $user->birthday ? $user->birthday->format('Y-m-d') : null) }}">
                <div id="birthdayFeedback" class="invalid-feedback">{{ $errors->has('birthday') ? $errors->first('birthday') : '' }}</div>
            </div>
            <div class="form-group {{ $errors->has('dominant_hand') ? 'has-danger' : ''}}">
                <label for="dominant_hand" class="required">Dominant hand</label>
                <select name="dominant_hand" class="form-control {{ $errors->has('dominant_hand') ? 'is-invalid' : ''}}" id="dominant_hand" aria-describedby="dominant_handHelp" placeholder="Required dominant hand" required>
                    <option disabled  {{ old('dominant_hand') ? '' : 'selected' }}="">Required dominant hand</option>
                    <option value="left" {{ old('dominant_hand', strtolower($user->dominant_hand)) == 'left' ? 'selected' : '' }}>Left</option>
                    <option value="right" {{ old('dominant_hand', strtolower($user->dominant_hand)) == 'right' ? 'selected' : '' }}>Right</option>
                </select>
                <div id="dominant_handFeedback" class="invalid-feedback">{{ $errors->has('dominant_hand') ? $errors->first('dominant_hand') : '' }}</div>
            </div>

        @php
            $heightOptions = [
                '56' => "4' 8\"",
                '57' => "4' 9\"",
                '58' => "4' 10\"",
                '59' => "4' 11\"",
                '60' => "5' 0\"",
                '61' => "5' 1\"",
                '62' => "5' 2\"",
                '63' => "5' 3\"",
                '64' => "5' 4\"",
                '65' => "5' 5\"",
                '66' => "5' 6\"",
                '67' => "5' 7\"",
                '68' => "5' 8\"",
                '69' => "5' 9\"",
                '70' => "5' 10\"",
                '71' => "5' 11\"",
                '72' => "6' 0\"",
                '73' => "6' 1\"",
                '74' => "6' 2\"",
                '75' => "6' 3\"",
                '76' => "6' 4\"",
                '77' => "6' 5\"",
                '78' => "6' 6\"",
                '79' => "6' 7\"",
                '80' => "6' 8\"",
                '81' => "6' 9\"",
                '82' => "6' 10\"",
                '83' => "6' 11\"",
                '84' => "7' 0\"",
            ]
        @endphp

            <div class="form-group {{ $errors->has('height') ? 'has-danger' : ''}}">
                <label for="height" class="required">Height</label>
                <select name="height" class="form-control {{ $errors->has('height') ? 'is-invalid' : ''}}" id="height" aria-describedby="heightHelp" placeholder="Required height" required>
                    <option disabled {{ old('height') ? '' : 'selected' }}>Required height</option>
                    @foreach($heightOptions as $value => $option)
                        <option value="{{ $value }}" {{ old('height', $user->height) == $value ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
                <div id="heightFeedback" class="invalid-feedback">{{ $errors->has('height') ? $errors->first('height') : '' }}</div>
            </div>

            <div class="form-group {{ $errors->has('division_preference_first') ? 'has-danger' : ''}}">
                <label for="division_preference_first" class="required">Division preference first</label>
                <select name="division_preference_first" class="form-control div_pref_1-js  {{ $errors->has('division_preference_first') ? 'is-invalid' : ''}}" id="division_preference_first" aria-describedby="division_preference_firstHelp" placeholder="Required first division preference" required>
                    <option disabled  {{ old('division_preference_first') ? '' : 'selected' }}>Required first division preference</option>
                    <option value="mens" {{ old('division_preference_first', strtolower($user->division_preference_first)) == 'mens' ? 'selected' : '' }}>Mens</option>
                    <option value="mixed" {{ old('division_preference_first', strtolower($user->division_preference_first)) == 'mixed' ? 'selected' : '' }}>Mixed</option>
                    <option value="womens" {{ old('division_preference_first', strtolower($user->division_preference_first)) == 'womens' ? 'selected' : '' }}>Womens</option>
                </select>
                <div id="division_preference_firstFeedback" class="invalid-feedback">{{ $errors->has('division_preference_first') ? $errors->first('division_preference_first') : '' }}</div>
            </div>
            <div class="form-group {{ $errors->has('division_preference_second') ? 'has-danger' : ''}}">
                <label for="division_preference_second" class="required">Division preference second</label>
                <select name="division_preference_second" class="form-control div_pref_2-js {{ $errors->has('division_preference_second') ? 'is-invalid' : ''}}" id="division_preference_second" aria-describedby="division_preference_secondHelp" placeholder="Optional second division preference" required>
                    <option disabled {{ old('division_preference_second') ? '' : 'selected' }}>Optional second division preference</option>
                    <option value="mens" {{ old('division_preference_second', strtolower($user->division_preference_second)) == 'mens' ? 'selected' : '' }}>Mens</option>
                    <option value="mixed" {{ old('division_preference_second', strtolower($user->division_preference_second)) == 'mixed' ? 'selected' : '' }}>Mixed</option>
                    <option value="womens" {{ old('division_preference_second', strtolower($user->division_preference_second)) == 'womens' ? 'selected' : '' }}>Womens</option>
                </select>
                <small id="division_preference_secondHelp" class="form-text text-muted">Leave this blank or select the same as your first preference if you prefer to sit out this cycle if your division is not available.</small>
                <div id="division_preference_secondFeedback" class="invalid-feedback">{{ $errors->has('division_preference_second') ? $errors->first('division_preference_second') : '' }}</div>
            </div>

            <div class="form-group {{ $errors->has('password') ? 'has-danger' : ''}}">
                <label for="password" class="{{ $edit ? '' : 'required' }}">Password</label>
                <input name="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : ''}} password-js" id="password" aria-describedby="passwordHelp" placeholder="{{ $edit ? 'Optional' : 'Required' }} password" {{ $edit ? '' : 'required' }}>
                <small id="passwordHelp" class="form-text text-muted">{{ $edit ? 'Fill out if changing.' : '' }} Minimum 8 characters. Case-sensitive.</small>
                <div id="passwordFeedback" class="invalid-feedback">{{ $errors->has('password') ? $errors->first('password') : '' }}</div>
            </div>

            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-danger' : ''}}">
                <label for="password_confirmation" class="{{ $edit ? '' : 'required' }}">Password (again)</label>
                <input name="password_confirmation" type="password" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : ''}} password_confirmation-js" id="password_confirmation" aria-describedby="password_confirmationHelp" placeholder="{{ $edit ? 'Required password confirmation IF changing' : 'Required password confirmation' }}" {{ $edit ? '' : 'required' }}>
                @if($edit === true)
                    <small id="password_confirmationHelp" class="form-text text-muted">Fill out if changing.</small>
                @endif
                <div id="password_confirmationFeedback" class="invalid-feedback">{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}</div>
            </div>
            <div class="form-group mb-0 {{ $errors->has('humancaptcha') ? 'has-danger' : ''}}">
                <label for="humancaptcha">What is the force?</label>
                <input name="humancaptcha" type="text" class="form-control {{ $errors->has('humancaptcha') ? 'is-invalid' : ''}}" id="humancaptcha" aria-describedby="humancaptchaHelp" placeholder="Name one of the 2 common throws" value={{ old('humancaptcha', $user->humancaptcha) }}>
                <small id="humancaptchaHelp" class="form-text text-muted">Just checking if a human is submitting this form.</small>
                <div id="humancaptchaFeedback" class="invalid-feedback">{{ $errors->has('humancaptcha') ? $errors->first('humancaptcha') : '' }}</div>
            </div>
        </div>
    </div>

    <input class="btn btn btn-primary btn-block" type="submit" value="{{ $edit ? 'Save' : 'Sign up'}}">

    {{ csrf_field() }}
</form>

@push('scripts')
    <script>
        $(document).ready( function () {
            var maleOptions = {
                "mens":"Mens",
                "mixed" : "Mixed"
            };

            var femaleOptions = {
                "womens":"Womens",
                "mixed" : "Mixed"
            };

            $('.gender-js').change(function(){
                $('.div_pref_1-js option:gt(0)').remove();
                $('.div_pref_2-js option:gt(0)').remove();
                if ($(this).val() === 'male') {
                    var options = maleOptions;
                }
                if ($(this).val() === 'female') {
                    var options = femaleOptions;
                }

                $.each(options, function(value,key) {
                    $('.div_pref_1-js').append($("<option></option>")
                    .attr("value", value).text(key));
                    $('.div_pref_2-js').append($("<option></option>")
                    .attr("value", value).text(key));
                });
            })

            $('.cell_number-js').keyup(function(){

            });

            $('.gender-js').trigger('change')
        })
    </script>
@endpush
