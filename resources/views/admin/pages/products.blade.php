@extends('admin.master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- Page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        @if (false)
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">Products</li>
                                </ol>
                            </div>
                        @endif
                        <h4 class="page-title">Products</h4>
                    </div>
                </div>
            </div>

            <!-- Product count -->
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info">
                        Total Products: {{ $totalProducts }}
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card product-box">
                            <div class="card-body">

                                <!-- Delete Button -->
                                <div class="product-action">
                                    <form action="{{ route('admin.delete_product', $product->id) }}" method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs waves-effect waves-light">
                                            <i class="mdi mdi-close"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Product Image -->
                                <div class="bg-light">
                                    <img src="{{ asset('storage/products_images/' . $product->id . '/' . $product->principalImage) }}"
                                        alt="product-pic" class="img-fluid" />
                                </div>

                                <div class="product-info">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="font-16 mt-0 sp-line-1">
                                                <a href="{{ route('frontend.product_details', $product->id) }}"
                                                    class="text-dark">
                                                    {{ $product->name }}
                                                </a>
                                            </h5>

                                            <!-- Magasin name as clickable link -->
                                            <div class="text-muted mb-2 font-13">
                                                <strong>Magasin:</strong>
                                                @if ($product->magasin)
                                                    <a href="{{ route('frontend.vendor_details', $product->magasin->id) }}"
                                                        class="text-dark">
                                                        {{ $product->magasin->name }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">No Magasin</span>
                                                @endif
                                            </div>

                                            <!-- Rating stars -->
                                            <div class="text-warning mb-2 font-13">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa fa-star{{ $i < $product->rate_average ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>

                                            <h5 class="m-0">
                                                <span class="text-muted">Stocks: {{ $product->actual_quantity }}</span>
                                            </h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="product-price-tag">
                                                ${{ $product->price }}
                                            </div>
                                        </div>
                                    </div> <!-- end row -->
                                </div> <!-- end product info-->



                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="row">
                <div class="col-12">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>
@endsection
