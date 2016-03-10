<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title">Send us a message</h3>
    </div>

    <div class="panel-body">
        {!! Former::vertical_open()
            ->action(route('contact.send'))
        !!}

        {!! Former::text('name')
            ->addClass('form-control')
            ->placeholder('Required name')
            ->autofocus('autofocus')
            ->required()
        !!}
        {!! Former::text('email')
            ->addClass('form-control')
            ->placeholder('Required email')
            ->required()
        !!}
        {!! Former::textarea('message')
            ->addClass('form-control')
            ->placeholder('Required message')
            ->required()
        !!}
    </div>
    <div class="panel-footer">
        {!! Former::submit()
            ->addClass('btn btn-primary')
            ->value('Send')
        !!}
    </div>
    {!! Former::close() !!}
</div>