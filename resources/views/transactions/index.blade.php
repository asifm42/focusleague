@extends('layouts.default')
@section('title','FOCUS League – Balance Details')

@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Account Balance Details</h4>
            <h3 class="hidden-xs hidden-sm">Account Balance Details</h3>
            <p>See a list of your transactions.</p>
        </div>
    </div>
    <div class="container">
        @if (auth()->user()->isAdmin())
            <div class="row">
                <div class="col-xs-12 col-md-8">
                        <h5>
                            <a href="{{ route('users.show', $user->id) }}">{{ $user->name }} ({{ $user->getNicknameOrShortname() }})</a>
                            <a href="{{ route('transactions.create') . '?user_id=' . $user->id }}" class="btn btn-default btn-xs pull-right">Add Transaction</a>
                        </h5>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <h5>
                    @if ($balance < 0 )
                        Credit: <span class="text-primary">${{ $balance }}</span>
                    @elseif ($balance == 0 )
                        Balance: <span>${{ $balance }}</span>
                    @else
                        Amount owed: <span class="text-danger">${{ $balance }}</span>
                    @endif
                </h5>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class = "table-responsive">
                    <table class="table table-striped table-condensed table-bordered focus-transactions-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Cycle</th>
                                <th>Week</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Method</th>
                                <th class="text-right">Amount</th>
                                @if (auth()->user()->isAdmin())
                                    <th>Admin</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->cycle ? $transaction->cycle->name : 'N/A'}}</td>
                                    <td>{{ $transaction->week ? $transaction->week->starts_at->toFormattedDateString() : 'N/A'}}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ ucwords($transaction->type) }}</td>
                                    <td>{{ $transaction->payment_type ? ucwords($transaction->payment_type) : 'N/A' }}</td>
                                    @if ($transaction->type === 'payment' || $transaction->type === 'credit')
                                        <td class="text-right">-${{ number_format($transaction->amount, 2, '.', '') }}</td>
                                    @else
                                        <td class="text-right text-danger">${{ number_format($transaction->amount, 2, '.', '') }}</td>
                                    @endif
                                    @if (auth()->user()->isAdmin())
                                        <td class="text-center">
                                            <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-default btn-xs">Edit</a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if (auth()->user()->isAdmin())
            <div class="col-xs-12 col-md-8">
                <h5 class="pull-right">
                    @if ($balance < 0 )
                        Credit: <span class="text-primary">${{ $balance }}</span>
                    @elseif ($balance == 0 )
                        Balance: <span>${{ $balance }}</span>
                    @else
                        Amount owed: <span class="text-danger">${{ $balance }}</span>
                    @endif
                </h5>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-8">
                        <h5>
                            <a href="{{ route('users.show', $user->id) }}">{{ $user->name }} ({{ $user->getNicknameOrShortname() }})</a>
                            <a href="{{ route('transactions.create') . '?user_id=' . $user->id }}" class="btn btn-default btn-xs pull-right">Add Transaction</a>
                        </h5>
                </div>
            </div>
        @endif
    </div>
@endsection
@push('scripts')
  <script>
    $(document).ready(function(){

      $('.focus-transactions-table').DataTable({
        "dom": '<"toolbar">frtip',
        "language": {
          "info": "Showing _START_ to _END_ of _TOTAL_ transactions."
        },
        "paging":    false,
        "searching": true
      });



    });
  </script>
@endpush