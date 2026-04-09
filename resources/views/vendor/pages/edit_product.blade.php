@extends('vendor.master')

@section('title', 'Edit Product')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/jquery-selectric/selectric.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('vendor/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('vendor/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script>
        var finalCategoriesData = @json(collect($finalCategories)->map(fn($group) => $group->map(fn($c) => ['id' => $c->id, 'name' => $c->name])));
        var preselectedSubcat   = {{ $currentSubcategoryId ?? 'null' }};
        var preselectedFinalCat = {{ $currentSubSubcategoryId ?? 'null' }};

        function updateFinalCategories(subcatId, preselectId) {
            var select = $('#subcategory_id');
            select.find('option:not(:first)').remove();
            var options = (subcatId && finalCategoriesData[subcatId]) ? finalCategoriesData[subcatId] : [];
            if (options.length > 0) {
                $.each(options, function(i, cat) {
                    var opt = $('<option>', { value: cat.id, text: cat.name });
                    select.append(opt);
                });
                if (preselectId) { select.val(preselectId); }
                $('#subcategory_wrapper').removeClass('d-none');
            } else {
                $('#subcategory_wrapper').addClass('d-none');
            }
        }

        // Pre-populate on page load if editing an existing product
        if (preselectedSubcat) {
            updateFinalCategories(preselectedSubcat, preselectedFinalCat);
        }

        $('#category_id').selectric({
            onChange: function(element) {
                updateFinalCategories(element.value, null);
            }
        });
    </script>
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
                                    <label for="short_description">Short Description</label>
                                    <input type="text" name="short_description" class="form-control"
                                        value="{{ old('short_description', $product->short_description) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="long_description">Long Description</label>
                                    <textarea name="long_description" class="form-control">{{ old('long_description', $product->long_description) }}</textarea>
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

                                {{--
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" id="quantity"
                                        class="form-control @error('quantity') is-invalid @enderror"
                                        value="{{ old('quantity', $product->actual_quantity) }}" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                --}}

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
                                    <label class="col-form-label text-md-right col-12 col-md-3">Subcategory</label>
                                    <select name="category" id="category_id" class="form-control selectric" required>
                                        <option value="">-- Select Subcategory --</option>
                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                @if ($currentSubcategoryId == $subcategory->id) selected @endif>{{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group d-none" id="subcategory_wrapper">
                                    <label class="col-form-label text-md-right col-12 col-md-3">Final Category</label>
                                    <select name="subcategory" id="subcategory_id" class="form-control">
                                        <option value="">-- Select Category --</option>
                                    </select>
                                </div>

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

{{-- jQuery and Bootstrap are already loaded by the master layout --}}
