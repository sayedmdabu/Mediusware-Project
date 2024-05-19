@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul>
                        <li><a href="{{route('users.index')}}" class="mb-3">User List</a></li>
                        <li><a href="{{route('transactions.index')}}" class="mb-3">Transactions List</a></li>
                        <li><a href="{{route('deposit.show')}}" class="mb-3">Deposit List</a></li>
                        <li><a href="{{route('withdrawal.show')}}" class="mb-3">Withdrawal List</a></li>
                      </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
