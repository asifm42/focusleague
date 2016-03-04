There seems to be a failed job as of {{ $timeString }}.

Job:
    {!! $job !!}

Class:
    {!! $data['class'] !!}

Data:
    {!! $data['data'] !!}

Environment:

    {{ App::environment() }}