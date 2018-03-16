<form accept-charset="utf-8" class="form-vertical" method="POST"
    @if ($edit === true)
        action="{{ route('transactions.update', $transaction->id) }}"
    @else
        action="{{ route('transactions.store') }}"
    @endif
    >

    @if ($edit === true)
        {!! method_field('patch') !!}
        @php
            $playerName = $transaction->user->name;
            $date = $transaction->date->format('Y-m-d');
            $transactionUserId = $transaction->user->id;
            $transactionCycleId = $transaction->cycle->id;
            $transactionWeekId = $transaction->week ? $transaction->week->id : '';
            $transaction_type = $transaction->type;
        @endphp
    @else
        @php
            $transaction = new \App\Models\Transaction;
            $playerName = "";
            $date = date("Y-m-d");
            $transactionUserId = $userId ? $userId : "";// $transaction->user->id;
            $transactionCycleId = "";// $transaction->cycle->id;
            $transactionWeekId = "";// $transaction->week->id;
            $transaction_type = "";
        @endphp
    @endif

    @php
        $transactionTypes = [
            'paypal' => 'Paypal payment',
            'venmo' => 'Venmo payment',
            'chase quickpay' => 'Chase Quickpay payment',
            'square cash' => 'Square Cash payment',
            'check' => 'Check payment',
            'cash' => 'Cash payment',
            'charge' => 'Charge',
            'credit' => 'Credit',
        ];

    @endphp

