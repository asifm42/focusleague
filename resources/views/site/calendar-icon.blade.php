@if(!isset($class))
    @php
        $class = "";
    @endphp
@endif

@if(isset($date))
    @php
        if (is_string($date)) {
            $date = new Carbon\Carbon($date);
        }

        if (! (get_class($date) == 'Carbon\Carbon')) {
            $date = new Carbon\Carbon($date);
        }

        $datetime = $date->format('Y-m-d');
        $dayName = $date->format('l');
        $month = $date->format('F');
        $dayNumber = $date->format('j');
    @endphp
@endif

@if(isset($color))
    <time datetime="{{ $datetime }}" class="icon {{ $class }} {{ $color == 'red' ? 'border-danger' : '' }}">
        <em style="color: {{ $color }}">{{ $dayName }}</em>
        <strong style="background-color: {{ $color }}">{{ $month }}</strong>
        <span>{{ $dayNumber }}</span>
    </time>
@else
    <time datetime="{{ $datetime }}" class="icon {{ $class }}">
        <em>{{ $dayName }}</em>
        <strong>{{ $month }}</strong>
        <span>{{ $dayNumber }}</span>
    </time>
@endif