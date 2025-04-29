@extends('vendor.master')

@section('title', 'Vendor | Order details')


@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Order details</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Order details</div>
            </div>
        </div>

        <div class="section-body">
            <div class="invoice">
                <form action="{{ route('vendor.order.update', ['id' => $order->id]) }}" method="POST">
                    @csrf
                    <div class="invoice-print">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="invoice-title">
                                    <h2>Order details</h2>
                                    <div class="invoice-number">Order #{{ $order->id }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <address>
                                            <strong>Billed To:</strong><br>
                                            {{ $order->billingAddress->name }}<br>
                                            {{ $order->billingAddress->address }}
                                        </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                        <address>
                                            <strong>Shipped To:</strong><br>
                                            {{ $order->shippingAddress->name }}<br>
                                            {{ $order->shippingAddress->address }}
                                        </address>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <address>
                                            <strong>Payment Method:</strong><br>
                                            {{ $order->paymentMethod }}<br>
                                        </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                        <address>
                                            <strong>Order Date:</strong><br>
                                            {{ $order->updated_at->format('M d,Y') }}<br><br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-12">
                                <div class="section-title">Order Summary</div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-md">
                                        <tr>
                                            <th data-width="40">#</th>
                                            <th>Item</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-right">Totals</th>
                                            <th class="text-center">Available</th>
                                        </tr>
                                        @php
                                            $i = 0;
                                            $total = 0;
                                        @endphp
                                        @foreach ($orderItems as $item)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $item->product->name }}</td>
                                                <td class="text-center">DZ {{ $item->product->price }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-right">DZ
                                                    {{ $item->product->price * $item->quantity }}</td>
                                                @php
                                                    $total += $item->product->price * $item->quantity;
                                                @endphp
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-checkbox"
                                                        name="{{ $item->id }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-8">
                                        @if (false)
                                            <div class="section-title">Payment Method</div>
                                            <p class="section-lead">The payment method that we provide is to make it easier
                                                for
                                                you
                                                to pay invoices.</p>
                                            <div class="images">
                                                <img src="assets/img/visa.png" alt="visa">
                                                <img src="assets/img/jcb.png" alt="jcb">
                                                <img src="assets/img/mastercard.png" alt="mastercard">
                                                <img src="assets/img/paypal.png" alt="paypal">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 text-right">
                                        @if (false)
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Subtotal</div>
                                                <div class="invoice-detail-value">DZ {{ $total }}</div>
                                            </div>

                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Shipping</div>
                                                <div class="invoice-detail-value">$15</div>
                                            </div>
                                        @endif
                                        <hr class="mt-2 mb-2">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">DZ
                                                {{ $total }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-2 mb-2">
                    <div class="text-md-right">
                        @if (false)
                            <div class="float-lg-left mb-lg-0 mb-3">
                                <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i>
                                    Process
                                    Payment</button>
                                <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i>
                                    Cancel</button>
                            </div>
                            <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
                        @endif
                        <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
