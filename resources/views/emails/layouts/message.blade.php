@component('mail::message')
{{-- Greeting --}}
@if (isset($user))
Hi {{ title_case($user->getNicknameOrFirstName()) }},
@else
Hi FOCUS Leaguer,
@endif

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