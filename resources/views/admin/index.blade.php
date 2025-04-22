@extends('admin.master')

@section('title', 'Admin || Dashboard')


@section('styles')
    <!-- Plugins css -->
    <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
    <!-- Plugins js-->
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/selectize/js/standalone/selectize.min.js') }}"></script>
    <!-- Dashboar 1 init js-->
    <script src="{{ asset('assets/js/pages/dashboard-1.init.js') }}"></script>
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            
                        </div>
                        <h3 class="page-title">Dashboard</h3>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-lg rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm">
                                    <i class="fe-users font-24"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0 text-dark">{{$totalVendors}}</h4>
                                    <p class="text-muted mb-0">Total Vendors</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-lg rounded-circle bg-success text-white d-flex align-items-center justify-content-center shadow-sm">
                                    <i class="fe-shopping-cart font-24"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0 text-dark">{{$totalProducts}}</h4>
                                    <p class="text-muted mb-0">Total Products</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-lg rounded-circle bg-info text-white d-flex align-items-center justify-content-center shadow-sm">
                                    <i class="fe-bar-chart-line font-24"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0 text-dark">{{$totalClients}}</h4>
                                    <p class="text-muted mb-0">Total Clients</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-lg rounded-circle bg-danger text-white d-flex align-items-center justify-content-center shadow-sm">
                                    <i class="fe-user-check font-24"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0 text-dark">{{$totalAdmins}}</h4>
                                    <p class="text-muted mb-0">Total Admins</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-lg rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center shadow-sm">
                                    <i class="fe-user-check font-24"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0 text-dark">{{$totalactiveClients}}</h4>
                                    <p class="text-muted mb-0">Active Clients</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-lg rounded-circle bg-light text-dark d-flex align-items-center justify-content-center shadow-sm">
                                    <i class="fe-user-check font-24"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0 text-dark">{{$totalactiveVendors}}</h4>
                                    <p class="text-muted mb-0">Active Vendors</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-lg rounded-circle bg-warning text-white d-flex align-items-center justify-content-center shadow-sm">
                                    <i class="fe-star font-24"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0 text-dark">{{$totalReviews}}</h4>
                                    <p class="text-muted mb-0">Total Reviews</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of the cards--> 

            
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            @if (false)
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                </div>
                            </div>
                            @endif
                            
                            <h4 class="header-title mb-0">Average Rating</h4>

                            @php
                            $percent = round(($avgRating / 5) * 100);
                            $circleCircumference = 377;
                            $dashOffset = $circleCircumference - ($circleCircumference * $percent / 100);
                             @endphp

                              <div class="widget-chart text-center" dir="ltr">

                            <!-- Cercle de satisfaction -->
                            <div class="position-relative d-inline-block mt-0" style="width: 140px; height: 140px;">
                             <svg width="140" height="140">
                             <circle cx="70" cy="70" r="60" stroke="#e6e6e6" stroke-width="10" fill="none"/>
                               <circle cx="70" cy="70" r="60"
                             stroke="#28a745" stroke-width="10" fill="none"
                           stroke-dasharray="{{ $circleCircumference }}"
                          stroke-dashoffset="{{ $dashOffset }}"
                           stroke-linecap="round"
                           transform="rotate(-90 70 70)" />
        </svg>
        <div class="position-absolute top-50 start-50 translate-middle">
            <strong>Satisfaction</strong><br>
            <span class="text-muted">{{ $percent }}%</span>
        </div>
    </div>

    <!-- Textes -->
    <h5 class="text-muted mt-0">Average customer rating</h5>
    <h2>{{ number_format($avgRating, 1) }} / 5 ⭐</h2>

    <p class="text-muted w-75 mx-auto sp-line-2">
        Based on reviews from customers.
    </p>
    @if (false)
    <!-- maybe i add the function to test only on year / month / last week -->
    <div class="row mt-3">
        <div class="col-4">
            <p class="text-muted font-15 mb-1 text-truncate">Target</p>
            <h4><i class="fe-arrow-up text-success me-1"></i>95%</h4>
        </div>
        <div class="col-4">
            <p class="text-muted font-15 mb-1 text-truncate">Last week</p>
            <h4><i class="fe-arrow-up text-success me-1"></i>88%</h4>
        </div>
        <div class="col-4">
            <p class="text-muted font-15 mb-1 text-truncate">Last month</p>
            <h4><i class="fe-arrow-down text-danger me-1"></i>85%</h4>
        </div>
    </div>
      @endif
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
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
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

                            <h4 class="header-title mb-3">Top 5 Magasins by Rating</h4>

                            <div class="table-responsive">
                                <table class="table table-borderless table-hover table-nowrap table-centered m-0">

                                    <thead class="table-light">
                                        <tr>
                                            <th>Magasin</th>
                                            <th>Rating</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topMagasinsRating as $magasin)
                                            <tr>
                                                <td>
                                                    <h5 class="m-0 fw-normal">{{ $magasin->name }}</h5>
                                                    <p class="mb-0 text-muted"><small>Member Since {{ $magasin->created_at->format('Y') }}</small></p>
                                                </td>

                                                <td>
                                                    <span class="badge bg-success">{{ number_format($magasin->rate, 1) }} ⭐</span>
                                                </td>

                                                <td>
                                                    <a href="#" class="btn btn-xs btn-light"><i class="mdi mdi-eye"></i></a>
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
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
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
                
                            <h4 class="header-title mb-3">Best Selling Products</h4>
                
                            <div class="table-responsive">
                                <table class="table table-borderless table-nowrap table-hover table-centered m-0">
                
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity Sold</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bestSellingProducts as $product)
                                            <tr>
                                                <td>
                                                    <h5 class="m-0 fw-normal">{{ $product->name }}</h5>
                                                </td>
                
                                                <td>
                                                    {{ $product->orderItems->sum('quantity') }} Units
                                                </td>
                
                                                <td>
                                                    <span class="badge bg-soft-success text-success">Available</span>
                                                </td>
                
                                                <td>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-light">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->
                
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
@endsection
