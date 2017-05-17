<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title">Sub sign up for Cycle {{ $cycle->name }}</h3>
    </div>

<?php
    $week_options = [];
    $week_already_subbing = [];
    foreach($cycle->weeks as $week) {
        $sub_deets = $week->subs->find($user->id);
        if ($edit === true)
            if ($sub->week_id === $week->id) {
                $week_options[$week->id] = $week->starts_at->toFormattedDateString();
            } elseif ($sub_deets) {
                $week_already_subbing[] = ['week' => $week, 'sub_deets' => $sub_deets];
            } else {
                $week_options[$week->id] = $week->starts_at->toFormattedDateString();
            }
        else {
            if ($sub_deets) {
                $week_already_subbing[] = ['week' => $week, 'sub_deets' => $sub_deets];
            } else {
                $week_options[$week->id] = $week->starts_at->toFormattedDateString();
            }
        }

    }
?>
    <div class="panel-body">
        @if($edit === true)
            {!! Former::vertical_open()
                ->method('PATCH')
                ->action(route('sub.update', $sub->id))
            !!}
        @else
            {!! Former::vertical_open()
                ->action(route('sub.store', $cycle->id))
            !!}
        @endif

        {!! Former::text('nickname')
            ->label('Player')
            ->addClass('form-control')
            ->placeholder($user->getNicknameOrShortname())
            ->disabled()
        !!}
        @if(count($week_already_subbing) > 0)
            <div class="text-info"><p>You are already signed up as a sub for the following weeks</p>
            <ul class="list-unstyled">
            @foreach($week_already_subbing as $week)
                <li><a href="{{ route('sub.edit', $week['sub_deets']->id) }}">{{ $week['week']->starts_at->toFormattedDateString() }}</a></li>
            @endforeach
            </ul>
            </div>
        @endif
        {!! Former::select('week')
            ->options($week_options)
            ->addClass('form-control')
            ->placeholder('Required week')
            ->required()
        !!}

        <div class="cost-stmt text-info"><p>Signing up does not guarantee a spot. We will let you know if a spot opens. Your account will be charged $10 if and when you are placed on a team.</p></div>

        {!! Former::textarea('note')
            ->label('Note')
            ->placeholder('Optional note')
        !!}
    </div>

    <div class="panel-footer">
        @if($edit === true)
            {!! Former::submit()
                ->addClass('btn btn-primary')
                ->value('Save')
            !!}
            {!! Former::close() !!}

            {{-- Form::delete(route( 'sub.destroy', $sub->id), '', ['class' => 'pull-right'],['class' => 'btn btn-danger'] ) --}}
        @else
            {!! Former::submit()
                ->addClass('btn btn-primary')
                ->value('Sign up')
            !!}
            {!! Former::close() !!}
        @endif
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready( function () {
            // For popovers on the navbar
            // $('[data-toggle="popover"]').popover();

        })
    </script>
@endpush