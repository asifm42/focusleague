<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading_{{ $id }}">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#faq_list" href="#faq_{{ $id }}" aria-expanded="{{ $expanded or 'false' }}" aria-controls="faq_{{ $id }}">
                {{ $question }}
            </a>
        </h4>
    </div>
    <div id="faq_{{ $id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_{{ $id }}">
        <div class="panel-body">
           {{ $answer }}
        </div>
    </div>
</div>