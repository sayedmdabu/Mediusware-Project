@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('User Profile') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1>User Profile</h1>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $user->name }}</h5>
                            <p class="card-text">Email: {{ $user->email }}</p>
                            <p class="card-text">Account Type: {{ $user->account_type }}</p>
                            <p class="card-text">Balance: ${{ number_format($user->balance, 2) }}</p>
                        </div>
                    </div>

                    <h2 class="mt-4">Transactions</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Fee</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ ucfirst($transaction->transaction_type) }}</td>
                                <td>{{ number_format($transaction->amount, 2) }} tk</td>
                                <td>{{ number_format($transaction->fee, 2) }} tk</td>
                                <td>{{ $transaction->date->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
