@extends('admin.master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="page-title">Edit Banner</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.banners') }}">Banners</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('admin.update_banner', $banner->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $banner->title) }}" required>
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3" required>{{ old('description', $banner->description) }}</textarea>
                                </div>

                                <!-- Image -->
                                <div class="mb-3">
                                    <label class="form-label">Current Image</label><br>
                                    @if ($banner->image)
                                        <img src="{{ asset('storage/' . $banner->image) }}" alt="Current Banner"
                                            class="img-thumbnail mb-2" width="200">
                                    @else
                                        <p class="text-muted">No image uploaded</p>
                                    @endif
                                    <input type="file" name="image" class="form-control mt-2">
                                </div>

                                <!-- Link -->
                                <div class="mb-3">
                                    <label for="link" class="form-label">Link (optional)</label>
                                    <input type="url" name="link" class="form-control"
                                        value="{{ old('link', $banner->link) }} ">
                                </div>

                                <!-- Page -->
                                <div class="mb-3">
                                    <label for="page" class="form-label">Page</label>
                                    <input type="text" name="page" class="form-control"
                                        value="{{ old('page', $banner->page) }}" required>
                                </div>

                                <!-- Position -->
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position</label>
                                    <input type="text" name="position" class="form-control"
                                        value="{{ old('position', $banner->position) }}" required>
                                </div>

                                <!-- Type -->
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select name="type" class="form-select" required>
                                        <option value="normal" {{ $banner->type === 'normal' ? 'selected' : '' }}>Normal
                                        </option>
                                        <option value="cooldown" {{ $banner->type === 'cooldown' ? 'selected' : '' }}>
                                            Cooldown</option>
                                    </select>
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="active" {{ $banner->status === 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ $banner->status === 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>

                                <!-- Submit -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="mdi mdi-content-save"></i> Update Banner
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
