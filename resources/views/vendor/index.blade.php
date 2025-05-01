@extends('vendor.master')

@section('title', 'Vendor Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('vendor/modules/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/chart.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('vendor/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('vendor/js/page/index.js') }}"></script>
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">

                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Products</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalProducts }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="balance-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Balance</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($totalEarnings) }} DZD
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="sales-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Sales</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalCompletedOrders }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Stats Chart -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Order Statistics</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" height="158"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card gradient-bottom">
                    <div class="card-header">
                        <h4>Top 5 Products</h4>
                    </div>
                    <div class="card-body">
                        <div class="owl-carousel owl-theme" id="products-carousel">
                            <!-- You can dynamically list your products here -->
                            @foreach ($topProducts as $product)
                                <div>
                                    <div class="product-item">
                                        <div class="product-image">
                                            <img alt="image"
                                                src="{{ asset('storage/products_images/' . $product->id . '/' . $product->principalImage) }}"
                                                class="img-fluid">
                                        </div>
                                        <div class="product-details">
                                            <div class="product-name">{{ $product->name }}</div>
                                            <div class="product-review">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i
                                                        class="{{ $i < $product->rate_average ? 'fas' : 'far' }} fa-star"></i>
                                                @endfor
                                            </div>
                                            <div class="text-muted text-small">{{ $product->rate_count }} Counts</div>
                                            <div class="product-cta">
                                                <a href="{{ route('frontend.product_details', ['id' => $product->id]) }}"
                                                    class="btn btn-primary">Detail</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
