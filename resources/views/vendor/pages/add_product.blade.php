@extends('vendor.master')

@section('title', 'Vendor | Add Product')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/jquery-selectric/selectric.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('vendor/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('vendor/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>


    <script>
        $('#category_id').selectric({
            onChange: function(element) {
                if (element.value != "") {
                    $('#subcategory_wrapper').removeClass('d-none');
                    $('option').each(function() {
                        if ($(this).hasClass(element.value)) {
                            $(this).removeClass('d-none');
                        } else {
                            $(this).addClass('d-none');
                        }
                    });
                } else {
                    $('#subcategory_wrapper').addClass('d-none');
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            $.uploadPreview({
                input_field: "#image-upload",
                preview_box: "#image-preview",
                label_field: "#image-label",
                label_default: "Choose Image",
                label_selected: "Change Image",
                no_label: false,
                success_callback: null
            });

            $('.summernote-simple').summernote({
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            //document.getElementById("category_id").addEventListener("change", updateSubCategories);

            //$('.selectric').selectric();
            //setTimeout(updateSubSubCategories, 100);
        });
    </script>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Add New Product</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item"><a href="{{ route('vendor.products') }}">Products</a>
                </div>
                <div class="breadcrumb-item">Add Product</div>
            </div>
        </div>

        <div class="section-body">
            <form action="{{ route('vendor.store_product') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>Product Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3">Product Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3">Short Description</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="short_description" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3">Long Description</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea name="long_description" class="form-control"></textarea>
                            </div>
                        </div>
                        {{--
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3">Quantity</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" name="actual_quantity" class="form-control" required>
                            </div>
                        </div>
                        --}}

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3">Price</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" step="0.01" name="price" class="form-control" min="1"
                                    required>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3">Product Image</label>
                            <div class="col-sm-12 col-md-7">
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="principalImage" id="image-upload" accept="image/*" required>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3">Subcategory</label>
                            <div class="col-sm-12 col-md-7">
                                <select name="category" id="category_id" class="form-control selectric" required>
                                    <option value="">-- Select Subcategory --</option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4 " id="subcategory_wrapper">
                            <label class="col-form-label text-md-right col-12 col-md-3">Final Category</label>
                            <div class="col-sm-12 col-md-7">
                                <select name="subcategory" id="subcategory_id" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($finalCategories as $key => $finalCategory)
                                        @foreach ($finalCategory as $category)
                                            <option class="{{ $key }} d-none" value="{{ $category->id }}">
                                                {{ $category->name }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row mb-4">
                            <div class="col-sm-12 col-md-7 offset-md-3">
                                <button type="submit" class="btn btn-primary">Add Product</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
