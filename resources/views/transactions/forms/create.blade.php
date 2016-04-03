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
        {!! Former::text('date')
            ->name('date')
            ->label('Transaction Date')
            ->id('trans_date_picker-js')
            ->addClass('form-control')
            ->placeholder('Optional date')
            ->help('MM/DD/YYYY')
        !!}
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
        {!! Former::select('cycle_id')
            ->label('Cycle')
            ->addClass('form-control')
            ->placeholder('Optional cycle id')
            ->options([ 0 => 'N/A'])
            ->fromQuery($cycles, 'name', 'id')
        !!}
        {!! Former::select('week_id')
            ->label('Week')
            ->addClass('form-control')
            ->placeholder('Optional week id')
            ->options([ 0 => 'N/A'])
            ->fromQuery($weeks, 'starts_at', 'id')
        !!}
        {!! Former::select('type')
            ->label('Transaction Type')
            ->addClass('form-control')
            ->options(['charge' => 'Charge', 'payment' => 'Payment', 'credit' => 'Credit',])
            ->placeholder('Required type')
            ->required()
        !!}
        {!! Former::select('payment_type')
            ->addClass('form-control')
            ->options(['paypal' => 'Paypal', 'chase quickpay' => 'Chase Quickpay', 'square cash' => 'Square Cash', 'check' => 'Check', 'cash' => 'Cash',])
            ->placeholder('Optional payment type')
            ->help('Required if type is payment')
        !!}
        {!! Former::textarea('description')
            ->addClass('form-control')
            ->placeholder('Required description')
            ->required()
        !!}
        {!! Former::text('amount')
            ->addClass('form-control')
            ->placeholder('Required amount')
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

            {!! Form::delete(route( 'transactions.destroy', $transaction->id), '', ['class' => 'pull-right'],['class' => 'btn btn-danger'] ) !!}
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
        $(document).ready( function () {
            var users = new Bloodhound({
                local:{!! $names !!},
              // local: ['Asif Johnson', 'Asif Jason', 'Mask'],
    // local: [{ val: 'one', name:'asif' }, { val: 'two', name: 'chase' }],
    // local: [{ id: 1, name: 'asif johnson', val: 'asif' }, { id: 2, name: 'asif jason', val:'jason' }, { id: 3, name: 'Mask', val:'mask' }],
    // identify: function(obj) { return obj.id; },
              queryTokenizer: Bloodhound.tokenizers.whitespace,
              datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name')
            });
            $(function () {
                $('#trans_date_picker-js').datetimepicker({
                    format: 'MM/DD/YYYY',
                });
            });

            $('.users-typeahead-js').typeahead({
                minLength: 1,
                highlight: true,
                hint:true
            },
            {
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
            });

            @if(isset($typeahead_name))
                $('.users-typeahead-js').typeahead('val', '{!! $typeahead_name !!}');
            @endif
        })
    </script>
@stop