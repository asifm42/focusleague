An exception occured at {{ $timeString }}.

Environment:

    {{ App::environment() }}

Exception Type:

    {{ $exception['class'] }}

Authenticated User:

@if (! empty($user))
    {{ 'ID: ' . $user['id'] }}
    {{ 'Name: ' . $user['name'] }}
@else
    No authenticated user.
@endif

Request URL:

    {{ $request['fullUrl'] }}

Request IP(s):

@forelse ($request['ips'] as $ip)
    {{ $ip }}
@empty
    No IP addresses
@endforelse

Message:

    {{ $exception['message'] }}

Code:

    {{ $exception['code'] }}

Line #:

    {{ $exception['line'] }}

File:

{{ $exception['file'] }}

Stack Trace:

{!! $exception['stackTrace'] !!}
