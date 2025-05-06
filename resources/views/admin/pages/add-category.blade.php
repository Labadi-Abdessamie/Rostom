@extends('admin.master')


@section('content')
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.categories') }}">Categories</a></li>
                                <li class="breadcrumb-item active">Add Category</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Add Category</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('admin.store_category') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="category-name" class="form-label">Category name</label>
                                            <input type="text" id="category-name" name="name" class="form-control"
                                                placeholder="Enter category name" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="category-status" class="form-label">Status</label>
                                            <select id="category-status" name="status" class="form-select">
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="inactive"
                                                    {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="category-parent" class="form-label">Parent Category</label>
                                            <select id="category-parent" name="parent" class="form-select">
                                                <option value="">Select it as Main Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @if ($category->childrens->count() > 0)
                                                        @foreach ($category->childrens as $child)
                                                            <option value="{{ $child->id }}">{{ $category->name }} >
                                                                {{ $child->name }}</option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-xl-6 text-center">
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                class="fe-check-circle me-1"></i> Add category</button>
                                        <a href="{{ route('admin.categories') }}"
                                            class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
                                            Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
