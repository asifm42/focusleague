<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title">Edit Game</h3>
    </div>
    <div class="panel-body">
            {!! Former::vertical_open()
                ->method('PATCH')
                ->action(route('games.update', $game->id))
            !!}

        <h4>Cycle {{ $game->week->cycle->name }} - Week {{ $game->week->index() }}</h4>

        <div class="row">
            <div class="col-xs-12 col-md-6">
            <h5>Score</h5>
            </div>
        </div>
        <div class="row">
            @foreach($game->teams as $team)
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="{{ 'score[' . $team->id . ']' }}" class="control-label">{{ $team->name }}</label>
                        <input class="form-control" id="{{ 'score[' . $team->id . ']' }}" type="text" name="{{ 'score[' . $team->id . ']' }}" value="{{ $team->pivot->points_scored }}">
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="panel-footer">
            {!! Former::submit()
                ->addClass('btn btn-primary')
                ->value('Save')
            !!}
            {!! Former::close() !!}
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