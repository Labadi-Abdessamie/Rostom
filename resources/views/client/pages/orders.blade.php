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
                                    <th class="id">Order ID</th>
                                    <th class="status">Status</th>
                                    <th class="details">Details</th>
                                    <th class="totalAmount">Total Amount</th>
                                    <th class="paymentMethod">Payment Method</th>
                                    <th class="paymentStatus">Payment Status</th>
                                    <th class="shippingAddress">Shipping Address</th>
                                    <th class="billingAddress">Billing Address</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td class="id">{{ $order->id }}</td>
                                        <td class="status"><span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                                        </td>
                                        <td class="details">{{ Str::limit($order->details, 30) }}</td>
                                        <td class="totalAmount">{{ number_format($order->totalAmount, 2) }} DZD</td>
                                        <td class="paymentMethod">{{ ucfirst($order->paymentMethod) }}</td>
                                        <td class="paymentStatus">{{ ucfirst($order->paymentStatus) }}</td>
                                        <td class="shippingAddress">
                                            <strong>{{ $order->shippingAddress->name }}</strong>
                                            <small>: {{ $order->shippingAddress->address }}</small>
                                        </td>
                                        <td class="billingAddress">
                                            @if ($order->billingAddress)
                                                <strong>{{ $order->billingAddress->name }}</strong>
                                                <small>: {{ $order->billingAddress->address }}</small>
                                            @else
                                                <em>No billing address</em>
                                            @endif
                                        </td>
                                        <td class="actions">
                                            <a href="{{ route('client.order_details', $order->id) }}">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td width="1400px" class="text-center">No orders found.</td>
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
