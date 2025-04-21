@extends('client.master')

@section('title')
    Dashboard || Order Invoice
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content">
                <div class="wsus__invoice_area">
                    <div class="wsus__invoice_header">
                        <div class="wsus__invoice_content">
                            <div class="row">
                                {{-- Billing Address --}}
                                <div class="col-xl-4 col-md-4 mb-5 mb-md-0">
                                    <div class="wsus__invoice_single">
                                        <h5>Invoice To</h5>
                                        @if($order->billingAddress)
                                            <h6>{{ $order->billingAddress->name }}</h6>
                                            <p>{{ $order->billingAddress->address }}</p>
                                        @else
                                            <p>No billing address available.</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Shipping Address --}}
                                <div class="col-xl-4 col-md-4 mb-5 mb-md-0">
                                    <div class="wsus__invoice_single text-md-center">
                                        <h5>Shipping Information</h5>
                                        @if($order->shippingAddress)
                                            <h6>Name: {{ $order->shippingAddress->name }}</h6>
                                            <p>Address: {{ $order->shippingAddress->address }}</p>
                                        @else
                                            <p>No shipping address available.</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Payment Details --}}
                                <div class="col-xl-4 col-md-4">
                                    <div class="wsus__invoice_single text-md-end">
                                        <h5>Payment Details</h5>
                                        <p>Payment Method: {{ ucfirst($order->paymentMethod) }}</p>
                                        <p>Payment Status: {{ ucfirst($order->paymentStatus) }}</p>
                                        <p>Order Status: {{ ucfirst($order->status) }}</p>
                                        <p>Date: {{ $order->created_at->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Order Items --}}
                        <div class="wsus__invoice_description">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="images">Image</th>
                                            <th class="name">Product</th>
                                            <th class="amount">Price</th>
                                            <th class="quentity">Quantity</th>
                                            <th class="total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderItems as $item)
                                            <tr>
                                                <td class="images">
                                                    <img src="{{ asset($item->product->principalImage ?? 'images/default.jpg') }}" alt="product" class="img-fluid w-100">
                                                </td>
                                                <td class="name">
                                                    <p>{{ $item->product->name ?? 'Product Name' }}</p>
                                                   @if(false)
                                                       
                                                    @if($item->color) <span>Color: {{ $item->color }}</span> @endif
                                                    @if($item->size) <span>Size: {{ $item->size }}</span> @endif
                                                    @endif
                                                </td>
                                                <td class="amount">{{ number_format($item->product->price, 2) }} DZD</td>
                                                <td class="quentity">{{ $item->quantity }}</td>
                                                <td class="total">{{ number_format($item->product->price * $item->quantity, 2) }} DZD</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Invoice Summary --}}
                        <div class="wsus__invoice_footer">
                        @php
                           $shipping_fee = 100; 
                        @endphp
                          <p><span>Shipping Fee:</span> {{ number_format($shipping_fee,2) }} DZD</p>
                          <p><span>Total Amount:</span> {{ number_format($order->totalAmount, 2) }} DZD</p>
                          @if (false)
                            <p><span>Tax:</span> {{ number_format($order->tax ?? 0, 2) }} DZD</p>
                            <p><span>Discount:</span> {{ number_format($order->discount ?? 0, 2) }} DZD</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
