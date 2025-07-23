@extends('Backend.layout.backend_app')
@section('content')
    <div class="row ">
        <div class="col-lg-6  ">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">User Details</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <span class="mb-3">Name: {{ $user->name }}</span>
                        <span class="mb-3">Email: {{ $user->email }}</span>
                        <span class="mb-3">Phone: {{ $user->number }}</span>
                        <span class="mb-3">Amount: {{ $user->amount }}</span>
                        <span class="mb-3">Status: {{ $user->terminate == 1 ? 'Active' : 'Terminated' }}</span>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Account History</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <span class="mb-3">Created: {{$user->created_at->format('j F y').' ('.$user->created_at->diffForHumans().')' }}</span>
                        <span class="mb-3">Total Oders: {{ $user->total_orders->count() }}</span>
                        <span class="mb-3">Total Deposit: </span>
                        <span class="mb-3">Last Deposit: </span>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

