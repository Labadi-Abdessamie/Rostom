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

                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Status</th>
                                        <th>Details</th>
                                        <th>Total Amount</th>
                                        <th>Date</th>
                                        <th>Payment Method</th>
                                        <th>Payment Status</th>
                                        <th>Shipping Address</th>
                                        <th>Billing Address</th>
                                        <th>User</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>
                                                <span>
                                                    {{ ucfirst($order->status) ?? 'Unknown' }}
                                                </span>
                                            </td>
                                            <td>{{ $order->details ?? 'N/A' }}</td>
                                            <td>{{ number_format($order->totalAmount, 2) }} DZD</td>
                                            <td>{{ $order->date ?? 'N/A' }}</td>
                                            <td>
                                                {{ ucfirst($order->paymentMethod) ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <span>
                                                    {{ ucfirst($order->paymentStatus) ?? 'Unknown' }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $order->shippingAddress ? $order->shippingAddress->address : 'Not available' }}
                                            </td>
                                            <td>
                                                {{ $order->billingAddress ? $order->billingAddress->address : 'Not available' }}
                                            </td>
                                            <td>{{ $order->user ? $order->user->name : 'N/A' }}</td>
                                            <td>
                                                <form action="{{ route('admin.delete_order', $order->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
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

        </div> <!-- container -->
    </div> <!-- content -->
@endsection
