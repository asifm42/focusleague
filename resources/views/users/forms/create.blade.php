<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title">Sign up for a new account</h3>
    </div>

    <div class="panel-body">
        @if($edit === true)
            {!! Former::vertical_open()
                ->method('PATCH')
                ->action(route('users.update', $user->id))
            !!}
        @else
            {!! Former::vertical_open()
                ->action(route('users.store'))
            !!}
        @endif

        {!! Former::text('name')
            ->addClass('form-control')
            ->placeholder('Required name')
            ->autofocus('autofocus')
            ->required()
        !!}
        {!! Former::text('nickname')
            ->addClass('form-control')
            ->placeholder('Optional nickname')
            ->('We will mostly address you by this name through out the system. Leave it blank to use your first name.')
        !!}
        @if($edit === true)
            {!! Former::text('email')
                ->addClass('form-control')
                ->disabled('');
            !!}
        @else
            {!! Former::text('email')
                ->addClass('form-control')
                ->placeholder('Required email')
                ->required()
            !!}
        @endif
        {!! Former::text('cell_number')
            ->addClass('form-control cell_number-js')
            ->placeholder('Required cell number')
            ->help('for last-minute text communications')
            ->required()
        !!}
        {!! Former::select('mobile_carrier')
            ->addClass('form-control')
            ->options([
                'att' => 'AT&T',
                'tmobile' => 'T-Mobile',
                'verizon' => 'Verizon',
                'sprint' => 'Sprint',
                'other' => 'Other',
                ])
            ->placeholder('Required mobile carrier')
            ->required()
            ->help('for last-minute text communications')
        !!}
        {!! Former::select('gender')
            ->addClass('form-control gender-js')
            ->options(['male' => 'Male', 'female' => 'Female'])
            ->placeholder('Required gender')
            ->required()
        !!}
        {!! Former::text('birthday')
            ->id('birthday_picker-js')
            ->addClass('form-control')
            ->placeholder('Required birthday')
            ->help('MM/DD/YYYY')
            ->required()
        !!}
        {!! Former::select('dominant_hand')
            ->addClass('form-control')
            ->options(['left' => 'Left', 'right' => 'Right'])
            ->placeholder('Required dominant hand')
            ->required()
        !!}
        {!! Former::select('height')
            ->addClass('form-control')
            ->options([
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
                ])
            ->placeholder('Required height')
            ->required()
        !!}
        {!! Former::select('division_preference_first')
            ->addClass('form-control div_pref_1-js')
            ->options(['mens' => 'Mens', 'mixed' => 'Mixed', 'womens' => 'Womens'])
            ->placeholder('Required first division preference')
            ->required()
        !!}
        {!! Former::select('division_preference_second')
            ->addClass('form-control div_pref_2-js')
            ->options(['mens' => 'Mens', 'mixed' => 'Mixed', 'womens' => 'Womens'])
            ->placeholder('Optional second division preference')
            ->help('Leave this blank or select the same as your first preference if you prefer to sit out this cycle if your division is not available.')
        !!}
        @if($edit === true)
            {!! Former::password('password')
                ->addClass('form-control')
                ->placeholder('Fill out if changing')
            !!}
            {!! Former::password('password_confirmation')
                ->addClass('form-control')
                ->label('Password (again)')
                ->placeholder('Fill out if changing')
            !!}
        @else
            {!! Former::password('password')
                ->addClass('form-control')
                ->placeholder('Required password')
                ->required()
            !!}
            {!! Former::password('password_confirmation')
                ->addClass('form-control')
                ->label('Password (again)')
                ->placeholder('Required password confirmation')
                ->required()
            !!}
        @endif
    </div>

    <div class="panel-footer">
        @if($edit === true)
            {!! Former::submit()
                ->addClass('btn btn-primary')
                ->value('Save')
            !!}
        @else
            {!! Former::submit()
                ->addClass('btn btn-primary')
                ->value('Sign up')
            !!}
        @endif
    </div>
    {!! Former::close() !!}
</div>

@section('scripts')
    <script>
        $(document).ready( function () {
            // For popovers on the navbar
            // $('[data-toggle="popover"]').popover();
            console.log('hello');
            $(function () {
                $('#birthday_picker-js').datetimepicker({
                    format: 'MM/DD/YYYY',
                    viewMode: 'years'
                });
            });

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
        })
    </script>
@stop