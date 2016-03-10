<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title">Sign up for the cycle</h3>
    </div>

    <div class="panel-body">
        @if($edit === true)
            @if (auth()->user()->isAdmin())
                {!! Former::vertical_open()
                    ->method('PATCH')
                    ->action(route('cyclesignups.update', $signup->id))
                !!}
            @else
                {!! Former::vertical_open()
                    ->method('PATCH')
                    ->action(route('cycle.signup.update', $cycle->id))
                !!}
            @endif
        @else
            {!! Former::vertical_open()
                ->action(route('cycle.signup.store', $cycle->id))
            !!}
        @endif

        {!! Former::text('nickname')
            ->label('Player')
            ->addClass('form-control')
            ->placeholder($user->nickname)
            ->disabled()
        !!}

    <?php
        $options = $user->isMale() ? ['Mens' => 'Mens', 'Mixed' => 'Mixed'] : ['Womens' => 'Womens', 'Mixed' => 'Mixed'];
        if ($edit === false) {
            $div_pref_1_selected = $user->division_preference_first;
        } else {
            $div_pref_1_selected = $signup->div_pref_first;
        }
    ?>
        {!! Former::select('div_pref_first')
            ->addClass('form-control div_pref_1-js')
            ->options($options)
            ->placeholder('Required first division preference')
            ->select($div_pref_1_selected)
            ->required()
        !!}

    <?php
        $options = $user->isMale() ? ['Mens' => 'Mens', 'Mixed' => 'Mixed'] : ['Womens' => 'Womens', 'Mixed' => 'Mixed'];
        if ($edit === false) {
            $div_pref_2_selected = $user->division_preference_second;
        } else {
            $div_pref_2_selected = $signup->div_pref_second;
        }
    ?>
        {!! Former::select('div_pref_second')
            ->addClass('form-control div_pref_2-js')
            ->options($options)
            ->select($div_pref_2_selected)
            ->placeholder('Optional second division preference')
            ->help('Leave this blank or select the same as your first preference if you prefer to sit out this cycle if your division is not available.')
        !!}
    <?php
        $checkbox_options = [];
        if ($edit === false) {
            foreach ($cycle->weeks as $week) {
                $checkbox_options['&nbsp; ' . $week->starts_at->toFormattedDateString()] = [
                    'name' => 'weeks['.$week->id.']',
                    'value' => 1,
                    'data-week_id' => $week->id,
                ];
            }
        } else {
            foreach ($cycle->weeks as $week) {
                $checkbox_options['&nbsp; ' . $week->starts_at->toFormattedDateString()] = [
                    'name' => 'weeks['.$week->id.']',
                    'value' => 1,
                    'data-week_id' => $week->id,
                    'checked' => ($user->availability()->find($week->id)->pivot->attending ? true : false),
                ];
            }
        }
    ?>
        {!! Former::checkboxes('weeks[]')
            ->label('Availability')
            ->addClass('availability-js')
            ->help('You must be available 2 out of the 4 weeks to sign up')
            ->checkboxes($checkbox_options)
        !!}

        <div class="cost-stmt text-info" style="display: none;"><p>Your account will be charged <span class="cost-text"></span></p></div>
        <div class='will_captain_group-js' style="display:none;">
            {!! Former::checkbox('will_captain')
                ->label('Are you willing to captain this cycle?')
                ->text('Yes')
                ->class('form control will_captain-js')
                ->help('You must be available 3 out of the 4 weeks to be a captain')
            !!}
        </div>
        {!! Former::textarea('note')
            ->label('Note')
            ->placeholder('Optional note')
        !!}
    </div>

    <div class="panel-footer">
        @if($edit === true)
            {!! Former::submit()
                ->addClass('btn btn-primary submit_btn-js')
                ->value('Save')
                ->disabled();
            !!}
        @else
            {!! Former::submit()
                ->addClass('btn btn-primary submit_btn-js')
                ->value('Sign up')
                ->disabled();
            !!}
        @endif
    </div>
    {!! Former::close() !!}
</div>

@section('scripts')
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
                    $('.cost-text').text('$18');
                    $('div.cost-stmt').show(1000);
                } else if (checked_count == 3) {
                    $('.cost-text').text('$21');
                    $('div.cost-stmt').show(1000);
                } else if (checked_count == 4) {
                    $('.cost-text').text('$24');
                    $('div.cost-stmt').show(1000);
                } else {
                    $('.cost-text').text('$18');
                    $('div.cost-stmt').hide(1000);
                }
            });

            $('.availability-js').change();
        })
    </script>
@stop