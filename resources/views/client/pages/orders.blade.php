@extends('client.master')

@section('title')
    My Orders
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content">
                <!-- Page Header -->
                <div style="margin-bottom: 30px;">
                    <h1 style="font-size: 26px; font-weight: 700; color: #1a237e; margin-bottom: 8px;">
                        <i class="fas fa-shopping-cart" style="margin-right: 10px; color: #e74c3c;"></i>My Orders
                    </h1>
                    <p style="color: #7f8c8d; margin: 0;">View and manage all your orders</p>
                </div>

                <!-- Orders Table -->
                <div style="background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                                        <th style="padding: 16px; text-align: left; font-weight: 600; color: #1a237e; font-size: 13px;">Order ID</th>
                                        <th style="padding: 16px; text-align: left; font-weight: 600; color: #1a237e; font-size: 13px;">Status</th>
                                        <th style="padding: 16px; text-align: left; font-weight: 600; color: #1a237e; font-size: 13px;">Amount</th>
                                        <th style="padding: 16px; text-align: left; font-weight: 600; color: #1a237e; font-size: 13px;">Payment</th>
                                        <th style="padding: 16px; text-align: left; font-weight: 600; color: #1a237e; font-size: 13px;">Shipping</th>
                                        <th style="padding: 16px; text-align: center; font-weight: 600; color: #1a237e; font-size: 13px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr style="border-bottom: 1px solid #e0e0e0; transition: all 0.3s ease;">
                                            <td style="padding: 16px; color: #2c3e50; font-weight: 600;">
                                                <a href="{{ route('client.order_details', $order->id) }}" style="color: #1a237e; text-decoration: none;">#{{ $order->id }}</a>
                                            </td>
                                            <td style="padding: 16px;">
                                                @if($order->status == 'pending')
                                                    <span style="background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Pending</span>
                                                @elseif($order->status == 'processing')
                                                    <span style="background: #cfe2ff; color: #084298; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Processing</span>
                                                @elseif($order->status == 'shipped')
                                                    <span style="background: #cff4fc; color: #055160; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Shipped</span>
                                                @elseif($order->status == 'delivered')
                                                    <span style="background: #d1e7dd; color: #0f5132; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Delivered</span>
                                                @else
                                                    <span style="background: #f8d7da; color: #842029; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Cancelled</span>
                                                @endif
                                            </td>
                                            <td style="padding: 16px; color: #2c3e50; font-weight: 600;">{{ number_format($order->totalAmount, 2) }} DZD</td>
                                            <td style="padding: 16px; color: #7f8c8d;">{{ ucfirst($order->paymentStatus) }}</td>
                                            <td style="padding: 16px; color: #7f8c8d;">{{ $order->shippingAddress->name ?? 'N/A' }}</td>
                                            <td style="padding: 16px; text-align: center;">
                                                <a href="{{ route('client.order_details', $order->id) }}" style="display: inline-block; background: #1a237e; color: white; padding: 8px 14px; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.3s;">View</a>
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
                        <div style="text-align: center; padding: 50px 20px;">
                            <i class="fas fa-inbox" style="font-size: 48px; color: #bdc3c7; margin-bottom: 15px; display: block;"></i>
                            <h5 style="color: #7f8c8d; margin-bottom: 10px;">No orders yet</h5>
                            <p style="color: #95a5a6;">Start shopping to see your orders here.</p>
                            <a href="{{ route('frontend.index') }}" style="display: inline-block; background: #1a237e; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; margin-top: 15px;">Continue Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        tr:hover {
            background: #f8f9fa !important;
        }
    </style>
@endsection
