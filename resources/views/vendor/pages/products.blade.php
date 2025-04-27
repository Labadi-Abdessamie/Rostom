@extends('vendor.master')

@section('title', 'Vendor | Products')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('vendor/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('vendor/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('vendor/js/page/modules-datatables.js') }}"></script>
@endsection


@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Products</h1>
            <div class="section-header-button">
                <a href="{{ route('vendor.add_product') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Products</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                Id
                                            </th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Rate</th>
                                            <th>Order_count</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                1
                                            </td>
                                            <td>Create a mobile app</td>
                                            <td>
                                                DZ 50
                                            </td>
                                            <td class="text-center">
                                                13
                                            </td>
                                            <td>4.5</td>
                                            <td>
                                                150
                                            </td>
                                            <td><a href="#" class="btn btn-secondary">Detail</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
