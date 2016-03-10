There seems to be a failed job as of {{ $timeString }}.

Job:

    {!! $jobName !!}

Data:

    {!! $jsonEncodedData !!}

Environment:

    {{ App::environment() }}