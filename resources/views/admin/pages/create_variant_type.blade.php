@extends('admin.master')

@section('title', 'Admin || Create Variant Type')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Create Variant Type</h4>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.variant_types') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.variant_type_store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Name (internal, unique)</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Color" value="{{ old('name') }}" required>
                                <small class="text-muted">Used internally — must be unique.</small>
                            </div>
                            <div class="form-group">
                                <label>Display Name</label>
                                <input type="text" name="display_name" class="form-control" placeholder="e.g. Couleur" value="{{ old('display_name') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select name="type" class="form-control" required>
                                    <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                                    <option value="color_swatch" {{ old('type') == 'color_swatch' ? 'selected' : '' }}>Color Swatch</option>
                                    <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Predefined Options (comma-separated, optional)</label>
                                <input type="text" name="options" class="form-control" placeholder="e.g. Red, Blue, Green" value="{{ old('options') }}">
                                <small class="text-muted">Used for color_swatch type. Leave empty for free-text.</small>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="hidden" name="required" value="0">
                                    <input type="checkbox" name="required" value="1" {{ old('required', 1) ? 'checked' : '' }}>
                                    Required
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Position</label>
                                <input type="number" name="position" class="form-control" value="{{ old('position', 0) }}" min="0">
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('admin.variant_types') }}" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
