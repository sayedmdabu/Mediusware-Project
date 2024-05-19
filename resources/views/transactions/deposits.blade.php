@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Deposits') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1>Deposits</h1>
                    <a href="{{route('deposit.form')}}" class="btn btn-success mb-3">Make a Deposit</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Fee</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deposits as $deposit)
                            <tr>
                                <td>{{ $deposit->id }}</td>
                                <td>{{ $deposit->user->name }}</td>
                                <td>{{ $deposit->amount }}</td>
                                <td>{{ $deposit->fee }}</td>
                                <td>{{ $deposit->date }}</td>
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
