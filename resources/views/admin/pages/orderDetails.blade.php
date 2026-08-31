@extends('admin.master')

@section('title', 'Admin | Order Details')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <div class="page-title-right d-none d-md-block">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.orders') }}">Orders</a></li>
                                    <li class="breadcrumb-item active">#{{ $order->id }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Order #{{ $order->id }}</h4>
                        </div>
                        <form action="{{ route('admin.delete_order', $order->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this order?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger waves-effect waves-light">
                                <i class="mdi mdi-delete me-1"></i> Delete Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Order Summary</h4>

                            <div class="mb-3">
                                <div class="text-muted font-13 mb-1">Status</div>
                                @php
                                    $sbClass = match($order->status) {
                                        'delivered' => 'sb-delivered',
                                        'processing' => 'sb-processing',
                                        'shipped' => 'sb-shipped',
                                        'confirmed' => 'sb-confirmed',
                                        'cancelled' => 'sb-cancelled',
                                        default => 'sb-pending',
                                    };
                                @endphp
                                <span class="status-badge {{ $sbClass }}">{{ ucfirst($order->status ?? 'Unknown') }}</span>
                            </div>

                            <div class="mb-3">
                                <div class="text-muted font-13 mb-1">Customer</div>
                                <h5 class="mt-0 mb-0">{{ $order->user->name ?? 'N/A' }}</h5>
                                <small class="text-muted">{{ $order->user->email ?? '' }}</small>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="text-muted font-13 mb-1">Order Date</div>
                                    <div class="fw-semibold">{{ $order->created_at?->format('d M Y') ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="text-muted font-13 mb-1">Total Amount</div>
                                    <div class="fw-bold">{{ number_format($order->totalAmount, 2) }} DZD</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="text-muted font-13 mb-1">Payment Method</div>
                                    <div class="fw-semibold">{{ ucfirst($order->paymentMethod ?? 'N/A') }}</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="text-muted font-13 mb-1">Payment Status</div>
                                    @php
                                        $paySbClass = match($order->paymentStatus) {
                                            'paid' => 'sb-delivered',
                                            'refunded' => 'sb-cancelled',
                                            default => 'sb-pending',
                                        };
                                    @endphp
                                    <span class="status-badge {{ $paySbClass }}">{{ ucfirst($order->paymentStatus ?? 'Unknown') }}</span>
                                </div>
                            </div>

                            @if ($order->details)
                                <div class="mt-2">
                                    <div class="text-muted font-13 mb-1">Details</div>
                                    <p class="mb-0">{{ $order->details }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Items in this Order</h4>

                            <div class="table-responsive" style="overflow-x:auto;">
                                <table class="table table-centered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($order->orderItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($item->product && $item->product->principalImage)
                                                            <img src="{{ asset('storage/products_images/' . $item->product->id . '/' . $item->product->principalImage) }}"
                                                                alt="product-img" class="rounded me-2" height="40" width="40" style="object-fit:cover;">
                                                        @endif
                                                        <span class="fw-semibold">{{ $item->product->name ?? 'Product deleted' }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->product->price ?? 0, 2) }} DZD</td>
                                                <td class="text-end fw-semibold">{{ number_format(($item->product->price ?? 0) * $item->quantity, 2) }} DZD</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">No items found for this order.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-end">Total :</th>
                                            <th class="text-end">{{ number_format($order->totalAmount, 2) }} DZD</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Shipping Address</h4>

                            @if ($order->shippingAddress)
                                <h5 class="fw-semibold">{{ $order->shippingAddress->name }}</h5>
                                <p class="mb-2"><span class="fw-semibold me-2">Address:</span> {{ $order->shippingAddress->address }}</p>
                                <p class="mb-2"><span class="fw-semibold me-2">Phone:</span> {{ $order->shippingAddress->phoneNumber }}</p>
                                <p class="mb-0"><span class="fw-semibold me-2">Email:</span> {{ $order->shippingAddress->email }}</p>
                            @else
                                <p class="text-muted mb-0">No shipping address available.</p>
                            @endif
                        </div>
                    </div>
                </div> <!-- end col -->

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Billing Address</h4>

                            @if ($order->billingAddress)
                                <h5 class="fw-semibold">{{ $order->billingAddress->name }}</h5>
                                <p class="mb-2"><span class="fw-semibold me-2">Address:</span> {{ $order->billingAddress->address }}</p>
                                <p class="mb-2"><span class="fw-semibold me-2">Phone:</span> {{ $order->billingAddress->phoneNumber }}</p>
                                <p class="mb-0"><span class="fw-semibold me-2">Email:</span> {{ $order->billingAddress->email }}</p>
                            @else
                                <p class="text-muted mb-0">No billing address available.</p>
                            @endif
                        </div>
                    </div>
                </div> <!-- end col -->

            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
@endsection
