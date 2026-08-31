@extends('admin.master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                <li class="breadcrumb-item active">Orders</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Orders List</h4>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table table-centered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Status</th>
                                        <th>Total Amount</th>
                                        <th>Date</th>
                                        <th>Payment Method</th>
                                        <th>Payment Status</th>
                                        <th>Shipping Address</th>
                                        <th>User</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        @php
                                            $sbClass = match($order->status) {
                                                'delivered' => 'sb-delivered',
                                                'processing' => 'sb-processing',
                                                'shipped' => 'sb-shipped',
                                                'confirmed' => 'sb-confirmed',
                                                'cancelled' => 'sb-cancelled',
                                                default => 'sb-pending',
                                            };
                                            $paySbClass = match($order->paymentStatus) {
                                                'paid' => 'sb-delivered',
                                                'refunded' => 'sb-cancelled',
                                                default => 'sb-pending',
                                            };
                                        @endphp
                                        <tr>
                                            <td class="fw-semibold">#{{ $order->id }}</td>
                                            <td>
                                                <span class="status-badge {{ $sbClass }}">
                                                    {{ ucfirst($order->status) ?? 'Unknown' }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($order->totalAmount, 2) }} DZD</td>
                                            <td>{{ $order->created_at?->format('d/m/Y') ?? 'N/A' }}</td>
                                            <td>
                                                {{ ucfirst($order->paymentMethod ?? 'N/A') }}
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $paySbClass }}">
                                                    {{ ucfirst($order->paymentStatus ?? 'Unknown') }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $order->shippingAddress ? $order->shippingAddress->address : 'Not available' }}
                                            </td>
                                            <td>{{ $order->user ? $order->user->name : 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('admin.order_details', $order->id) }}" class="action-icon text-primary" title="View">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.delete_order', $order->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-icon text-danger border-0 bg-transparent" title="Delete" onclick="return confirm('Are you sure you want to delete this order?')">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container -->
    </div> <!-- content -->
@endsection
