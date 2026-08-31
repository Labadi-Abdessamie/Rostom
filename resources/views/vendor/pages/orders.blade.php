@extends('vendor.master')

@section('title', 'Vendor | Orders')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/modules/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('vendor/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('vendor/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/js/page/features-posts.js') }}"></script>
    <script src="{{ asset('vendor/js/page/modules-datatables.js') }}"></script>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Orders</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Orders</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <ul class="nav nav-pills" id="orders-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="all-orders-tab" data-bs-toggle="pill"
                                        href="#all-orders">All <span
                                            class="badge badge-white">{{ $orders->count() }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pending-orders-tab" data-bs-toggle="pill"
                                        href="#pending-orders">Pending <span
                                            class="badge badge-primary">{{ $orders->where('status', 'pending')->count() }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="confirmed-orders-tab" data-bs-toggle="pill"
                                        href="#confirmed-orders">Confirmed <span
                                            class="badge badge-primary">{{ $orders->where('status', 'confirmed')->count() }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="completed-orders-tab" data-bs-toggle="pill"
                                        href="#completed-orders">Completed <span
                                            class="badge badge-primary">{{ $orders->whereIn('status', ['delivered', 'cancelled'])->count() }}</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="orders-tabContent">
                @php
                    $statuses = [
                        'all' => $orders,
                        'pending' => $orders->where('status', 'pending'),
                        'confirmed' => $orders->where('status', 'confirmed'),
                        'completed' => $orders->whereIn('status', ['delivered', 'cancelled']),
                    ];
                @endphp

                @foreach ($statuses as $key => $statusOrders)
                    <div class="tab-pane fade {{ $key === 'all' ? 'show active' : '' }}" id="{{ $key }}-orders"
                        role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive" style="overflow-x:auto;">
                                            <table class="table table-striped" id="table-{{ $loop->index + 1 }}">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Products</th>
                                                        <th>Price</th>
                                                        <!-- <th>Quantity</th> -->
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($statusOrders as $order)
                                                        {{-- @foreach ($orders as $order) --}}
                                                        <tr>
                                                            <td>{{-- $order['id'] --}}{{ $loop->iteration }}</td>
                                                            <td>
                                                                @foreach ($order['items'] as $item)
                                                                    {{ $item['product']['name'] }} ×
                                                                    {{ $item['quantity'] }}<br>
                                                                @endforeach

                                                            </td>
                                                            <td>DZ {{ $order['totalAmount'] }}</td>
                                                            <!-- <td>{{-- $item->quantity --}}</td> -->
                                                            <td>
                                                                @if ($order['status'] === 'pending')
                                                                    <span class="badge badge-warning">Pending</span>
                                                                @elseif ($order['status'] === 'confirmed')
                                                                    <span class="badge badge-primary">Confirmed</span>
                                                                @elseif ($order['status'] === 'completed')
                                                                    <span class="badge badge-success">Completed</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-secondary">{{ ucfirst($order['status']) }}</span>
                                                                @endif
                                                            </td>
                                                            <td><a href="{{ route('vendor.order_details', $order['id']) }}"
                                                                    class="btn btn-secondary">Detail</a>
                                                            </td>
                                                        </tr>
                                                        {{-- @endforeach --}}
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center">No orders found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection
