                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ $title }} <span class="badge pull-right">{{ $players->count() }}</span></h4>
                    </div>
                    <div class="panel-body">
                    <?php
                        $showDivisions = (isset($showDivisions) && $showDivisions) ? true : false;
                    ?>
                        @include('teams.table', $data = ['players'=>$players, 'cycle'=>$cycle, 'team'=>$team])
                        <p><i class="fa fa-space-shuttle text-warning"></i> = captain</p>
                    </div>
                </div>