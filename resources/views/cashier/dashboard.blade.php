{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Inventory System - Cashier Dashboard</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-success text-white mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Today's Sales</h5>
                                    <h2>$1,234</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-primary text-white mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Transactions Today</h5>
                                    <h2>28</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Quick Actions</h5>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">New Transaction</a>
                            <a href="#" class="list-group-item list-group-item-action">Check Stock</a>
                            <a href="#" class="list-group-item list-group-item-action">Daily Sales Report</a>
                            <a href="#" class="list-group-item list-group-item-action">Return Items</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


<x-base></x-base>
