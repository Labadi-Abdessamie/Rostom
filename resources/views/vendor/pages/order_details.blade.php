@extends('vendor.master')

@section('title', 'Vendor | Order details')


@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Order details</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('vendor.orders') }}">Orders</a></div>
                <div class="breadcrumb-item">Order details</div>
            </div>
        </div>

        <div class="section-body">
            <div class="invoice">
                @if ($order->status === 'pending' || $order->status === 'processing' || $order->status === 'confirmed')
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
                                                <strong>Payment Status:</strong><br>
                                                <span class="badge badge-{{ $order->paymentStatus === 'success' ? 'success' : ($order->paymentStatus === 'failed' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($order->paymentStatus) }}
                                                </span>
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
                                    <div class="table-responsive" style="overflow-x:auto;">
                                        <table class="table table-striped table-hover table-md">
                                            <tr>
                                                <th data-width="40">#</th>
                                                <th>Item</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-right">Totals</th>
                                                <th class="text-center">Available</th>
                                                <th class="text-center">Justification</th>
                                            </tr>
                                            @php
                                                $i = 0;
                                                $total = 0;
                                            @endphp
                                            @foreach ($orderItems as $item)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>
                                                        {{ $item->product->name }}
                                                        @if ($item->variant_combination)
                                                            <div class="small text-muted">
                                                                @foreach ($item->variant_combination as $type => $val)
                                                                    <span class="badge badge-info mr-1">{{ $type }}: {{ $val }}</span>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        DZ {{ $item->base_price ?? $item->product->price }}
                                                        @if (($item->extra_price ?? 0) > 0)
                                                            <div class="small text-success">+DZ {{ $item->extra_price }} variant</div>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-right">DZ
                                                        {{ (($item->base_price ?? $item->product->price) + ($item->extra_price ?? 0)) * $item->quantity }}</td>
                                                    @php
                                                        $total += (($item->base_price ?? $item->product->price) + ($item->extra_price ?? 0)) * $item->quantity;
                                                    @endphp
                                                    @php
                                                        $stockQty = $item->product->actual_quantity ?? 0;
                                                        if ($item->variant_combination && !empty($item->variant_combination)) {
                                                            $combo = \App\Models\VariantCombination::where('product_id', $item->product_id)
                                                                ->get()
                                                                ->first(function ($c) use ($item) {
                                                                    $data = $c->combination ?? [];
                                                                    foreach ($item->variant_combination as $k => $v) {
                                                                        if (!isset($data[$k]) || $data[$k] !== $v) return false;
                                                                    }
                                                                    return true;
                                                                });
                                                            if ($combo) $stockQty = $combo->quantity ?? 0;
                                                        }
                                                    @endphp
                                                    <td class="text-center">
                                                        <select class="form-control text-center" name="{{ $item->id }}" id="{{ $item->id }}" style="font-size:1rem; height:42px;">
                                                            @if ($stockQty >= $item->quantity)
                                                                <option value="1"
                                                                    @if ($item->status == 'available' || $item->status == 'pending') selected @endif>Yes
                                                                </option>
                                                                <option value="0"
                                                                    @if ($item->status == 'notAvailable') selected @endif>No
                                                                </option>
                                                            @else
                                                                <option value="1" disabled>Yes (Stock: {{ $stockQty }})</option>
                                                                <option value="0" selected>No (Stock: {{ $stockQty }})</option>
                                                            @endif
                                                        </select>
                                                        <div class="text-muted mt-1" style="font-size:1.1rem; font-weight:700; color:#dc3545 !important;">
                                                            <i class="fas fa-cubes mr-1"></i> Stock: {{ $stockQty }}
                                                        </div>
                                                        <!-- <input type="checkbox"> -->
                                                    </td>
                                                    <td class="text-center">
                                                        <input class="form-control d-none" type="text" maxlength="80"
                                                            name="Just-{{ $item->id }}"
                                                            value="{{ $item->description }}">
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-8">
                                            @if (false)
                                                <div class="section-title">Payment Method</div>
                                                <p class="section-lead">The payment method that we provide is to make it
                                                    easier
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
                                <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i>
                                    Print</button>
                            @endif
                            <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-save"></i> Save</button>
                        </div>
                    </form>
                @else
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
                                <div class="table-responsive" style="overflow-x:auto;">
                                    <table class="table table-striped table-hover table-md">
                                        <tr>
                                            <th data-width="40">#</th>
                                            <th>Item</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-right">Totals</th>
                                            <th class="text-center">Available</th>
                                            <th class="text-center">Justification</th>
                                        </tr>
                                        @php
                                            $i = 0;
                                            $total = 0;
                                        @endphp
                                        @foreach ($orderItems as $item)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>
                                                    {{ $item->product->name }}
                                                    @if ($item->variant_combination)
                                                        <div class="small text-muted">
                                                            @foreach ($item->variant_combination as $type => $val)
                                                                <span class="badge badge-info mr-1">{{ $type }}: {{ $val }}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    DZ {{ $item->base_price ?? $item->product->price }}
                                                    @if (($item->extra_price ?? 0) > 0)
                                                        <div class="small text-success">+DZ {{ $item->extra_price }} variant</div>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-right">DZ
                                                    {{ (($item->base_price ?? $item->product->price) + ($item->extra_price ?? 0)) * $item->quantity }}</td>
                                                <td class="text-center">
                                                    @php
                                                        $stockQty = $item->product->actual_quantity ?? 0;
                                                        if ($item->variant_combination && !empty($item->variant_combination)) {
                                                            $combo = \App\Models\VariantCombination::where('product_id', $item->product_id)
                                                                ->get()
                                                                ->first(function ($c) use ($item) {
                                                                    $data = $c->combination ?? [];
                                                                    foreach ($item->variant_combination as $k => $v) {
                                                                        if (!isset($data[$k]) || $data[$k] !== $v) return false;
                                                                    }
                                                                    return true;
                                                                });
                                                            if ($combo) $stockQty = $combo->quantity ?? 0;
                                                        }
                                                    @endphp
                                                    {{ $item->status }}
                                                    <div class="small text-muted mt-1">Stock: {{ $stockQty }}</div>
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->description }}
                                                </td>
                                                @php
                                                    $total += (($item->base_price ?? $item->product->price) + ($item->extra_price ?? 0)) * $item->quantity;
                                                @endphp
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-8">

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
                        @if ($order->status === 'delivered' && $order->paymentStatus !== 'success')
                            <form action="{{ route('vendor.order.confirm_payment', ['id' => $order->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-icon icon-left"><i class="fas fa-check"></i> Confirm Payment Received</button>
                            </form>
                        @endif
                        @if ($order->status === 'delivered' && $order->paymentStatus === 'success')
                            <span class="badge badge-success">Payment Confirmed</span>
                        @endif
                        @if (false)
                            <div class="float-lg-left mb-lg-0 mb-3">
                                <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i>
                                    Process
                                    Payment</button>
                                <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i>
                                    Cancel</button>
                            </div>
                            <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i>
                                Print</button>
                            <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-save"></i> Save</button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection


@section('scripts')
    @if ($order->status === 'pending' || $order->status === 'processing' || $order->status === 'confirmed')
        <script>
            $(document).ready(function() {
                $('select').each(function() {
                    toggleTextInput($(this));
                });

                $('select').on('change', function() {
                    toggleTextInput($(this));
                });

                function toggleTextInput($select) {
                    const inputSelector = 'input[type="text"][name="Just-' + $select.attr('id') + '"]';

                    if ($select.val() != "0") {
                        $(inputSelector).addClass('d-none');
                    } else {
                        $(inputSelector).removeClass('d-none');
                    }
                }
            });
        </script>
    @endif
@endsection
