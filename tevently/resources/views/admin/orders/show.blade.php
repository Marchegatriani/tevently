@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Order Details #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Information</h5>
                    <table class="table">
                        <tr>
                            <th>Order ID</th>
                            <td>#{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>{{ $order->user->name }} ({{ $order->user->email }})</td>
                        </tr>
                        <tr>
                            <th>Event</th>
                            <td>{{ $order->event->title }}</td>
                        </tr>
                        <tr>
                            <th>Ticket</th>
                            <td>{{ $order->ticket->name }} - Rp {{ number_format($order->ticket->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td>{{ $order->quantity }} tickets</td>
                        </tr>
                        <tr>
                            <th>Total Price</th>
                            <td class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-{{ $order->status == 'approved' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Actions</h5>
                    @if($order->status == 'pending')
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.orders.approve', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 mb-2">Approve Order</button>
                        </form>
                        <form action="{{ route('admin.orders.cancel', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100" 
                                    onclick="return confirm('Cancel this order?')">Cancel Order</button>
                        </form>
                    </div>
                    @else
                    <p class="text-muted">No actions available for {{ $order->status }} orders.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection