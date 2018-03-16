<form accept-charset="utf-8" class="form-vertical" method="POST"
    @if ($edit === true)
        action="{{ route('users.ultimate_history.update', $user->id) }}"
    @else
        action="{{ route('users.ultimate_history.store', $user->id) }}"
    @endif
    >

    @if ($edit === true)
        {!! method_field('patch') !!}
    @endif

    <div class="card mt-4 mb-4">
        <div class="card-body">

            <div class="form-group {{ $errors->has('club_affiliation') ? 'has-danger' : ''}}">
                <label for="club_affiliation" class="required">Who are you playing with in the USA Ultimate series?</label>
                <input name="club_affiliation" type="text" class="form-control {{ $errors->has('club_affiliation') ? 'is-invalid' : ''}}" id="club_affiliation" aria-describedby="nameHelp" placeholder='Required club affiliation' required value={{ old('club_affiliation', $edit == true ? $user->ultimateHistory->club_affiliation : '') }}>

                <div id="club_affiliationFeedback" class="invalid-feedback">{{ $errors->has('club_affiliation') ? $errors->first('club_affiliation') : '' }}</div>
            </div>

            @php
                $years_played_options = [
                    '0-1'   => "0-1 years",
                    '2-3'   => "2-3 years",
                    '4-6'   => "4-6 years",
                    '7-10'  => "7-10 years",
                    '11-15' => "11-15 years",
                    '16+'   => "16+ years",
                ];
            @endphp

            <div class="form-group {{ $errors->has('years_played') ? 'has-danger' : ''}}">
                <label for="years_played" class="required">Year played?</label>
                <select name="years_played" class="form-control div_pref_2-js {{ $errors->has('years_played') ? 'is-invalid' : ''}}" id="years_played" aria-describedby="years_playedHelp" placeholder="Required years played" required>
                    <option disabled {{ old('years_played') ? '' : 'selected' }}>Required years played</option>
                    @foreach($years_played_options as $key => $option)
                        <option value={{ $key }} {{ old('years_played') == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
                <div id="years_playedFeedback" class="invalid-feedback">{{ $errors->has('years_played') ? $errors->first('years_played') : '' }}</div>
            </div>


            <div class="form-group {{ $errors->has('summary') ? 'has-danger' : ''}}">
                <label for="summary" class="required">Summary</label>
                <textarea name="summary" type="text" class="form-control {{ $errors->has('summary') ? 'is-invalid' : ''}}" id="summary" aria-describedby="nameHelp" placeholder='Required summay'>{{ old('summary', $edit == true ? $user->ultimateHistory->summary : '') }}</textarea>
                <small id="summaryHelp" class="form-text text-muted">Give us a brief summary of your Ultimate History. i.e List teams you have played for and when. List any prominent tournies you have competed in and when.</small>
                <div id="summaryFeedback" class="invalid-feedback">{{ $errors->has('summary') ? $errors->first('summary') : '' }}</div>
            </div>

            <div class="form-group {{ $errors->has('def_or_off') ? 'has-danger' : ''}}">
                <label for="def_or_off" class="required">Do you consider yourself a defensive or an offensive player?</label>
                <select name="def_or_off" class="form-control div_pref_2-js {{ $errors->has('def_or_off') ? 'is-invalid' : ''}}" id="def_or_off" aria-describedby="def_or_offHelp" placeholder="Required defensive or offensive" required>
                    <option disabled {{ old('def_or_off') ? '' : 'selected' }}>Required defensive or offensive</option>
                    <option value="Defensive" {{ old('def_or_off') == 'Defensive' ? 'selected' : '' }}>Defensive</option>
                    <option value="Offensive" {{ old('def_or_off') == 'Offensive' ? 'selected' : '' }}>Offensive</option>
                </select>
                <div id="def_or_offFeedback" class="invalid-feedback">{{ $errors->has('def_or_off') ? $errors->first('def_or_off') : '' }}</div>
            </div>

            <div class="form-group {{ $errors->has('fav_offensive_position') ? 'has-danger' : ''}}">
                <label for="fav_offensive_position" class="required">What is your favorite offensive position?</label>
                <input name="fav_offensive_position" type="text" class="form-control {{ $errors->has('fav_offensive_position') ? 'is-invalid' : ''}}" id="fav_offensive_position" aria-describedby="fav_offensive_positionHelp" placeholder='Required favorite offensive position' required value={{ old('fav_offensive_position', $edit == true ? $user->ultimateHistory->fav_offensive_position : '') }}>

                <div id="fav_offensive_positionFeedback" class="invalid-feedback">{{ $errors->has('fav_offensive_position') ? $errors->first('fav_offensive_position') : '' }}</div>
            </div>

            <div class="form-group {{ $errors->has('fav_defensive_position') ? 'has-danger' : ''}}">
                <label for="fav_defensive_position" class="required">What is your favorite defensive position?</label>
                <input name="fav_defensive_position" type="text" class="form-control {{ $errors->has('fav_defensive_position') ? 'is-invalid' : ''}}" id="fav_defensive_position" aria-describedby="fav_defensive_positionHelp" placeholder='Required favorite defensive position' required value={{ old('fav_defensive_position', $edit == true ? $user->ultimateHistory->fav_defensive_position : '') }}>

                <div id="fav_defensive_positionFeedback" class="invalid-feedback">{{ $errors->has('fav_defensive_position') ? $errors->first('fav_defensive_position') : '' }}</div>
            </div>

            <div class="form-group {{ $errors->has('best_skill') ? 'has-danger' : ''}}">
                <label for="best_skill" class="required">What do you consider your best skill in Ultimate?</label>
                <input name="best_skill" type="text" class="form-control {{ $errors->has('best_skill') ? 'is-invalid' : ''}}" id="best_skill" aria-describedby="best_skillHelp" placeholder='Required best ultimate skill' required value={{ old('best_skill', $edit == true ? $user->ultimateHistory->best_skill : '') }}>

                <div id="best_skillFeedback" class="invalid-feedback">{{ $errors->has('best_skill') ? $errors->first('best_skill') : '' }}</div>
            </div>

            <div class="form-group {{ $errors->has('skill_to_improve') ? 'has-danger' : ''}}">
                <label for="skill_to_improve" class="required">What do you consider the skill you need to most improve on in Ultimate?</label>
                <input name="skill_to_improve" type="text" class="form-control {{ $errors->has('skill_to_improve') ? 'is-invalid' : ''}}" id="skill_to_improve" aria-describedby="skill_to_improveHelp" placeholder='Required skill you want to improve' required value={{ old('skill_to_improve', $edit == true ? $user->ultimateHistory->skill_to_improve : '') }}>

                <div id="skill_to_improveFeedback" class="invalid-feedback">{{ $errors->has('skill_to_improve') ? $errors->first('skill_to_improve') : '' }}</div>
            </div>

            <div class="form-group {{ $errors->has('best_throw') ? 'has-danger' : ''}}">
                <label for="best_throw" class="required">What do you consider your best throw in Ultimate?</label>
                <input name="best_throw" type="text" class="form-control {{ $errors->has('best_throw') ? 'is-invalid' : ''}}" id="best_throw" aria-describedby="best_throwHelp" placeholder='Required best ultimate throw' required value={{ old('best_throw', $edit == true ? $user->ultimateHistory->best_throw : '') }}>

                <div id="best_throwFeedback" class="invalid-feedback">{{ $errors->has('best_throw') ? $errors->first('best_throw') : '' }}</div>
            </div>

            <div class="form-group {{ $errors->has('throw_to_improve') ? 'has-danger' : ''}}">
                <label for="throw_to_improve" class="required">What do you consider the throw you need to most improve on in Ultimate?</label>
                <input name="throw_to_improve" type="text" class="form-control {{ $errors->has('throw_to_improve') ? 'is-invalid' : ''}}" id="throw_to_improve" aria-describedby="throw_to_improveHelp" placeholder='Required throw you want to improve' required value={{ old('throw_to_improve', $edit == true ? $user->ultimateHistory->throw_to_improve : '') }}>

                <div id="throw_to_improveFeedback" class="invalid-feedback">{{ $errors->has('throw_to_improve') ? $errors->first('throw_to_improve') : '' }}</div>
            </div>
        </div>
    </div>

    <input class="btn btn btn-primary btn-block" type="submit" value="Save">

    {{ csrf_field() }}
</form>

@push('scripts')
    <script>
        $(document).ready( function () {

        })
    </script>
@endpush