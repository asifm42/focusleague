                <div class="panel panel-default signup-list">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ $title }} <span class="badge pull-right hidden">{{ $signups->count() }}</span></h4>
                    </div>
                    <div class="panel-body">
                    <?php
                        $showDivisions = (isset($showDivisions) && $showDivisions) ? true : false;
                    ?>
                    @include('signups.table', $data = ['signups'=>$signups, 'cycle'=>$cycle, 'showDivisions' => $showDivisions])
                    </div>
                </div>