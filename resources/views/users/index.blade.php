@extends('layouts.default')
@section('title','FOCUS League – Users')

@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">{{ $title or "All users" }}</h4>
            <h3 class="hidden-xs hidden-sm">{{ $title or "All users" }}</h3>
            <p>See a list of all {{ $title or "users" }}.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-condensed table-bordered">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Nickname</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Birthday</th>
                            <th>Balance</th>
                            <th>Admin</th>
                        </tr>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
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
                                <td class="text-center">
                                    <a href="{{ route('transactions.create') . '?user_id=' . $user->id }}" class="btn btn-default btn-xs">Add Trans</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection