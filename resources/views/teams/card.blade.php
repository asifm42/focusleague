                <div class="card team-list mt-2 mb-2">
                    <div class="card-header">
                        <h6 class="card-title font-weight-bold mb-0">
                            {{ 'Team ' . ucwords($team->name) }}
                            {!! $team->divisionIcon() !!}
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @php
                            $showDivisions = (isset($showDivisions) && $showDivisions) ? true : false;
                        @endphp
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
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped">
                                    <tr>
                                        @if(isset($showDivisions) && $showDivisions === true)
                                            <th class="text-center" colspan=3></th>
                                        @else
                                            <th class="text-center" colspan=1></th>
                                        @endif
                                        @foreach($cycle->weeks as $key=>$week)
                                            <th class="text-center">Wk{{ $key+1 }}</th>
                                        @endforeach
                                        @if(auth()->user()->isAdmin())
                                            <th class="text-center"></th>
                                        @endif
                                    </tr>
                                    <tr class="info">
                                        @if(isset($showDivisions) && $showDivisions === true)
                                            <th class="text-center" colspan=3><i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>&nbsp;Total</th>
                                        @else
                                            <th class="text-center" colspan=1><i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>&nbsp;Total</th>
                                        @endif
                                        <?php
                                            $weekCount = [];
                                            foreach($cycle->weeks as $key=>$week) {
                                                $malePlayerCount = $malePlayers->filter(function ($value, $key) use ($week){
                                                            return $value->user->isAvailable($week->id);
                                                        })->count();
                                                $femalePlayerCount = $femalePlayers->filter(function ($value, $key) use ($week){
                                                            return $value->user->isAvailable($week->id);
                                                        })->count();
                                                $subCount = $subs->filter(function ($value, $key) use ($week){
                                                            return $value->week_id === $week->id;
                                                        })->count();
                                                $weekCount[] = $malePlayerCount + $femalePlayerCount + $subCount;
                                            }
                                        ?>
                                        @foreach($weekCount as $count)
                                            <th class="text-center">{{ $count }}</th>
                                        @endforeach
                                        @if(auth()->user()->isAdmin())
                                            <th class="text-center"></th>
                                        @endif
                                    </tr>
                                </table>
                            </div>
                        @else
                            @include('teams.table', $data = ['players'=>$players, 'subs'=>$subs, 'cycle'=>$cycle, 'team'=>$team])
                        @endif
                    </div>
                </div>