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
                        @if (false)
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">Admin</li>
                                </ol>
                            </div>
                        @endif
                        <h4 class="page-title">Vendors</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            @if (false)
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i> Add Vendor</button>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end mt-2 mt-sm-0">
                            <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog"></i></button>
                            <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                            <button type="button" class="btn btn-light mb-2">Export</button>
                        </div>
                    </div><!-- end col-->
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                    id="products-datatable">
                                    <thead>
                                        <tr>
                                            <th class="d-none">#</th>
                                            <th>#</th>
                                            <th>Vendor</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Create Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vendors as $vendor)
                                            <tr>
                                                <td class="d-none"></td>
                                                <td>{{ $loop->iteration + ($vendors->currentPage() - 1) * $vendors->perPage() }}
                                                </td>
                                                <td class="table-user">
                                                    <img src="{{ $vendor->profilePicture ? asset('storage/profile_pictures/' . $vendor->id . '/' . $vendor->profilePicture) : asset('frontend/images/No_Image.png') }}"
                                                        alt="vendor-image" class="me-2 rounded-circle" width="32"
                                                        height="32">
                                                    <a href="{{ route('admin.edit_user', ['id' => $vendor->id]) }}"
                                                        class="text-body fw-semibold">{{ $vendor->name }}</a>
                                                </td>
                                                <td>{{ $vendor->email }}</td>
                                                <td>{{ $vendor->phoneNumber }}</td>
                                                <td>{{ $vendor->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    @if ($vendor->status == 'active')
                                                        <span class="badge bg-soft-success text-success">Active</span>
                                                    @elseif ($vendor->status == 'inactive')
                                                        <span class="badge bg-soft-warning text-warning">Inactive</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Blocked</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.edit_user', ['id' => $vendor->id]) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <form action="{{ route('admin.delete_user', $vendor->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="action-icon btn btn-link p-0 text-danger"
                                                            onclick="return confirm('Are you sure?');">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end">
                                {{ $vendors->links() }}
                            </div>

                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
@endsection
