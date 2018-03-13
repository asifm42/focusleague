                <div class="card signup-list mt-2 mb-2">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ $title }} <span class="badge pull-right hidden">{{ $signups->count() }}</span></h4>
                    </div>
                    <div class="card-body p-0">
                    <?php
                        $showDivisions = (isset($showDivisions) && $showDivisions) ? true : false;
                    ?>
                    @include('signups.table', $data = ['signups'=>$signups, 'cycle'=>$cycle, 'showDivisions' => $showDivisions])
                    </div>
                </div>