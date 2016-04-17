                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ $title }} <span class="badge pull-right">{{ $players->count() }}</span></h4>
                    </div>
                    <div class="panel-body">
                    <?php
                        $showDivisions = (isset($showDivisions) && $showDivisions) ? true : false;
                    ?>
                        @if(strtolower($team->division) === 'mixed')
                            <?php
                                $malePlayers = $players->filter(function ($value, $key) {
                                    return strtolower($value->user->gender) == "male";
                                });
                                $femalePlayers = $players->filter(function ($value, $key) {
                                    return strtolower($value->user->gender) == "female";
                                });
                                $maleSubs = $subs->filter(function ($value, $key) {
                                    return strtolower($value->user->gender) == "male";
                                });
                                $femaleSubs = $subs->filter(function ($value, $key) {
                                    return strtolower($value->user->gender) == "female";
                                });
                            ?>
                            @include('teams.table', $data = ['players'=>$malePlayers->load('user'), 'subs'=>$maleSubs, 'cycle'=>$cycle, 'team'=>$team])
                            @include('teams.table', $data = ['players'=>$femalePlayers->load('user'), 'subs'=>$femaleSubs, 'cycle'=>$cycle, 'team'=>$team])
                        @else
                            @include('teams.table', $data = ['players'=>$players, 'subs'=>$subs, 'cycle'=>$cycle, 'team'=>$team])
                        @endif
                        <p><i class="fa fa-star text-warning"></i> = captain</p>
                    </div>
                </div>