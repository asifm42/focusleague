@extends('layouts.default')
@section('title','FOCUS League – Users')

@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">All users</h4>
            <h3 class="hidden-xs hidden-sm">All users</h3>
            <p>See a list of all users.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
            <table class="table table-striped table-responsive table-condensed table-bordered">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Nickname</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Birthday</th>
                    <th>Balance</th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
                        <td>{!! $user->nickname ? $user->nickname : '<em>null</em>' !!}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->cell_number }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>{{ $user->birthday }}</td>
                        <td class="text-right"><a href="{{ route('balance.details', $user->id) }}">{{ $user->getBalanceString() }}</a></td>
                    </tr>
                @endforeach
{{--                 <tr>
                    <tr>
                        @if ($balance < 0 )
                            <td colspan="6" class="text-right">Credit</td>
                            <td class="text-right text-primary">${{ $balance }}
                        @elseif ($balance === 0 )
                            <td colspan="6" class="text-right">Balance</td>
                            <td class="text-right">${{ $balance }}
                        @else
                            <td colspan="6" class="text-right">Amount owed</td>
                            <td class="text-right text-danger">${{ $balance }}
                        @endif
                        @if (auth()->user()->isAdmin())
                            <td></td>
                        @endif
                    </tr>
                </tr> --}}
            </table>
            </div>
        </div>
    </div>
@endsection