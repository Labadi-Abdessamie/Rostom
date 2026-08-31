@extends('client.master')

@section('title')
    My Orders
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="dashboard_content">
                <!-- Page Header -->
                <div class="dash-page-header">
                    <h1><i class="fas fa-shopping-cart"></i>My Orders</h1>
                    <p>View and manage all your orders</p>
                </div>

                <!-- Orders Table -->
                <div class="dash-card" style="padding: 22px;">
                    @if($orders->count() > 0)
                        <div class="table-responsive" style="overflow-x:auto;">
                            <table class="dash-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Payment</th>
                                        <th>Shipping</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td style="font-weight: 600;">
                                                <a href="{{ route('client.order_details', $order->id) }}" style="color: var(--dash-primary); text-decoration: none;">#{{ $order->id }}</a>
                                            </td>
                                            <td>
                                                @if($order->status == 'pending')
                                                    <span class="dash-badge dash-badge-warning">Pending</span>
                                                @elseif($order->status == 'processing')
                                                    <span class="dash-badge dash-badge-info">Processing</span>
                                                @elseif($order->status == 'confirmed')
                                                    <span class="dash-badge dash-badge-cyan">Confirmed</span>
                                                @elseif($order->status == 'delivered')
                                                    <span class="dash-badge dash-badge-success">Delivered</span>
                                                @else
                                                    <span class="dash-badge dash-badge-danger">Cancelled</span>
                                                @endif
                                            </td>
                                            <td style="font-weight: 600;">{{ number_format($order->totalAmount, 2) }} DZD</td>
                                            <td style="color: var(--dash-muted);">{{ ucfirst($order->paymentStatus) }}</td>
                                            <td style="color: var(--dash-muted);">{{ $order->shippingAddress->name ?? 'N/A' }}</td>
                                            <td style="text-align: center;">
                                                <a href="{{ route('client.order_details', $order->id) }}" class="dash-btn dash-btn-primary dash-btn-sm">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div style="margin-top: 25px; display: flex; justify-content: center;">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="dash-empty">
                            <i class="fas fa-inbox"></i>
                            <h5>No orders yet</h5>
                            <p style="color: var(--dash-muted);">Start shopping to see your orders here.</p>
                            <a href="{{ route('frontend.index') }}" class="dash-btn dash-btn-primary" style="margin-top: 15px;">Continue Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
