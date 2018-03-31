<div class="card signup-list mt-2 mb-2">
    <div class="card-header">
        <span class="badge badge-dark float-right">{{ $signups->count() }}</span>
        <h6 class="card-title font-weight-bold m-0">{{ $title }} </h6>
    </div>
    <div class="card-body p-0">
        @php
            $showDivisions = (isset($showDivisions) && $showDivisions) ? true : false;
        @endphp
        @include('signups.table', $data = ['signups'=>$signups, 'cycle'=>$cycle, 'showDivisions' => $showDivisions])
    </div>
</div>