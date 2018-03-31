<form accept-charset="utf-8" class="form-vertical" method="POST"
    @if ($edit === true)
        action="{{ route('sub.update', $sub->id) }}"
    @else
        action="{{ route('sub.store', $cycle->id) }}"
    @endif
    >

    @if ($edit === true)
        {!! method_field('patch') !!}
    @endif

@php
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
@endphp
    <div class="row justify-content-center">
        <h4 class="text-center w-100">
            Cycle {{ $cycle->name }}
        </h4>
        <h4 class="text-center w-100">
            Sub sign-up
        </h4>
    </div>
    <div class="row justify-content-center">
        @if ($edit === true)
            <span class="badge badge-warning">Editing</span>
        @endif
    </div>
    <div class="card mt-2 mb-4">

        <div class="card-body">
                <div class="form-group">
                    <label for="nickname">Player</label>
                    <input name="nickname" type="text" class="form-control" id="nickname" aria-describedby="nicknameHelp" placeholder={{ $user->getNicknameOrShortname() }} value={{ $user->getNicknameOrShortname() }} disabled>
                </div>

            @if(count($week_already_subbing) > 0)
                <div class="text-info"><p>You are already signed up as a sub for the following weeks</p>
                <ul class="list-unstyled">
                @foreach($week_already_subbing as $week)
                    <li><a href="{{ route('sub.edit', $week['sub_deets']->id) }}">{{ $week['week']->starts_at->toFormattedDateString() }}</a></li>
                @endforeach
                </ul>
                </div>
            @endif


            <div class="form-group {{ $errors->has('week') ? 'has-danger' : ''}}">
                <label for="week" class="required">Week</label>
                <select name="week" class="form-control {{ $errors->has('week') ? 'is-invalid' : ''}}" id="week" aria-describedby="weekHelp" placeholder="Required week" required>
                    <option disabled {{ old('week') ? '' : 'selected' }}>Required week</option>
                    @foreach($week_options as $key => $option)
                        @if ($edit === true)
                            <option value=$key {{ $sub && $sub->week_id == $key ? 'selected' : '' }}>{{ $option }} </option>
                        @else
                            <option value=$key>{{ $option }} </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="cost-stmt text-info"><p>Signing up does not guarantee a spot. We will let you know if a spot opens. Your account will be charged $10 if and when you are placed on a team.</p></div>

            <div class="form-group {{ $errors->has('note') ? 'has-danger' : ''}}">
              <label for="note">Note</label>
                    @if ($edit === true)
                        <textarea class="form-control" id="note" rows="4" placeholder="Optional note">{{ old('note', $sub->note) }}</textarea>
                    @else
                        <textarea class="form-control" id="note" rows="4" placeholder="Optional note">{{ old('note', '') }}</textarea>
                    @endif

            </div>
        </div>
    </div>

        @if($edit === true)
        <div class="row mt-3">
            <div class="col">
                <form accept-charset="utf-8"method="POST" action="{{ route('sub.destroy', $sub->id) }}" >
                    {!! method_field('delete') !!}
                    <input class="btn btn btn-danger btn-block" type="submit" value="Delete" >

                    {{ csrf_field() }}
                </form>
            </div>
            <div class="col">
                    <input class="btn btn btn-primary btn-block" type="submit" value="Save" >
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
        @else

                <input class="btn btn btn-primary btn-block mt-3" type="submit" value="Sign up" >
                {{ csrf_field() }}
            </form>
        @endif








@push('scripts')
    <script>
        $(document).ready( function () {
            // For popovers on the navbar
            // $('[data-toggle="popover"]').popover();

        })
    </script>
@endpush