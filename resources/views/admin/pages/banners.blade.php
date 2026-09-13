@extends('admin.master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="page-title">Banners List</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">Banners</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Create Button -->
            <div class="row mb-4">
                <div class="col-sm-4">
                    <a href="{{ route('admin.add_banner') }}" class="btn btn-danger rounded-pill waves-effect waves-light">
                        <i class="mdi mdi-plus"></i> Create Banner
                    </a>
                </div>
            </div>

            <!-- Banners Grid -->
            <div class="row">
                @forelse ($banners as $banner)
                    <div class="col-lg-4">
                        <div class="card banner-box shadow-sm">
                            <div class="card-body position-relative">

                                <!-- Direct Edit / Delete Buttons -->
                                <div class="position-absolute top-0 end-0 mt-2 me-2 d-flex gap-1">
                                    <a href="{{ route('admin.edit_banner', $banner->id) }}" class="btn btn-xs btn-warning text-white" title="Edit" style="border-radius:8px;"><i class="mdi mdi-pencil"></i></a>
                                    <form action="{{ route('admin.delete_banner', $banner->id) }}" method="POST" onsubmit="return confirm('Delete this banner?');" class="m-0" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger" title="Delete" style="border-radius:8px;"><i class="mdi mdi-trash-can"></i></button>
                                    </form>
                                </div>

                                <!-- Banner Image -->
                                @if ($banner->image)
                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner Image"
                                        class="img-fluid mb-3 rounded shadow-sm">
                                @endif

                                <!-- Banner Details -->
                                <h5 class="mt-2">
                                    @if($banner->title)
                                        <a href="{{ $banner->link_url }}" class="text-dark fw-bold" target="_blank">{{ $banner->title }}</a>
                                    @else
                                        <span class="text-muted fst-italic">No title</span>
                                    @endif
                                </h5>
                                @if($banner->description)
                                    <p class="text-muted small">{{ Str::limit($banner->description, 60) }}</p>
                                @endif

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>Page:</strong> <span>{{ $banner->page }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>Position:</strong> <span>{{ $banner->position }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>Priority:</strong>
                                        <span class="badge bg-info">P{{ $banner->priority }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>Visibility:</strong>
                                        <span class="badge bg-{{ $banner->show_title ? 'success' : 'secondary' }}">Title {{ $banner->show_title ? 'ON' : 'OFF' }}</span>
                                        <span class="badge bg-{{ $banner->show_description ? 'success' : 'secondary' }}">Desc {{ $banner->show_description ? 'ON' : 'OFF' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>Status:</strong>
                                        <span class="badge bg-{{ $banner->status === 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($banner->status) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            <i class="mdi mdi-alert-circle-outline me-2"></i> No banners available.
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endsection
