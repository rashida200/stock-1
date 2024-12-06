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
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Inventory System - Manager Dashboard</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-primary text-white mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Today's Orders</h5>
                                    <h2>48</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-warning text-dark mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Pending Approvals</h5>
                                    <h2>7</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Manager Actions</h5>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">Inventory Overview</a>
                            <a href="#" class="list-group-item list-group-item-action">Approve Purchase Orders</a>
                            <a href="#" class="list-group-item list-group-item-action">Stock Management</a>
                            <a href="#" class="list-group-item list-group-item-action">View Sales Reports</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

<x-base></x-base>
