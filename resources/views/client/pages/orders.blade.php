@extends('client.master')

@section('title')
    Dashboard || Orders
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content">
                <h3><i class="fas fa-list-ul"></i> Orders</h3>
                <div class="wsus__dashboard_order">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                    <th>Total Amount</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                    <th>Shipping Address</th>
                                    <th>Billing Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td><span class="badge bg-info">{{ ucfirst($order->status) }}</span></td>
                                        <td>{{ Str::limit($order->details, 30) }}</td>
                                        <td>{{ number_format($order->totalAmount, 2) }} DZD</td>
                                        <td>{{ ucfirst($order->paymentMethod) }}</td>
                                        <td>{{ ucfirst($order->paymentStatus) }}</td>
                                        <td>
                                            @if($order->shippingAddress)
                                                <strong>{{ $order->shippingAddress->name }}</strong><br>
                                                <small>{{ $order->shippingAddress->address }}</small>
                                            @else
                                                <em>No shipping address</em>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->billingAddress)
                                                <strong>{{ $order->billingAddress->name }}</strong><br>
                                                <small>{{ $order->billingAddress->address }}</small>
                                            @else
                                                <em>No billing address</em>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('client.order_details', $order->id) }}">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
