@extends('layouts.admin')

@section('title', 'Reports Dashboard')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Reports Dashboard</h1>
            <p class="text-muted">Analytics and insights overview</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-primary">
                <i class="fas fa-chart-line me-2"></i>Sales Report
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs fw-bold">TOTAL REVENUE</div>
                            <div class="h5 mb-0 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs fw-bold">TOTAL ORDERS</div>
                            <div class="h5 mb-0 fw-bold">{{ number_format($totalOrders) }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-receipt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs fw-bold">TOTAL EVENTS</div>
                            <div class="h5 mb-0 fw-bold">{{ number_format($totalEvents) }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs fw-bold">TOTAL USERS</div>
                            <div class="h5 mb-0 fw-bold">{{ number_format($totalUsers) }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Orders -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock me-2"></i>Recent Orders
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentOrders as $order)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold">{{ $order->user->name }}</div>
                                <small class="text-muted">{{ $order->event->title }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                <small class="text-muted">{{ $order->created_at->format('M d') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted">No recent orders</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Events -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Top Events by Revenue
                    </h5>
                </div>
                <div class="card-body">
                    @if($topEvents->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($topEvents as $event)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold">{{ Str::limit($event->title, 30) }}</div>
                                <small class="text-muted">{{ $event->organizer->name }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-primary">Rp {{ number_format($event->total_revenue ?? 0, 0, ',', '.') }}</div>
                                <small class="text-muted">{{ $event->total_orders }} orders</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted">No event data available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Reports</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('admin.reports.sales') }}" class="card text-decoration-none">
                                <div class="card-body text-center">
                                    <i class="fas fa-chart-line fa-2x text-primary mb-2"></i>
                                    <h6>Sales Report</h6>
                                    <p class="text-muted small">Detailed sales analysis</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('admin.reports.events') }}" class="card text-decoration-none">
                                <div class="card-body text-center">
                                    <i class="fas fa-calendar-alt fa-2x text-success mb-2"></i>
                                    <h6>Events Report</h6>
                                    <p class="text-muted small">Event performance</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('admin.reports.users') }}" class="card text-decoration-none">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-2x text-info mb-2"></i>
                                    <h6>Users Report</h6>
                                    <p class="text-muted small">Customer insights</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection