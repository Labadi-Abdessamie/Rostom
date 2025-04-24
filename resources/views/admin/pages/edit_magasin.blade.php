@extends('admin.master')

@section('content')
<div class="content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.magasins') }}">Magasins</a></li>
                            <li class="breadcrumb-item active">Edit Magasin</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Magasin</h4>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.update.magasin', $magasin->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Store Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Store Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $magasin->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $magasin->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-3">
                                <label for="phoneNumber" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phoneNumber') is-invalid @enderror" id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber', $magasin->phoneNumber) }}" required>
                                @error('phoneNumber')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $magasin->location) }}" required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image -->
                            <div class="mb-3">
                                <label for="magasinPicture" class="form-label">Store Image</label>
                                <input type="file" class="form-control @error('magasinPicture') is-invalid @enderror" id="magasinPicture" name="magasinPicture" accept="image/*">
                                @error('magasinPicture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if($magasin->magasinPicture)
                                    <div class="mt-2">
                                        <label>Current Image:</label><br>
                                        <img src="{{ asset('storage/' . $magasin->magasinPicture) }}" alt="Current Image" width="150">
                                    </div>
                                @endif
                            </div>

                            <!-- Rate -->
                            <div class="mb-3">
                                <label for="rate" class="form-label">Rate</label>
                                <input type="number" class="form-control @error('rate') is-invalid @enderror" id="rate" name="rate" min="0" max="5" step="0.1" value="{{ old('rate', $magasin->rate) }}">
                                @error('rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Open -->
                            <div class="mb-3">
                                <label for="magasinOpen" class="form-label">Is Open?</label>
                                <select class="form-select @error('magasinOpen') is-invalid @enderror" id="magasinOpen" name="magasinOpen" required>
                                    <option value="1" {{ $magasin->magasinOpen ? 'selected' : '' }}>Open</option>
                                    <option value="0" {{ !$magasin->magasinOpen ? 'selected' : '' }}>Closed</option>
                                </select>
                                @error('magasinOpen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="magasinStatus" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="magasinStatus" name="status" required>
                                    <option value="active" {{ $magasin->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $magasin->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="blocked" {{ $magasin->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update Magasin</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
