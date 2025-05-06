@extends('admin.master')

@section('styles')
    <!-- Plugins css -->
    <link href="assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
    <!-- Plugin js -->
    <script src="assets/libs/dropzone/min/dropzone.min.js"></script>
@endsection

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- Start Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Banners</a></li>
                                <li class="breadcrumb-item active">Add Banner</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Add Banner</h4>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <!-- Add Banner Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('admin.store_banner') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <!-- Banner Title and Description -->
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="banner-title" class="form-label">Banner Title</label>
                                            <input type="text" id="banner-title" name="title" class="form-control"
                                                placeholder="Enter banner title" value="{{ old('title') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="banner-description" class="form-label">Banner Description</label>
                                            <textarea class="form-control" id="banner-description" name="description" rows="5"
                                                placeholder="Enter banner description">{{ old('description') }}</textarea>
                                        </div>
                                    </div> <!-- end col -->

                                    <!-- Banner Image Upload -->
                                    <div class="col-xl-6">
                                        <div class="my-3 mt-xl-0">
                                            <label for="banner-image" class="mb-0 form-label">Banner Image</label>
                                            <p class="text-muted font-14">Recommended image size 1920x1080 (px).</p>

                                            <div class="dropzone" id="bannerDropzone" data-plugin="dropzone"
                                                data-previews-container="#file-previews"
                                                data-upload-preview-template="#uploadPreviewTemplate">
                                                <div class="fallback">
                                                    <input name="image" type="file" />
                                                </div>

                                                <div class="dz-message needsclick">
                                                    <i class="h3 text-muted dripicons-cloud-upload"></i>
                                                    <h4>Drop files here or click to upload.</h4>
                                                </div>
                                            </div>

                                            <!-- Preview -->
                                            <div class="dropzone-previews mt-3" id="file-previews"></div>

                                            <!-- File preview template -->
                                            <div class="d-none" id="uploadPreviewTemplate">
                                                <div class="card mt-1 mb-0 shadow-none border">
                                                    <div class="p-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <img data-dz-thumbnail src="#"
                                                                    class="avatar-sm rounded bg-light" alt="">
                                                            </div>
                                                            <div class="col ps-0">
                                                                <a href="javascript:void(0);" class="text-muted fw-bold"
                                                                    data-dz-name></a>
                                                                <p class="mb-0" data-dz-size></p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <a href="javascript:void(0);"
                                                                    class="btn btn-link btn-lg text-muted" data-dz-remove>
                                                                    <i class="mdi mdi-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                                <!-- Link and Other Fields -->
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="banner-link" class="form-label">Banner Link (Optional)</label>
                                            <input type="url" id="banner-link" name="link" class="form-control"
                                                placeholder="Enter banner link (optional)" value="{{ old('link') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="banner-page" class="form-label">Page</label>
                                            <input type="text" id="banner-page" name="page" class="form-control"
                                                placeholder="Enter page" value="{{ old('page') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="banner-position" class="form-label">Position</label>
                                            <input type="text" id="banner-position" name="position"
                                                class="form-control" placeholder="Enter position"
                                                value="{{ old('position') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="banner-type" class="form-label">Type</label>
                                            <select id="banner-type" name="type" class="form-select">
                                                <option value="normal" {{ old('type') == 'normal' ? 'selected' : '' }}>
                                                    Normal</option>
                                                <option value="cooldown" {{ old('type') == 'cooldown' ? 'selected' : '' }}>
                                                    Cooldown</option>
                                            </select>
                                        </div>
                                    </div> <!-- end col -->

                                    <!-- Banner Status -->
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="banner-status" class="form-label">Status</label>
                                            <select id="banner-status" name="status" class="form-select">
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="inactive"
                                                    {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                                <!-- Submit Button -->
                                <div class="row mt-3">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                class="fe-check-circle me-1"></i> Add Banner</button>
                                        <a href="{{ route('admin.banners') }}"
                                            class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
                                            Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
@endsection
