<div class="panel panel-default">

    <div class="panel-heading">
        @if($edit === true)
            <h3 class="panel-title">Edit a transaction</h3>
        @else
            <h3 class="panel-title">Create a transaction</h3>
        @endif
    </div>

    <div class="panel-body">
        @if($edit === true)
            {!! Former::vertical_open()
                ->method('PATCH')
                ->action(route('transactions.update', $transaction->id))
            !!}
        @else
            {!! Former::vertical_open()
                ->action(route('transactions.store'))
            !!}
        @endif
        {!! Former::text('name')
            ->label('Player name')
            ->addClass('users-typeahead-js')
            ->placeholder('Required name')
            ->autofocus('autofocus')
            ->required()
        !!}
        {!! Former::hidden('user_id')
            ->required()
        !!}
        <div class="row">
            <div class="col-xs-4 col-md-4">
                {!! Former::text('date')
                    ->name('date')
                    ->label('Transaction Date')
                    ->id('trans_date_picker-js')
                    ->addClass('form-control')
                    ->placeholder('Optional date')
                    ->help('MM/DD/YYYY')
                !!}
            </div>
            <div class="col-xs-4 col-md-4">
                {!! Former::select('cycle_id')
                    ->label('Cycle')
                    ->addClass('js-cycle')
                    ->addGroupClass('js-cycle-group')
                    ->placeholder('Optional cycle')
                    ->options([ 0 => 'N/A'])
                    ->fromQuery($cycles->sortByDesc('name'), 'name', 'id')
                !!}
            </div>
            <div class="col-xs-4 col-md-4">
                {!! Former::select('week_id')
                    ->label('Week')
                    ->addClass('js-week')
                    ->addGroupClass('js-week-group')
                    ->placeholder('Optional week')
                    ->options([ 0 => 'N/A'])
                    ->fromQuery($weeks->sortByDesc('starts_at'), 'starts_at', 'id')
                !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-8 col-md-8">
                {!! Former::select('transaction_type')
                    ->label('Type')
                    ->addClass('js-transaction-type')
                    ->placeholder('Required type')
                    ->options([
                        'paypal' => 'Paypal payment',
                        'venmo' => 'Venmo payment',
                        'chase quickpay' => 'Chase Quickpay payment',
                        'square cash' => 'Square Cash payment',
                        'check' => 'Check payment',
                        'cash' => 'Cash payment',
                        'charge' => 'Charge',
                        'credit' => 'Credit',
                    ])
                    ->required()
                !!}
                {!! Former::hidden('type')
                    ->addClass('js-type')
                    ->required()
                !!}
                {!! Former::hidden('payment_type')
                    ->addClass('js-payment-type')
                !!}
            </div>
            <div class="col-xs-4 col-md-4">
                {!! Former::text('amount')
                    ->addClass('form-control')
                    ->placeholder("Req'd amount")
                    ->required()
                !!}
            </div>
        </div>
        {!! Former::textarea('description')
            ->addClass('js-description')
            ->placeholder('Required description')
            ->required()
        !!}
    </div>

    <div class="panel-footer">
        @if($edit === true)
            {!! Former::submit()
                ->addClass('btn btn-primary')
                ->value('Save')
            !!}
            {!! Former::close() !!}

            {!! Former::open()
                ->method('DELETE')
                ->class('pull-right')
                ->action(route('transactions.destroy', $transaction->id))
            !!}
            {!! Former::submit()
                ->addClass('btn btn-danger')
                ->value('Delete')
            !!}
            {!! Former::close() !!}
        @else
            {!! Former::submit()
                ->addClass('btn btn-primary')
                ->value('Create')
            !!}
            {!! Former::close() !!}
        @endif
    </div>
</div>

@section('scripts')
    <script>
        var cycles = {!! $cycles !!},
            weeks = {!! $weeks !!};

        $(document).ready( function () {
            var users = new Bloodhound({
                local:{!! $names !!},
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name')
            });

            $(function () {
                $('#trans_date_picker-js').datetimepicker({
                    defaultDate: moment().format('MM/DD/YYYY'),
                    format: 'MM/DD/YYYY',
                });
            });

            $('.users-typeahead-js').typeahead({
                minLength: 1,
                highlight: true,
                hint:true
            }, {
                  name: 'users',
                  source: users,
                  display: function(obj) { return obj.name; },
                    templates: {
                        empty: [
                            '<div class="noitems">',
                            'No Players Found',
                            '</div>'
                        ].join('\n')
                    }
            });

            $('.twitter-typeahead').css('display', 'block');

            $('.users-typeahead-js').bind('typeahead:select', function(ev, suggestion) {
                console.log('Selection: ', suggestion);
                $('input[name = user_id]').val(suggestion.id);
                if (suggestion.balance > 0) {
                    $('input[name = amount]').val(suggestion.balance);
                } else if (suggestion.balance <= 0) {
                    $('input[name = amount]').val('');
                }
            });

            @if(isset($typeahead_name))
                $('.users-typeahead-js').typeahead('val', "{!! $typeahead_name !!}");
            @endif

            @if (isset($balance) && $balance > 0)
                $('input[name = amount]').val({!! $balance !!});
            @endif

            $('.js-transaction-type').change(function(evt) {
                selectedValue = evt.target.selectedOptions.item(0).value;

                switch (selectedValue) {
                    case 'paypal':
                        $('.js-type').val('payment');
                        $('.js-payment-type').val('paypal');
                        $('.js-description').val('Payment id: ');
                        break;
                    case 'venmo':
                        $('.js-type').val('payment');
                        $('.js-payment-type').val('venmo');
                        $('.js-description').val('Payment');
                        break;
                    case 'chase quickpay':
                        $('.js-type').val('payment');
                        $('.js-payment-type').val('chase quickpay');
                        $('.js-description').val('Payment');
                        break;
                    case 'square cash':
                        $('.js-type').val('payment');
                        $('.js-payment-type').val('square cash');
                        $('.js-description').val('Payment');
                        break;
                    case 'check':
                        $('.js-type').val('payment');
                        $('.js-payment-type').val('check');
                        $('.js-description').val('Payment');
                        break;
                    case 'cash':
                        $('.js-type').val('payment');
                        $('.js-payment-type').val('cash');
                        $('.js-description').val('Cash to Asif at the fields');
                        break;
                    case 'charge':
                        $('.js-type').val('charge');
                        $('.js-payment-type').val('');
                        $('.js-description').val('');
                        break;
                    case 'credit':
                        $('.js-type').val('credit');
                        $('.js-payment-type').val('');
                        $('.js-description').val('');
                        break;
                }
            });

            $('.js-cycle').change(function(evt) {
                var weekOptions = {},
                    cycle,
                    cycleId = evt.target.selectedOptions.item(0).value,
                    $weekSelect = $('.js-week');

                if (cycleId > 0) {
                    cycle = cycles[cycleId-1];
                    cycle.weeks.forEach(function (week, index) {
                        weekOptions[cycle.name + '-' + week.id] = 'Wk' + (index+1) + ' - ' + moment(new Date(week.starts_at)).format('MMM D');
                    });

                    $('.js-week-group').css('opacity', 1);
                    $weekSelect.prop('disabled', false);
                } else {
                    cycles.forEach(function (cycle, index) {
                        cycle.weeks.forEach(function (week, index) {
                            if (index == 0) {
                                weekOptions[cycle.name + '-' + '00'] = 'Cycle ' + cycle.name;
                            }

                            weekOptions[cycle.name + '-' + week.id] = moment(new Date(week.starts_at)).format('MMM D');
                        });
                    });

                    $('.js-week-group').css('opacity', 0.5);
                    $weekSelect.prop('disabled', 'disabled').val('');
                }

                $weekSelect.empty()
                    .append('<option value="" disabled="disabled" selected="selected">Optional week</option>')
                    .append('<option value="0">N/A</option>');

                $.each(weekOptions, function(key,value) {
                    if(key.slice(8) == '00') {
                        $weekSelect.append($("<option></option>")
                        .attr("value", '').prop("disabled", "disabled").text(value));
                    } else {
                        $weekSelect.append($("<option></option>")
                        .attr("value", key.slice(8)).text(value));
                    }

                });

                console.log(weekOptions);
                // var weeks = {"Option 1": "value1",
                //               "Option 2": "value2",
                //               "Option 3": "value3"
                //             };
            });

            @if($currentCycle)
                $('.js-cycle').val({!! $currentCycle->id !!});
            @endif

            $('.js-cycle').trigger('change');
        })
    </script>
@stop