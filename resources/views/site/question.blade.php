@if(isset($anchor))
<div id={{ $anchor }}>
@endif
<div class="mb-3">
    <div role="tab" id="heading_{{ $id }}">
        <h6>
            <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_{{ $id }}" aria-expanded="{{ $expanded or 'false' }}" aria-controls="faq_{{ $id }}">
                {{ $question }}
            </a>
        </h6>
    </div>
    <div id="faq_{{ $id }}" class="collapse" role="tabpanel" aria-labelledby="heading_{{ $id }}">
        <div>
           {{ $answer }}
        </div>
    </div>
</div>
@if(isset($anchor))
</div>
@endif