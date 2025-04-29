@extends('vendor.master')

@section('title', 'Vendor | Reviews')

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
    <script src="{{ asset('vendor/js/page/modules-datatables.js') }}"></script>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Reviews</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Reviews</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Total Reviews: {{ $totalReviews }} | Average Rating: {{ number_format($averageRating, 2) }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Id</th>
                                            <th>Product Name</th>
                                            <th>Customer Name</th>
                                            <th>Rate</th>
                                            <th>Content</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reviews as $review)
                                            <tr>
                                                <td class="text-center">{{ $review->id }}</td>
                                                <td>{{ $review->product->name ?? 'N/A' }}</td>
                                                <td>{{ $review->user->name ?? 'Anonymous' }}</td>
                                                <td class="text-center">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= floor($review->rate))
                                                            <i class="fas fa-star text-warning"></i>
                                                        @elseif ($i - $review->rate < 1)
                                                            <i class="fas fa-star-half-alt text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                    <small>({{ number_format($review->rate, 1) }})</small>
                                                </td>
                                                <td>{{ $review->content }}</td>
                                                <td>
                                                    <a href="{{ route('frontend.product_details', ['id' => $review->product->id]) }}" class="btn btn-secondary" target="_blank">
                                                        Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if($reviews->isEmpty())
                                            <tr>
                                                <td colspan="6" class="text-center">No reviews found.</td>
                                            </tr>
                                        @endif
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
