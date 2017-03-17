There seems to be a failed job as of {{ $timeString }}.

Job:

    {!! $jobName !!}

Data:

    {!! $jsonEncodedData !!}

Exception:

    {!! $exception !!}

Environment:

    {{ App::environment() }}