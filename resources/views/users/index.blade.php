@extends('layouts.default')
@section('title','FOCUS League')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center">All users</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {{-- <div class="table-responsive"> --}}
                    <table class="table dt-responsive no-wrap table-striped table-sm table-bordered focus-users-table">
                        <thead>
                            <tr>
                                <th><span class="d-none">Id</span></th>
                                <th>Name</th>
                                <th><span class="d-sm-none"><small>Nickname</small></span><span class="d-none d-sm-block">Nickname</span></th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Birthday</th>
                                <th>Balance</th>
                            @if($currentCycle)
                                <th>Team</th>
                            @endif
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center">{{ $user->id }}</td>
                                    <td>
                                        <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
                                        @if(auth()->user()->id !== $user->id)
                                            <a href="{{ route('users.impersonate', $user->id) }}" class="pull-right text-muted" data-trigger="hover focus" data-toggle="tooltip" data-placement="top" title="Impersonate user">
                                                <i class="fa fa-fw fa-user-secret"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>{!! $user->nickname ? $user->nickname : '<em>null</em>' !!}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->cell_number }}</td>
                                    <td>{{ $user->gender }}</td>
                                    <td>{{ $user->birthday->toFormattedDateString() }}</td>
                                    <td class="text-right"><a href="{{ route('users.balance', $user->id) }}">{{ $user->getBalanceString() }}</a></td>

                                    @if($currentCycle && $currentCycle->signupsOnATeam()->contains($user))
                                        <td>{{ App\Models\Team::find($currentCycle->signupsOnATeam()->find($user)->pivot->team_id)->name }}</td>
                                    @else($currentCycle)
                                        <td>n/a</td>
                                    @endif
                                    <td class="text-center">
                                        <a href="{{ route('transactions.create') . '?user_id=' . $user->id }}" class="btn btn-default btn-xs">Add Trans</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            {{-- </div> --}}
        </div>
    </div>
@endsection
@push('scripts')
  <script>
    $(document).ready(function(){

      $('.focus-users-table').DataTable({
        "language": {
          "info": "Showing _START_ to _END_ of _TOTAL_ users."
        },
        "paging":    false,
        "searching": true,
      });

    });
  </script>
@endpush