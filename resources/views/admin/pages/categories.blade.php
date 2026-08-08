@extends('admin.master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <!-- Page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Categories</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('admin.add_category') }}" class="btn btn-primary waves-effect waves-light mb-3"><i
                                    class="mdi mdi-plus-circle me-1"></i>
                                Add Category</a>
                            <div class="table-responsive">
                                <table class="table table-hover table-centered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            @include('admin.pages.category_row', ['category' => $category, 'level' => 0])
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
