<form accept-charset="utf-8" class="form-vertical" method="POST"
    @if ($edit === true)
        action="{{ route('teams.update', $team->id) }}"
    @else
        action="{{ route('teams.store') }}"
        @php
            $team = new \App\Models\Team;
        @endphp
    @endif
    >

    @if ($edit === true)
        {!! method_field('patch') !!}
    @endif

    <div class="card">
        <div class="card-body">
            <div class="form-group {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="required">Team Name</label>

                <input name="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" id="name" aria-describedby="nameHelp" placeholder="Required team name" required value={{ old('name', $team->name) }}>

                <div id="nameFeedback" class="invalid-feedback">{{ $errors->has('name') ? $errors->first('name') : '' }}</div>
            </div>

            @php
                $divOptions = ['mens' => 'Mens', 'mixed' => 'Mixed', 'womens' => 'Womens'];
            @endphp

            <div class="form-group {{ $errors->has('division') ? 'has-danger' : ''}}">
                <label for="division" class="required">Division</label>

                <select name="division" class="form-control {{ $errors->has('division') ? 'is-invalid' : ''}}" id="division" aria-describedby="divisionHelp" placeholder="Required division" required>
                    <option disabled {{ old('division') ? '' : 'selected' }}>Required division</option>
                    @foreach($divOptions as $key => $option)
                    <option value="{{ $key }}" {{ old('division', $team->division) == $key ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>

                <div id="divisionFeedback" class="invalid-feedback">{{ $errors->has('division') ? $errors->first('division') : '' }}</div>
            </div>

            <input class="form-control" type="hidden" name="cycle_id" value="{{ $cycle->id }}">

        </div>

    </div>
    @if($edit === true)
        <div class="row mt-3">
            <div class="col">
                    <input class="btn btn btn-primary" type="submit" value="Save" >
                    {{ csrf_field() }}
                </form>
            </div>
            <div class="col">
                <form accept-charset="utf-8" class="float-right" method="POST" action="{{ route('teams.destroy', $team->id) }}" >
                    {!! method_field('delete') !!}
                    <input class="btn btn btn-danger" type="submit" value="Delete" >

                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    @else
            <input class="btn btn btn-primary btn-block mt-3" type="submit" value="Save" >
            {{ csrf_field() }}
        </form>
    @endif