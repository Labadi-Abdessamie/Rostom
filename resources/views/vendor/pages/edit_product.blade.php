@extends('vendor.master')

@section('title', 'Edit Product')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/font-awesome/css/font-awesome.min.css') }}">
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Product</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('vendor.products') }}">Products</a></div>
                <div class="breadcrumb-item active">Edit Product</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('vendor.update_product', $product->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Product Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" id="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price', $product->price) }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" id="quantity"
                                        class="form-control @error('quantity') is-invalid @enderror"
                                        value="{{ old('quantity', $product->actual_quantity) }}" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="principalImage">Product Image</label>
                                    <input type="file" name="principalImage" id="principalImage"
                                        class="form-control @error('principalImage') is-invalid @enderror">
                                    @error('principalImage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if ($product->principalImage)
                                    <div class="form-group">
                                        <label for="current_image">Current Image</label><br>
                                        <img src="{{ asset('storage/products_images/' . $product->id . '/' . $product->principalImage) }}"
                                            alt="Current Product Image" width="150">
                                    </div>
                                @endif

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update Product</button>
                                    <a href="{{ route('vendor.products') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/modules/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/bootstrap/js/bootstrap.min.js') }}"></script>
@endsection
