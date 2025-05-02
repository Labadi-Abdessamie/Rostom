@extends('vendor.master')

@section('title', 'Vendor | Products')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('vendor/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                                            <th class="text-center">ID</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Average Rate</th>
                                            <th>Ordered Times</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $product)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                {{-- Enumeration --}}
                                                <td class="text-center">
                                                    @if ($product->principalImage)
                                                        <img src="{{ asset('storage/products_images/' . $product->id . '/' . $product->principalImage) }}"
                                                            alt="Product Image" width="50" height="50"
                                                            style="object-fit: cover;">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ number_format($product->price, 2) }}</td>
                                                <td class="text-center">
                                                    {{ $product->actual_quantity ?? 0 }}</td>
                                                <td class="text-center">
                                                    @if ($product->rate_average)
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= round($product->rate_average))
                                                                <i class="fas fa-star text-warning"></i>
                                                            @else
                                                                <i class="far fa-star text-warning"></i>
                                                            @endif
                                                        @endfor
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                    / {{ $product->rate_count ?? 0 }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $product->order_items_sum_quantity ?? 0 }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('frontend.product_details', $product->id) }}"
                                                        class="btn btn-info btn-sm mr-2" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('vendor.edit_product', $product->id) }}"
                                                        class="btn btn-primary btn-sm mr-2" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('vendor.delete_product', $product->id) }}"
                                                        method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this product?')"
                                                            title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">
                                                    No products found.
                                                </td>
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
    </section>
@endsection
