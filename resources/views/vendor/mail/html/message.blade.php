@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{-- config('app.name') --}}
            <img alt="FOCUS League" src="{{isset($message) ? $message->embed(public_path('assets/img/logo.png')) : url('assets/img/logo.png') }}" height="68" width="190" style="margin:10px; height:68px; width:190px;"/>
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @if (isset($subcopy))
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endif

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            &copy; {{ date('Y') }} <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
