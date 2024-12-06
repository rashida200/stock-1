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
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Inventory System - Admin Dashboard</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-info text-white mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Products</h5>
                                    <h2>1,234</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Active Users</h5>
                                    <h2>25</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-dark mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Low Stock Items</h5>
                                    <h2>12</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Quick Actions</h5>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">Manage Users</a>
                            <a href="#" class="list-group-item list-group-item-action">View System Logs</a>
                            <a href="#" class="list-group-item list-group-item-action">System Settings</a>
                            <a href="#" class="list-group-item list-group-item-action">Generate Reports</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

<x-base></x-base>
