@extends('admin.master')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ $title }}</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- Toolbar -->
                            <form method="GET" action="{{ url()->current() }}" class="d-flex gap-2 mb-3 flex-wrap align-items-center">
                                <div class="input-group" style="max-width:360px;">
                                    <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search by name, email or phone..."
                                        value="{{ request('search') }}">
                                </div>
                                <select name="per_page" class="form-select" style="width:auto;" onchange="this.form.submit()">
                                    <option value="10" {{ request('per_page',10)==10?'selected':'' }}>10</option>
                                    <option value="20" {{ request('per_page')==20?'selected':'' }}>20</option>
                                    <option value="all" {{ request('per_page')==='all'?'selected':'' }}>All</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Apply</button>
                                <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
                            </form>

                            <div class="table-responsive" style="overflow-x:auto;">
                                <table class="table table-centered table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Vendor</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Create Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($vendors as $vendor)
                                            <tr>
                                                <td>{{ $loop->iteration + ($vendors->currentPage() - 1) * $vendors->perPage() }}</td>
                                                <td class="table-user">
                                                    <img src="{{ $vendor->profilePicture ? asset('storage/profile_pictures/' . $vendor->id . '/' . $vendor->profilePicture) : asset('frontend/images/No_Image.png') }}"
                                                        alt="vendor-image" class="me-2 rounded-circle" width="32" height="32">
                                                    <a href="{{ route('admin.edit_user', ['id' => $vendor->id]) }}?return_url={{ urlencode(url()->full()) }}"
                                                        class="text-body fw-semibold">{{ $vendor->name }}</a>
                                                </td>
                                                <td>{{ $vendor->email }}</td>
                                                <td>{{ $vendor->phoneNumber }}</td>
                                                <td>{{ $vendor->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    @php $vendorMagasinStatus = $vendor->magasin->status ?? null; @endphp
                                                    @if ($vendorMagasinStatus === 'firstOpening')
                                                        <span class="badge" style="background:#fef3c7;color:#92400e;">Pending Approval</span>
                                                    @elseif ($vendor->status == 'active')
                                                        <span class="badge bg-soft-success text-success">Active</span>
                                                    @elseif ($vendor->status == 'inactive')
                                                        <span class="badge bg-soft-warning text-warning">Inactive</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Blocked</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.edit_user', ['id' => $vendor->id]) }}?return_url={{ urlencode(url()->full()) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <form action="{{ route('admin.delete_user', $vendor->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="return_url" value="{{ url()->current() }}">
                                                        <button type="submit"
                                                            class="action-icon btn btn-link p-0 text-danger"
                                                            onclick="return confirm('Are you sure?');">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="7" class="text-center text-muted py-4">No vendors found.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if ($vendors->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="text-muted" style="font-size:.85rem;">
                                        Showing {{ $vendors->firstItem() ?? 0 }}–{{ $vendors->lastItem() ?? 0 }} of {{ $vendors->total() }}
                                    </div>
                                    {{ $vendors->withQueryString()->links() }}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
