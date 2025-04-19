<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
@extends('admin.master')

@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <form class="d-flex align-items-center mb-3">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control border-0" id="dash-daterange">
                                        <span class="input-group-text bg-blue border-blue text-white">
                                            <i class="mdi mdi-calendar-range"></i>
                                        </span>
                                    </div>
                                    <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-2">
                                        <i class="mdi mdi-autorenew"></i>
                                    </a>
                                    <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-1">
                                        <i class="mdi mdi-filter-variant"></i>
                                    </a>
                                </form>
                            </div>
                            <h4 class="page-title">Dashboard</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-primary border-primary border shadow">
                                            <i class="fe-heart font-22 avatar-title text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $totalVendors }}</span></h3>
                                            <p class="text-muted mb-1 text-truncate">Total Vendors</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-success border-success border shadow">
                                            <i class="fe-shopping-cart font-22 avatar-title text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $totalProducts }}</span></h3>
                                            <p class="text-muted mb-1 text-truncate">Total Products</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-info border-info border shadow">
                                            <i class="fe-bar-chart-line- font-22 avatar-title text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $totalClients }}</span></h3>
                                            <p class="text-muted mb-1 text-truncate">Total Clients</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </a>

                                    </div>

                                    <h4 class="header-title mb-0">Total Revenue</h4>

                                    <div class="widget-chart text-center" dir="ltr">

                                        <div id="total-revenue" class="mt-0" data-colors="#f1556c"></div>

                                        <h5 class="text-muted mt-0">Total sales made today</h5>
                                        <h2>180</h2>

                                        <p class="text-muted w-75 mx-auto sp-line-2">Traditional heading elements are
                                            designed to work best in the meat of your page content.</p>

                                        <div class="row mt-3">
                                            <div class="col-4">
                                                <p class="text-muted font-15 mb-1 text-truncate">Target</p>
                                                <h4><i class="fe-arrow-down text-danger me-1"></i>$7.8k</h4>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-muted font-15 mb-1 text-truncate">Last week</p>
                                                <h4><i class="fe-arrow-up text-success me-1"></i>$1.4k</h4>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-muted font-15 mb-1 text-truncate">Last Month</p>
                                                <h4><i class="fe-arrow-down text-danger me-1"></i>$15k</h4>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col-->

                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body pb-2">
                                    <div class="float-end d-none d-md-inline-block">
                                        <div class="btn-group mb-2">
                                            <button type="button" class="btn btn-xs btn-light">Today</button>
                                            <button type="button" class="btn btn-xs btn-light">Weekly</button>
                                            <button type="button" class="btn btn-xs btn-secondary">Monthly</button>
                                        </div>
                                    </div>

                                    <h4 class="header-title mb-3">Sales Analytics</h4>

                                    <div dir="ltr">
                                        <div id="sales-analytics" class="mt-4" data-colors="#1abc9c,#4a81d4"></div>
                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>

                                    <h4 class="header-title mb-3">Top 5 Magasins</h4>

                                    <div class="table-responsive">
                                        <table class="table table-borderless table-hover table-nowrap table-centered m-0">

                                            <thead class="table-light">
                                                <tr>
                                                    <th>Picture</th>
                                                    <th>Magasin Name</th>
                                                    <th>Rate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($magasins->sortByDesc('rate') as $magasin)
                                                    <tr>
                                                        <td style="width: 36px;">
                                                            <img src="{{ $magasin->picture }}" alt="magasin-img"
                                                                class="rounded-circle avatar-sm" />
                                                        </td>
                                                        <td>
                                                            <h5 class="m-0 fw-normal">{{ $magasin->name }}</h5>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-success">{{ $magasin->rate }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>

                                    <h4 class="header-title mb-3">Latest Orders</h4>

                                    <div class="table-responsive">
                                        <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer</th>
                                                    <th>Vendor</th>
                                                    <th>Status</th>
                                                    <th>Total Price</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($latestOrders->forPage(request()->get('page', 1), 5) as $order)
                                                    <tr>
                                                        <td>#{{ $order->id }}</td>
                                                        <td>
                                                            <h5 class="m-0 fw-normal">{{ $order->customer->name ?? 'N/A' }}
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="m-0 fw-normal">{{ $order->vendor->name ?? 'N/A' }}
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge
                            @if ($order->status === 'pending') bg-warning
                            @elseif($order->status === 'shipped') bg-info
                            @elseif($order->status === 'delivered') bg-success
                            @else bg-secondary @endif">
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                        </td>
                                                        <td>${{ number_format($order->total_price, 2) }}</td>
                                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                                class="btn btn-sm btn-primary">View</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> &copy; UBold theme by <a href="">Coderthemes</a>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);">About Us</a>
                                    <a href="javascript:void(0);">Help</a>
                                    <a href="javascript:void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

            <!-- Plugins JS -->
            <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
            <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
            <script src="{{ asset('assets/libs/selectize/js/standalone/selectize.min.js') }}"></script>



            <!-- App JS -->
            <script src="{{ asset('assets/js/app.min.js') }}"></script>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        @endsection
