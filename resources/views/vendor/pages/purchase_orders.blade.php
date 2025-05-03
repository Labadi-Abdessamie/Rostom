@extends('vendor.master')

@section('title', 'Vendor | Purchase Orders')

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
            <h1>Purchase Orders</h1>
            <div class="section-header-button">
                <a href="{{ route('vendor.purchase_order_add') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a>Purchase Orders</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <ul class="nav nav-pills" id="orders-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#payed-orders" id="payed-orders-tab"
                                        data-bs-toggle="pill" data-bs-target="#payed-orders" role="tab"
                                        aria-controls="payed-orders" aria-selected="true">Payed <span
                                            class="badge badge-primary">{{ $payedOrders->count() }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#not-fully-payed-orders" id="not-fully-payed-orders-tab"
                                        data-bs-toggle="pill" data-bs-target="#not-fully-payed-orders" role="tab"
                                        aria-controls="not-fully-payed-orders" aria-selected="false">Not Fully Payed</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#debt-orders" id="debt-orders-tab" data-bs-toggle="pill"
                                        data-bs-target="#debt-orders" role="tab" aria-controls="debt-orders"
                                        aria-selected="false">Debt</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="orders-tabContent">
                {{-- Payed Orders --}}
                <div class="tab-pane fade show active" id="payed-orders" role="tabpanel" aria-labelledby="payed-orders-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Supplier Name</th>
                                                    <th>Total Amount</th>
                                                    <th>Done Date</th>
                                                    <th>Payment Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($payedOrders as $order)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $order->supplierName }}</td>
                                                        <td>{{ 'DZ ' . number_format($order->totalAmount, 2) }}</td>
                                                        <td>{{ $order->doneDate }}</td>
                                                        <td>{{ $order->paymentStatus }}</td>
                                                        <td class="d-flex">
                                                            <a href="{{ route('vendor.purchase_orders.show', $order->id) }}"
                                                                class="btn btn-info btn-sm mr-2">Detail</a>
                                                            <form
                                                                action="{{ route('vendor.purchase_orders.delete', $order->id) }}"
                                                                method="POST" onsubmit="return confirm('Are you sure?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm">Delete</button>
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
                </div>

                {{-- Not Fully Payed Orders --}}
                <div class="tab-pane fade" id="not-fully-payed-orders" role="tabpanel"
                    aria-labelledby="not-fully-payed-orders-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-2">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Supplier Name</th>
                                                    <th>Total Amount</th>
                                                    <th>Done Date</th>
                                                    <th>Payment Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($notFullyPayedOrders as $order)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $order->supplierName }}</td>
                                                        <td>{{ 'DZ ' . number_format($order->totalAmount, 2) }}</td>
                                                        <td>{{ $order->doneDate }}</td>
                                                        <td>{{ $order->paymentStatus }}</td>
                                                        <td class="d-flex">
                                                            <a href="{{ route('vendor.purchase_orders.show', $order->id) }}"
                                                                class="btn btn-info btn-sm mr-2">Detail</a>
                                                            <form
                                                                action="{{ route('vendor.purchase_orders.delete', $order->id) }}"
                                                                method="POST" onsubmit="return confirm('Are you sure?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm">Delete</button>
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
                </div>

                {{-- Debt Orders --}}
                <div class="tab-pane fade" id="debt-orders" role="tabpanel" aria-labelledby="debt-orders-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-3">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Supplier Name</th>
                                                    <th>Total Amount</th>
                                                    <th>Done Date</th>
                                                    <th>Payment Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($debtOrders as $order)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $order->supplierName }}</td>
                                                        <td>{{ 'DZ ' . number_format($order->totalAmount, 2) }}</td>
                                                        <td>{{ $order->doneDate }}</td>
                                                        <td>{{ $order->paymentStatus }}</td>
                                                        <td class="d-flex">
                                                            <a href="{{ route('vendor.purchase_orders.show', $order->id) }}"
                                                                class="btn btn-info btn-sm mr-2">Detail</a>
                                                            <form
                                                                action="{{ route('vendor.purchase_orders.delete', $order->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm">Delete</button>
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
                </div>

            </div>
        </div>
    </section>
@endsection
