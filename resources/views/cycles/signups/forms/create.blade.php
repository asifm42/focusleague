<form accept-charset="utf-8" class="form-vertical"
    @if ($edit === true)
        @if (auth()->user()->isAdmin())
            method="PATCH" action="{{ route('cyclesignups.update', $signup->id) }}"
        @else
            method="PATCH" action="{{ route('cycle.signup.update', $signup->id) }}"
        @endif
    @else
        method="POST" action="{{ route('cycle.signup.store', $cycle->id) }}"
    @endif
    >

<div class="card mb-2">
    <div class="card-body">
        <div class="form-group">
            <label for="nickname">Player</label>
            <input name="nickname" type="text" class="form-control" id="name" aria-describedby="nicknameHelp" disabled value={{ $user->nickname }}>
        </div>

    @php
        $options = $user->isMale() ? ['Mens' => 'Mens', 'Mixed' => 'Mixed'] : ['Womens' => 'Womens', 'Mixed' => 'Mixed'];
        if ($edit === false) {
            $div_pref_1_selected = $user->division_preference_first;
        } else {
            $div_pref_1_selected = $signup->div_pref_first;
        }
    @endphp

{{--         {!! Former::select('div_pref_first')
            ->addClass('form-control div_pref_1-js')
            ->options($options)
            ->placeholder('Required first division preference')
            ->select($div_pref_1_selected)
            ->required()
        !!} --}}

        <div class="form-group">
            <label for="div_pref_first" class="required">Primary Division Preference</label>
            <select name="div_pref_first" class="form-control div_pref_1-js" id="div_pref_first" aria-describedby="div_pref_firstHelp" placeholder='Required first division preference' required>
                @foreach($options as $key => $option)
                    <option value="$option" {{ $div_pref_1_selected == $key ? 'selected' : '' }}>{{ $option }}</option>
                @endforeach
            </select>
        </div>

    @php
        $options = $user->isMale() ? ['Mens' => 'Mens', 'Mixed' => 'Mixed'] : ['Womens' => 'Womens', 'Mixed' => 'Mixed'];
        if ($edit === false) {
            $div_pref_2_selected = $user->division_preference_second;
        } else {
            $div_pref_2_selected = $signup->div_pref_second;
        }
    @endphp

        <div class="form-group">
            <label for="div_pref_second" class="required">Alt Division Preference</label>
            <select name="div_pref_second" class="form-control div_pref_2-js" id="div_pref_second" aria-describedby="div_pref_secondHelp" placeholder='Required second division preference' required>
                @foreach($options as $key => $option)
                    <option value="$option" {{ $div_pref_2_selected == $key ? 'selected' : '' }}>{{ $option }}</option>
                @endforeach
            </select>
            <small id="div_pref_secondHelp" class="form-text text-muted">Leave this blank or select the same as your first preference if you prefer to sit out this cycle if your division is not available.</small>
        </div>

{{--         {!! Former::select('div_pref_second')
            ->addClass('form-control div_pref_2-js')
            ->options($options)
            ->select($div_pref_2_selected)
            ->placeholder('Optional second division preference')
            ->help('Leave this blank or select the same as your first preference if you prefer to sit out this cycle if your division is not available.')
        !!} --}}
    @php
        $checkbox_options = [];
        if ($edit === false) {
            foreach ($cycle->weeks as $week) {
                $checkbox_options[$week->starts_at->toFormattedDateString()] = [
                    'name' => 'weeks['.$week->id.']',
                    'value' => 1,
                    'data-week_id' => $week->id,
                ];
            }
        } else {
            foreach ($cycle->weeks as $week) {
                $checkbox_options[$week->starts_at->toFormattedDateString()] = [
                    'name' => 'weeks['.$week->id.']',
                    'value' => 1,
                    'data-week_id' => $week->id,
                    'checked' => ($user->availability()->find($week->id)->pivot->attending ? true : false),
                ];
            }
        }
    @endphp
{{--         {!! Former::checkboxes('weeks[]')
            ->label('Availability')
            ->addClass('availability-js')
            ->help('You must be available 2 out of the ' . $cycle->weeks->count() . ' weeks to sign up')
            ->checkboxes($checkbox_options)
        !!} --}}

    <fieldset class="form-group">
        <legend>Availability</legend>
        @foreach($checkbox_options as $week => $option)
        <div class="form-check">
            <label for="{{ $option['name'] }}" class="form-check-label">
                <input class="form-control" type="hidden" name={{ $option['name'] }} value="0">
                <input name={{ $option["name"] }} id={{ $option['name'] }} class="form-check-input availability-js" type="checkbox" value={{ $option['value'] }} {{ array_key_exists('checked', $option) && $option ['checked'] ? "checked" : "" }} data-week_id={{ $option['data-week_id'] }}>
                {{ $week }}
            </label>
        </div>
        @endforeach
    </fieldset>

        <div class="cost-stmt text-info" style="display: none;">
            <p>Your account will be charged <span class="cost-text"></span></p>
        </div>


    @php
        if ($cycle->weeks->count() > 3) {
            $captainHelpMsg = 'You must be available 3 out of the ' . $cycle->weeks->count() . ' weeks to be a captain';
        } else {
            $captainHelpMsg = 'You must be available all ' . $cycle->weeks->count() . ' weeks to be a captain';
        }
    @endphp

{{--         <div class='will_captain_group-js' style="display:none;">
            {!! Former::checkbox('will_captain')
                ->label('Are you willing to captain this cycle?')
                ->text('&nbsp;&nbsp;'.'Yes')
                ->class('form control will_captain-js')
                ->help($captainHelpMsg)
            !!}
        </div> --}}

    <fieldset class="form-group will_captain_group-js" style="display:none;">
        <legend>Are you willing to captain this cycle?</legend>

        <div class="form-check">
            <label for="will_captain" class="form-check-label">
                <input class="form-control" type="hidden" name="will_captain" value="0">
                <input class="form-check-input will_captain-js" id="will_captain" type="checkbox" name="will_captain" value="1">
                Yes
            </label>
        </div>
            <small id="will_captainHelp" class="form-text text-muted">{{ $captainHelpMsg }}</small>

{{-- <div class="will_captain_group-js" style="">
            <label for="will_captain">Are you willing to captain this cycle?</label>
            <div class="checkbox"><label for="will_captain" class="">
                <input class="form-control" type="hidden" name="will_captain" value="0">
                <input class="form control will_captain-js" id="will_captain" type="checkbox" name="will_captain" value="1">
            &nbsp;&nbsp;Yes</label></div>
        </div> --}}
    </fieldset>



        {!! Former::textarea('note')
            ->label('Note')
            ->placeholder('Optional note')
        !!}
    </div>

</div>

    <input class="btn btn btn-success btn-block submit_btn-js" type="submit" disabled
        @if($edit === true)
            value="Save"
        @else
            value="Sign up"
        @endif
    >

    {{ csrf_field() }}
</form>



{{--         @if($edit === true)
            {!! Former::submit()
                ->addClass('btn btn-success btn-block submit_btn-js')
                ->value('Save')
                ->disabled();
            !!}
        @else
            {!! Former::submit()
                ->addClass('btn btn-success btn-block')
                ->value('Sign up')
                ->disabled();
            !!}
        @endif
    {!! Former::close() !!} --}}

@push('scripts')
    <script>
        $(document).ready( function () {
            $('.availability-js').change(function(){
                var $cost_stmt = $('p.cost-stmt');


                var checked_count = $('.availability-js').filter(function( index ){
                    return $(this).prop('checked');
                }).length;
                console.log(checked_count);

                // update the signup button
                if (checked_count >= 2) {
                    $('.submit_btn-js').prop('disabled', false);
                } else {
                    $('.submit_btn-js').prop('disabled', true);
                }

                if (checked_count >= 3) {
                    $('.will_captain_group-js').show(1000);
                } else {
                    $('.will_captain_group-js').hide(1000);
                    $('#will_captain').prop('checked', false);
                }

                if (checked_count == 2) {
                    $('.cost-text').text( '$' + parseFloat({{  $cost['cycle']['two_weeks'] }} / 100).toFixed(2));
                    $('div.cost-stmt').show(1000);
                } else if (checked_count == 3) {
                    $('.cost-text').text( '$' + parseFloat({{  $cost['cycle']['three_weeks'] }} / 100).toFixed(2));
                    $('div.cost-stmt').show(1000);
                } else if (checked_count == 4) {
                    $('.cost-text').text( '$' + parseFloat({{  $cost['cycle']['four_weeks'] }} / 100).toFixed(2));
                    $('div.cost-stmt').show(1000);
                } else {
                    $('.cost-text').text( '$' + parseFloat({{  $cost['cycle']['two_weeks'] }} / 100).toFixed(2));
                    $('div.cost-stmt').hide(1000);
                }
            });

            $('.availability-js').change();
        })
    </script>
@endpush