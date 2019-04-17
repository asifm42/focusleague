@extends('layouts.default')
@section('title','FOCUS League – Balance Details')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h4 class="text-center w-100">Account Balance Details</h4>
        </div>
        @if (auth()->user()->isAdmin())
            <div class="row mb-3">
                <div class="col-12">
                        <a href="{{ route('transactions.create') . '?user_id=' . $user->id }}" class="btn btn-primary float-right">Add Transaction</a>
                        <h5>
                            <a href="{{ route('users.show', $user->id) }}">{{ $user->name }} ({{ $user->getNicknameOrShortname() }})</a> <br>
                        @if ($balance > 0)
                            owes <span class="text-danger">${{ $user->getBalanceInDollars() }}</span>
                        @elseif ($balance == 0)
                            <span>$0.00</span>
                        @elseif ($balance < 0)
                            has credit <span class="text-info">${{ $user->getBalanceInDollars() }}</span>
                        @endif
                        </h5>
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                @if ($balance > 0)
                    <div class="col-12 col-md-7">
                        <div class="card mt-2 mb-4">
                            <div class="card-body pb-2">
                                    <h6 class="text-center"><small class="text-uppercase">You owe</small></h6>
                                    <h3 class="text-center mb-4 text-danger">${{ $user->getBalanceInDollars() }}</h3>
                                    <h6>You can pay via the following methods:</h6>
                                    @component('site.payment_methods', ['balance' => $user->getBalanceInDollars()])
                                    @endcomponent
                            </div>
                        </div>
                    </div>
                @elseif ($balance == 0)
                    <div class="col-12">
                        <h6 class="text-center">Your balance is $0. Thank you for being current!</small></h6>
                    </div>
                @elseif ($balance < 0)
                    <div class="col-12">
                        <h6 class="text-center">Your credit of <span class="text-info">${{ $user->getBalanceInDollars() }}</span> will be auto applied to your next charge.</small></h6>
                    </div>
                @endif
            </div>
        @endif
        <div class="row">
            {{-- <div class="col-12 px-0"> --}}
                {{-- <div class="table-responsive"> --}}
                    <table class="table dt-responsive max-mobile no-wrap table-striped table-sm table-bordered focus-transactions-table">
                        <thead>
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">Cycle/Week</th>
                                <th>Description</th>
                                <th>Amount</th>
                                @if (auth()->user()->isAdmin())
                                    <th>Admin</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="text-center align-middle">{{ $transaction->date->format('m/d/Y') }}</td>
                                    <td class="text-center align-middle">{{ $transaction->cycle ? $transaction->cycle->name : 'N/A'}} {{ $transaction->week ? ' - Wk' . $transaction->week->index() : ''}}</td>
                                    @if($transaction->type == 'charge' || $transaction->type == 'credit')
                                        <td class="align-middle">{{ $transaction->description }}</td>
                                    @elseif($transaction->type == 'payment')
                                        <td class="align-middle">
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
                                        <td class="text-right align-middle">-${{ $transaction->amount_in_dollars }}</td>
                                    @else
                                        <td class="text-right text-danger align-middle">${{ $transaction->amount_in_dollars }}</td>
                                    @endif
                                    @if (auth()->user()->isAdmin())
                                        <td class="text-center align-middle">
                                            <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-default btn-xs">Edit</a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                {{-- </div> --}}
            {{-- </div> --}}
        </div>

        @if (auth()->user()->isAdmin())
            <div class="row mt-3">
                <div class="col-12">
                        <a href="{{ route('transactions.create') . '?user_id=' . $user->id }}" class="btn btn-primary float-right">Add Transaction</a>
                        <h5>
                            <a href="{{ route('users.show', $user->id) }}">{{ $user->name }} ({{ $user->getNicknameOrShortname() }})</a> <br>
                        @if ($balance > 0)
                            owes <span class="text-danger">${{ $user->getBalanceInDollars() }}</span>
                        @elseif ($balance == 0)
                            <span>$0.00</span>
                        @elseif ($balance < 0)
                            has credit <span class="text-info">${{ $user->getBalanceInDollars() }}</span>
                        @endif
                        </h5>
                </div>
            </div>
    <div class="container">
        <div class="row justify-content-center">
            <h4 class="text-center">Create a transaction</h4>
        </div>
        <div class="row justify-content-center">
            <div class="col col-sm-8 col-md-6">
                @include('transactions.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
        @endif
    </div>
@endsection
@push('scripts')
  <script>
    $(document).ready(function(){

      $.fn.dataTable.moment( 'MM/DD/YYYY' );
      $('.focus-transactions-table').DataTable({
        "dom": 'frtip',
        "language": {
          "info": "Showing _START_ to _END_ of _TOTAL_ transactions."
        },

        "paging":    false,
        "searching": true
      });



    });
  </script>
@endpush