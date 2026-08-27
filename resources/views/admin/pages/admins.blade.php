@extends('admin.master')

@section('styles')
    <link href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection

@section('scripts')
    <!-- third party js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js') }}"></script>
    <!-- third party js ends -->

    <!-- Datatables init -->
    <script src="{{ asset('assets/js/pages/customers.init.js') }}"></script>
@endsection

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Admins</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Admins</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-4 mb-3">
                                    <button type="button" class="btn btn-danger waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#custom-modal"><i
                                            class="mdi mdi-plus-circle me-1"></i> Add Admin</button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                        <thead>
                                            <tr>
                                                <th style="width: 20px;">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="customCheck1">
                                                        <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                    </div>
                                                </th>
                                                <th>Admin</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Create Date</th>
                                                <th>Status</th>
                                                <th style="width: 85px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($admins as $admin)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="customCheck{{ $loop->index + 2 }}">
                                                            <label class="form-check-label"
                                                                for="customCheck{{ $loop->index + 2 }}">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td class="table-user">
                                                        <img src="{{ $admin->profilePicture ? asset('storage/profile_pictures/' . $admin->id . '/' . $admin->profilePicture) : asset('frontend/images/No_Image.png') }}"
                                                            alt="admin-image" class="me-2 rounded-circle">
                                                        <a href="{{ $admin->id == Auth::id() ? route('admin.profile') : route('admin.edit_user', ['id' => $admin->id]) }}"
                                                            class="text-body fw-semibold">{{ $admin->name }}</a>
                                                    </td>
                                                    <td>{{ $admin->phoneNumber }}</td>
                                                    <td>{{ $admin->email }}</td>
                                                    <td>{{ $admin->role }}</td>
                                                    <td>{{ $admin->created_at->format('m/d/Y') }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $admin->status == 'active' ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }}">
                                                            {{ $admin->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ $admin->id == Auth::id() ? route('admin.profile') : route('admin.edit_user', ['id' => $admin->id]) }}"
                                                            class="action-icon"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a>
                                                        @if ($admin->id == Auth::id())
                                                        @else
                                                            <form
                                                                action="{{ route('admin.delete_user', ['id' => $admin->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn action-icon">
                                                                    <i class="mdi mdi-delete"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <ul class="pagination pagination-rounded justify-content-end mb-0">
                                    {{ $admins->links() }}
                                </ul>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container -->

        </div> <!-- content -->
        @include('admin.pages.add-admin')
    @endsection
