@extends('vendor.master')

@section('title', 'Vendor | Purchase Order Details')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Purchase Order #{{ $order->id }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('vendor.purchase_orders') }}">Purchase Orders</a></div>
                <div class="breadcrumb-item active">Order Details</div>
            </div>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Purchase Order</h2>
                                <div class="invoice-number">Order #{{ $order->id }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Supplier : </strong><br>
                                        {{ $order->supplierName }}<br>
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>To :</strong><br>
                                        <br>Magasin : {{ $magasin->name }}</br>
                                        <br>Location : {{ $magasin->location }}</br>
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Payment Status:</strong><br>
                                        {{ $order->paymentStatus }}<br>
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        {{ $order->created_at->format('F j, Y') }}<br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Summary</div>
                            <p class="section-lead">All items here cannot be deleted.</p>
                            <div class="table-responsive" style="overflow-x:auto;">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                    @foreach ($orderItems as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->product ? $item->product->name : '—' }}</td>
                                            <td>{{ 'DZ ' . number_format($item->unit_price, 2) }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-right">
                                                {{ 'DZ ' . number_format($item->unit_price * $item->quantity, 2) }}</td>
                                        </tr>
                                        @if ($item->variant_combination)
                                            <tr>
                                                <td colspan="5" class="small text-muted pl-5">Variant: @foreach ($item->variant_combination as $type => $val) <span class="badge badge-info mr-1">{{ $type }}: {{ $val }}</span> @endforeach</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </div>

                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    @if (false)
                                        <div class="section-title">Payment Method</div>
                                        <p class="section-lead">The payment method provided to make it easier for you to pay
                                            invoices.</p>
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
                                            <div class="invoice-detail-value">
                                                {{ 'DZ ' . number_format($order->totalAmount, 2) }}</div>
                                        </div>
                                    @endif
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                            {{ 'DZ ' . number_format($order->totalAmount, 2) }}</div>
                                    </div>
                                </div>
                            </div>


                            @if ($order->type === 'quote')
                                <div class="text-md-right">
                                    <form action="{{ route('vendor.purchase_orders.confirm', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Confirm this order? The ordered quantities will be added to your stock.');">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-icon icon-left"><i
                                                class="fas fa-check"></i> Confirm Order</button>
                                    </form>
                                </div>
                            @else
                                <div class="text-md-right mt-3">
                                    <span class="badge badge-success p-2"><i class="fas fa-check-circle"></i> Confirmed — stock updated</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
