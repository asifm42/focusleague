@extends('layouts.default')
@section('title','FOCUS League – Team Builder')

@section('styles')


@stop

@section('content')
    <team-builder :cycleid="{{ $cycle->id }}" :cycle-payload="{{ $cycle->toJson() }}"></team-builder>
@endsection



@push('scripts')
    <script>
        $('document').ready(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $('body').popover({
                selector: '[data-toggle="popover"]',
                template:'<div class="popover"><div class="btn-group popover-content" role="group" aria-label="team-selection"></div><div class="arrow"></div></div>',
                html:true,
                trigger: 'focus'
            });

            $('.js-publish-teams').click(function() {
                let html = '<h5 class="text-center">Captains List</h4><ul class="list-unstyled">';
                axios.get('../../api/cycles/' + {{$cycle->id}})
                    .then(response => {
                        let cycle = response.data;

                        for (let team of cycle.teams) {
                            html += '<li style="border-bottom:solid 1px #ccc; margin-top:5px;"><strong>Team ' + team.name + '</strong></li>';
                            if (_.size(team.captains) > 0) {
                                for (let captain of team.captains) {
                                    html += "<li>"+ captain.user.name + "<br></li>";
                                }
                            } else {
                                html += '<li class="text-danger">No captains selected!</li>';
                            }
                        }
                        html += "</ul>";
                        $('.js-captains').html(html);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            })
        });
    </script>
@endpush

@section('modals')
<div class="modal fade" id="publishTeamsModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="publishTeamsModalLabel">Publish Teams</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="js-captains">
            <div class="text-center">
                <h5>Captains List</h5>
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <p class="text-right">Are you sure that you are ready to publish teams?</p>
      </div>
      <div class="modal-footer">
            <a href="{{ route('cycle.teams.publish', $cycle->id) }}" class="btn btn-primary">Publish teams</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="announceTeamsModal" tabindex="-1" role="dialog">
  <div class="modal-dialog role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="announceTeamsModalLabel">Email Team Announcement</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p>Are you sure that you are ready to announce teams via email?</p>
      </div>
      <div class="modal-footer">
        <a href="{{ route('cycle.teams.announce', $cycle->id) }}" class="btn btn-primary ">Email Team Announcement</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop