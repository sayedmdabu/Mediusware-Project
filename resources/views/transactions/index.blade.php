@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('All Transactions') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>All Transactions</h1>
                    <a href="{{route('deposit.form')}}" class="btn btn-success mb-3">Make a Deposit</a>
                    <a href="{{route('withdrawal.form')}}" class="btn btn-danger mb-3">Make a Withdrawal</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Fee</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $transactions as $transaction )

                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>{{ $transaction->transaction_type }}</td>
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->fee }}</td>
                                    <td>{{ $transaction->date }}</td>
                                </tr>
                            @empty
                                <p>No data found</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
