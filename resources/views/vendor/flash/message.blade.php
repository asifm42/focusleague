@if (session()->has('flash_notification.message'))
    @if (session()->has('flash_notification.overlay'))
        @include('flash::modal', [
            'modalClass'    => 'flash-modal',
            'title'         => session('flash_notification.title'),
            'body'          => session('flash_notification.message')
        ])
    @else
        <div class="alert alert-{{ session()->get('flash_notification.level')}} fade in ">
            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-hidden="true">&times;</button>
            {!! session('flash_notification.message') !!}
        </div>
    @endif
@endif