@component('mail::message')
{{ $slot }}

<!-- Salutation -->
@if (! empty($salutation))
{{ $salutation }}
@else
–The FOCUS League team (Asif &amp; Nicky)
@endif

@if (isset($unsubscribe))
    @slot('unsubscribe')
        {{ $unsubscribe }}
    @endslot
@endif
@endcomponent