<div class="card">
    <div class="card-body">
            <div class="form-group {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="required">Player name</label>
                <input name="name" type="text" class="form-control users-typeahead-js {{ $errors->has('name') ? 'is-invalid' : ''}}" id="name" aria-describedby="nameHelp" placeholder="Required player name" required value={{ old('name', $playerName) }}>
                <small id="nameHelp" class="form-text text-muted">Please provide player's name.</small>
                <div id="nameFeedback" class="invalid-feedback">{{ $errors->has('name') ? $errors->first('name') : '' }}</div>
            </div>

            <input class="form-control" required="" type="hidden" name="user_id" value="{{ $transactionUserId }}">

        <div class="row">
            <div class="col-12 col-md-5">
                <div class="form-group  {{ $errors->has('date') ? 'has-danger' : ''}}">
                    <label for="date" class="required">Transaction Date</label>
                    <input name="date" type="date" class="form-control {{ $errors->has('date') ? 'is-invalid' : ''}}" id="date" aria-describedby="dateHelp" placeholder="Optional date" value={{ old('date', $date) }}>
                    <small id="dateHelp" class="form-text text-muted">MM/DD/YYYY</small>
                    <div id="dateFeedback" class="invalid-feedback">{{ $errors->has('date') ? $errors->first('date') : '' }}</div>
                </div>
            </div>

            <div class="col-5 col-md-3">
                <div class="form-group js-cycle-group {{ $errors->has('cycle_id') ? 'has-danger' : ''}}">
                    <label for="cycle_id">Cycle</label>
                    <select name="cycle_id" class="form-control js-cycle {{ $errors->has('cycle_id') ? 'is-invalid' : ''}}" id="cycle_id" aria-describedby="cycleHelp" placeholder="Optional cycle">
                        <option disabled  {{ old('cycle_id') ? '' : 'selected' }}>Optional cycle</option>
                        <option value="0">N/A</option>
                        @foreach($cycles->sortByDesc('name') as $cycle)
                            <option value="{{ $cycle->id }}" {{ $cycle->id == $transactionCycleId ? 'selected' : '' }}>{{ $cycle->name }}</option>
                        @endforeach
                    </select>
                    <div id="cycleFeedback" class="invalid-feedback">{{ $errors->has('cycle_id') ? $errors->first('cycle_id') : '' }}</div>
                </div>
            </div>

            <div class="col-7 col-md-4">
                <div class="form-group {{ $errors->has('week_id') ? 'has-danger' : ''}}">
                    <label for="week_id">Week</label>
                    <select name="week_id" class="form-control js-week {{ $errors->has('week_id') ? 'is-invalid' : ''}}" id="week_id" aria-describedby="weekHelp" placeholder="Optional week">
                        <option disabled  {{ old('week_id') ? '' : 'selected' }}>Optional week</option>
                        <option value="0">N/A</option>
                        @foreach($weeks->sortByDesc('starts_at') as $week)
                            <option value="{{ $week->id }}" {{ $week->id == $transactionWeekId ? 'selected' : '' }}>{{ $week->name }}</option>
                        @endforeach
                    </select>
                    <div id="weekFeedback" class="invalid-feedback">{{ $errors->has('week_id') ? $errors->first('week_id') : '' }}</div>
                </div>
            </div>




        </div>
        <div class="row">

            <div class="col-8 col-md-8">
                <div class="form-group  {{ $errors->has('transaction_type') ? 'has-danger' : ''}}">
                    <label for="transaction_type" class="required">Type</label>
                    <select name="transaction_type" class="form-control js-transaction-type {{ $errors->has('transaction_type') ? 'is-invalid' : ''}}" id="transaction_type" aria-describedby="transaction_typeHelp" placeholder="Required type" required>
                        <option disabled  {{ old('transaction_type') ? '' : 'selected' }}>Required type</option>
                        @foreach($transactionTypes as $key => $type)
                            <option value="{{ $key }}" {{ $transaction_type == $key ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    <div id="transaction_typeFeedback" class="invalid-feedback">{{ $errors->has('transaction_type') ? $errors->first('transaction_type') : '' }}</div>
                </div>
                <input class="form-control js-type" required="" type="hidden" name="type" value="">
                <input class="form-control js-payment-type" required="" type="hidden" name="payment_type" value="">
            </div>

            <div class="col-4 col-md-4">
                <div class="form-group {{ $errors->has('amount') ? 'has-danger' : ''}}">
                    <label for="amount" class="required">Amount</label>
                    <input name="amount" type="text" class="form-control {{ $errors->has('amount') ? 'is-invalid' : ''}}" id="amount" aria-describedby="amountHelp" placeholder="Required Amount" required value={{ old('amount', $transaction->amountInDollars) }}>
                    <div id="amountFeedback" class="invalid-feedback">{{ $errors->has('amount') ? $errors->first('amount') : '' }}</div>
                </div>
            </div>
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control js-description" id="description"  placeholder="Optional description"></textarea>
        </div>
    </div>
</div>

@if($edit === true)
<div class="row">
    <div class="col-6">
        <input class="btn btn btn-primary btn-block mt-3" type="submit" value="Save">

        {{ csrf_field() }}
    </form>
    </div>
    <div class="col-6">
        <form accept-charset="utf-8" class="float-right" method="POST" action="{{ route('transactions.update', $transaction->id) }}">
            {!! method_field('delete') !!}

            <button class="btn btn btn-danger mt-3" type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>

            {{ csrf_field() }}
        </form>
    </div>
</div>

@else
    <div class="row">
        <div class="col">
            <input class="btn btn btn-primary btn-block mt-3" type="submit" value="Create">

            {{ csrf_field() }}
        </div>
    </div>
    </form>


@endif

@push('scripts')
    <script>
        var cycles = {!! $cycles !!},
            weeks = {!! $weeks !!};

        $(document).ready( function () {
            var users = new Bloodhound({
                local:{!! $names !!},
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name')
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
                        notFound: [
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
                $('.users-typeahead-js').typeahead('open');
                $('.users-typeahead-js').typeahead('close');
                $('.users-typeahead-js').trigger('typeahead:change');
            @endif

            @if (isset($balance) && $balance > 0)
                $('input[name = amount]').val({!! $balance !!});
                console.log('balance', {!! $balance !!});
                $('input[name = amount]').focus();
                $('input[name = transaction_type]').focus();
            @endif

            $('.js-transaction-type').change(function(evt) {
                selectedValue = evt.target.selectedOptions.item(0).value;

                switch (selectedValue) {
                    case 'paypal':
                        $('.js-type').val('payment');
                        $('.js-payment-type').val('paypal');
                        $('.js-description').val('id: ');
                        break;
                    case 'venmo':
                        $('.js-type').val('payment');
                        $('.js-payment-type').val('venmo');
                        $('.js-description').val('');
                        break;
                    case 'chase quickpay':
                        $('.js-type').val('payment');
                        $('.js-payment-type').val('chase quickpay');
                        $('.js-description').val('');
                        break;
                    case 'square cash':
                        $('.js-type').val('payment');
                        $('.js-payment-type').val('square cash');
                        $('.js-description').val('');
                        break;
                    case 'check':
                        $('.js-type').val('payment');
                        $('.js-payment-type').val('check');
                        $('.js-description').val('');
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

            $('.js-transaction-type').trigger('change');

            $('.js-cycle').change(function(evt) {
                var weekOptions = {},
                    cycle,
                    cycleId = evt.target.selectedOptions.item(0).value,
                    $weekSelect = $('.js-week');

                if (cycleId > 0) {
                    cycle = cycles[cycleId-1];
                    cycle.weeks.forEach(function (week, index) {
                        weekOptions[cycle.name + '-' + week.id] = 'Wk' + (index+1) + ' - ' + moment(week.starts_at).format('MMM D');
                    });

                    $('.js-week-group').css('opacity', 1);
                    $weekSelect.prop('disabled', false);
                } else {
                    cycles.forEach(function (cycle, index) {
                        cycle.weeks.forEach(function (week, index) {
                            if (index == 0) {
                                weekOptions[cycle.name + '-' + '00'] = 'Cycle ' + cycle.name;
                            }

                            weekOptions[cycle.name + '-' + week.id] = moment(week.starts_at).format('MMM D');
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
            });

            @if(isset($currentCycle))
                $('.js-cycle').val({!! $currentCycle->id !!});
                $('.js-cycle').trigger('change');
            @elseif(isset($transaction))
                @if(isset($transaction->cycle) && !is_null($transaction->cycle))
                    $('.js-cycle').val({!! $transaction->cycle->id !!});
                    $('.js-cycle').trigger('change');
                @endif
                @if(isset($transaction->week) && !is_null($transaction->week))
                    $('.js-week').val({!! $transaction->week->id !!});
                    $('.js-week').trigger('change');
                @endif
            @else
                $('.js-cycle').trigger('change');
            @endif
        })
    </script>
@endpush