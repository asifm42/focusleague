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
        <div class="row">
            <div class="col-xs-12 col-md-8">
            <table class="table table-striped table-responsive table-condensed table-bordered">
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
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->date }}</td>
                        <td>{{ $transaction->cycle ? $transaction->cycle->name : 'N/A'}}</td>
                        <td>{{ $transaction->week ? $transaction->week->starts_at->toFormattedDateString() : 'N/A'}}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>{{ ucwords($transaction->type) }}</td>
                        <td>{{ $transaction->payment_type ? ucwords($transaction->payment_type) : 'N/A' }}</td>
                        @if ($transaction->type === 'payment' || $transaction->type === 'credit')
                            <td class="text-right">-${{ $transaction->amount }}</td>
                        @else
                            <td class="text-right text-danger">${{ $transaction->amount }}</td>
                        @endif
                        @if (auth()->user()->isAdmin())
                            <td class="text-center">
                                <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-default btn-xs">Edit</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                <tr>
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
                </tr>
            </table>
            </div>
        </div>
    </div>
@endsection