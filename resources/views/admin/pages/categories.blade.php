@extends('admin.master')

@section('content')
    <div class="container">
        <div class="container-fluid">
            <!-- Page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        @if (false)
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">Categories</li>
                                </ol>
                            </div>
                        @endif
                        <h4 class="page-title">Categories</h4>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <a href="{{ route('admin.add_category') }}" class="btn btn-danger waves-effect waves-light mb-2"><i
                        class="mdi mdi-plus-circle me-1"></i>
                    Add Category</a>
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Created_at</th>
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
@endsection
