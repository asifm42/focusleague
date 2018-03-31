<form accept-charset="utf-8" class="form-vertical" method="POST"
    @if ($edit === true)
        action="{{ route('subs.updateTeamPlacement', $sub->id) }}"
    @else
        action="{{ route('subs.placeOnATeam', $sub->id) }}"
    @endif
    >

    @if ($edit === true)
        {!! method_field('patch') !!}
    @endif

<div class="card">

@php
    $team_options = [];
    foreach($cycle_teams as $team) {
        $team_options[$team->id] = $team->name;
    }
@endphp
    <div class="card-body">
        <h4 class="text-center">Cycle {{ $cycle->name }} - Week {{ $sub->week->index() }}</h4>
        <div class="form-group">
            <label for="nickname" class="required">Player</label>
            <input name="nickname" type="text" class="form-control" id="nickname" aria-describedby="nicknameHelp" readonly required value={{ $user->getNicknameOrShortname() }}>
        </div>

        <div class="form-group {{ $errors->has('team_id') ? 'has-danger' : ''}}">
            <label for="team_id" class="required">Team</label>
            <select name="team_id" class="form-control {{ $errors->has('team_id') ? 'is-invalid' : ''}}" id="team_id" aria-describedby="team_idHelp" placeholder="Required team_id" required>
                <option disabled {{ old('team_id') ? '' : 'selected' }}>Required team</option>
                @foreach($team_options as $key => $option)
                    <option value="{{ $key }}" {{ old('team_id') == $key || $sub->team && $sub->team->id == $key ? 'selected' : '' }}>{{ $option }}</option>
                 @endforeach
            </select>
            <div id="team_idFeedback" class="invalid-feedback">{{ $errors->has('team_id') ? $errors->first('team_id') : '' }}</div>
        </div>
    </div>
</div>
    <input class="btn btn btn-primary btn-block mt-3" type="submit" value="Save" >
    {{ csrf_field() }}
</form>
            @if ($sub->team_id)
                <a href="{{route( 'subs.deleteTeamPlacement', $sub->id)}}" class='btn btn-danger btn-block mt-3'>Remove from {{($sub) ? $sub->team->name : 'team'}}</a>
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