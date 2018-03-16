@extends('layouts.default')
@section('title','FOCUS League – Balance Details')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h4 class="text-center w-100">Account Balance Details</h4>
            <p class="text-center">See a list of your transactions.</p>
        </div>
        @if (auth()->user()->isAdmin())
            <div class="row">
                <div class="col-12 col-sm-12">
                        <h5>
                            <a href="{{ route('users.show', $user->id) }}">{{ $user->name }} ({{ $user->getNicknameOrShortname() }})</a>
                            <a href="{{ route('transactions.create') . '?user_id=' . $user->id }}" class="btn btn-default pull-right">Add Transaction</a>
                        </h5>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12">
                <h5>
                    @if ($balance < 0 )
                        Credit: <span class="text-primary">{{ $balanceString }}</span>
                    @elseif ($balance == 0 )
                        Balance: <span>{{ $balanceString }}</span>
                    @else
                        Amount owed: <span class="text-danger">{{ $balanceString }}</span>
                    @endif
                </h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12">
                <div class = "table-responsive">
                    <table class="table table-striped table-condensed table-bordered focus-transactions-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Cycle/Week</th>
                                <th>Description</th>
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
                                    <td>{{ $transaction->cycle ? $transaction->cycle->name : 'N/A'}} {{ $transaction->week ? ' - Wk' . $transaction->week->index() : ''}}</td>
                                    @if($transaction->type == 'charge' || $transaction->type == 'credit')
                                        <td>{{ $transaction->description }}</td>
                                    @elseif($transaction->type == 'payment')
                                        <td>
                                            Payment
                                            @if($transaction->payment_type == 'cash')
                                                 - {{ $transaction->description }}
                                            @elseif( $transaction->description == 'payment' || $transaction->description == 'Payment' )
                                                {{ $transaction->payment_type ? ' - ' . ucwords($transaction->payment_type) : '' }}
                                            @else
                                                {{ $transaction->payment_type ? ' - ' . ucwords($transaction->payment_type) : '' }}
                                                @if ($transaction->description)
                                                    - {{ $transaction->description }}
                                                @endif
                                            @endif
                                        </td>
                                    @endif
                                    @if ($transaction->type === 'payment' || $transaction->type === 'credit')
                                        <td class="text-right">-${{ $transaction->amount_in_dollars }}</td>
                                    @else
                                        <td class="text-right text-danger">${{ $transaction->amount_in_dollars }}</td>
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
            <div class="col-12 col-sm-12">
                <h5 class="float-right">
                    @if ($balance < 0 )
                        Credit: <span class="text-primary">{{ $balanceString }}</span>
                    @elseif ($balance == 0 )
                        Balance: <span>{{ $balanceString }}</span>
                    @else
                        Amount owed: <span class="text-danger">{{ $balanceString }}</span>
                    @endif
                </h5>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12">
                        <h5>
                            <a href="{{ route('users.show', $user->id) }}">{{ $user->name }} ({{ $user->getNicknameOrShortname() }})</a>
                            <a href="{{ route('transactions.create') . '?user_id=' . $user->id }}" class="btn btn-default btn-xs float-right">Add Transaction</a>
                        </h5>
                </div>
            </div>
        @endif
    </div>
@endsection
@push('scripts')
  <script>
    $(document).ready(function(){

      $.fn.dataTable.moment( 'MM-DD-YYYY' );
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