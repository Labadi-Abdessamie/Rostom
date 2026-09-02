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

                            {{-- ── Advanced Filter Panel ── --}}
                            <div class="mb-4" style="border:1px solid #e2e8f0; border-radius:12px; padding:16px 20px; background:#f8fafc;">
                                <form method="GET" action="{{ url()->current() }}" id="filterForm">
                                    <input type="hidden" name="type" value="{{ $type ?? '' }}">

                                    <div class="row g-3 align-items-end">

                                        {{-- Text Search --}}
                                        <div class="col-md-3 col-sm-6">
                                            <label class="form-label small fw-semibold text-muted mb-1">Search</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Name, email or phone..."
                                                    value="{{ $search ?? '' }}">
                                            </div>
                                        </div>

                                        {{-- Vendor Status --}}
                                        <div class="col-md-2 col-sm-6">
                                            <label class="form-label small fw-semibold text-muted mb-1">Vendor Status</label>
                                            <select name="status" class="form-select">
                                                <option value="">All</option>
                                                <option value="active"   {{ ($status ?? '') === 'active'   ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ ($status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                <option value="blocked"  {{ ($status ?? '') === 'blocked'  ? 'selected' : '' }}>Blocked</option>
                                            </select>
                                        </div>

                                        {{-- Magasin Status --}}
                                        <div class="col-md-2 col-sm-6">
                                            <label class="form-label small fw-semibold text-muted mb-1">Magasin Status</label>
                                            <select name="magasin_status" class="form-select">
                                                <option value="">All</option>
                                                <option value="active"       {{ ($magasinStatus ?? '') === 'active'       ? 'selected' : '' }}>Active</option>
                                                <option value="firstOpening" {{ ($magasinStatus ?? '') === 'firstOpening' ? 'selected' : '' }}>Pending Approval</option>
                                                <option value="inactive"     {{ ($magasinStatus ?? '') === 'inactive'     ? 'selected' : '' }}>Inactive</option>
                                                <option value="blocked"      {{ ($magasinStatus ?? '') === 'blocked'      ? 'selected' : '' }}>Blocked</option>
                                            </select>
                                        </div>

                                        {{-- Date From --}}
                                        <div class="col-md-2 col-sm-6">
                                            <label class="form-label small fw-semibold text-muted mb-1">From Date</label>
                                            <input type="date" name="date_from" class="form-control"
                                                value="{{ $dateFrom ?? '' }}">
                                        </div>

                                        {{-- Date To --}}
                                        <div class="col-md-2 col-sm-6">
                                            <label class="form-label small fw-semibold text-muted mb-1">To Date</label>
                                            <input type="date" name="date_to" class="form-control"
                                                value="{{ $dateTo ?? '' }}">
                                        </div>

                                        {{-- Sort By --}}
                                        <div class="col-md-2 col-sm-6">
                                            <label class="form-label small fw-semibold text-muted mb-1">Sort By</label>
                                            <div class="input-group">
                                                <select name="sort_by" class="form-select">
                                                    <option value="created_at"  {{ ($sortBy ?? 'created_at') === 'created_at'  ? 'selected' : '' }}>Date</option>
                                                    <option value="name"        {{ ($sortBy ?? '') === 'name'        ? 'selected' : '' }}>Name</option>
                                                    <option value="email"       {{ ($sortBy ?? '') === 'email'       ? 'selected' : '' }}>Email</option>
                                                    <option value="phoneNumber" {{ ($sortBy ?? '') === 'phoneNumber' ? 'selected' : '' }}>Phone</option>
                                                </select>
                                                <button type="button" class="btn btn-outline-secondary" id="sortDirToggle" title="Toggle order">
                                                    <i class="mdi {{ ($sortDir ?? 'desc') === 'asc' ? 'mdi-sort-ascending' : 'mdi-sort-descending' }}"></i>
                                                </button>
                                            </div>
                                            <input type="hidden" name="sort_dir" id="sortDirInput" value="{{ $sortDir ?? 'desc' }}">
                                        </div>

                                        {{-- Actions --}}
                                        <div class="col-md-3 col-sm-6 d-flex gap-2 align-items-end mt-3">
                                            <button type="submit" class="btn btn-primary flex-grow-1">
                                                <i class="mdi mdi-filter-variant me-1"></i> Apply Filters
                                            </button>
                                            <a href="{{ url()->current() }}{{ $type ? '/' . $type : '' }}" class="btn btn-outline-secondary">
                                                <i class="mdi mdi-refresh"></i>
                                            </a>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            {{-- Per Page + Active Filters Summary --}}
                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2" id="perPageForm">
                                        <input type="hidden" name="search"     value="{{ $search ?? '' }}">
                                        <input type="hidden" name="status"    value="{{ $status ?? '' }}">
                                        <input type="hidden" name="magasin_status" value="{{ $magasinStatus ?? '' }}">
                                        <input type="hidden" name="date_from" value="{{ $dateFrom ?? '' }}">
                                        <input type="hidden" name="date_to"   value="{{ $dateTo ?? '' }}">
                                        <input type="hidden" name="sort_by"   value="{{ $sortBy ?? 'created_at' }}">
                                        <input type="hidden" name="sort_dir"  value="{{ $sortDir ?? 'desc' }}">
                                        <input type="hidden" name="type"      value="{{ $type ?? '' }}">
                                        <label class="text-muted small mb-0">Show</label>
                                        <select name="per_page" class="form-select form-select-sm" style="width:auto;" onchange="document.getElementById('perPageForm').submit()">
                                            <option value="10"  {{ ($perPage ?? 10) == 10   ? 'selected' : '' }}>10</option>
                                            <option value="25"  {{ ($perPage ?? 10) == 25   ? 'selected' : '' }}>25</option>
                                            <option value="50"  {{ ($perPage ?? 10) == 50   ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ ($perPage ?? 10) == 100  ? 'selected' : '' }}>100</option>
                                            <option value="all" {{ ($perPage ?? 10) == 'all' ? 'selected' : '' }}>All</option>
                                        </select>
                                        <span class="text-muted small">per page</span>
                                    </form>

                                    @if($vendors->total() > 0)
                                        <span class="badge bg-light text-dark border">
                                            {{ $vendors->total() }} vendor{{ $vendors->total() == 1 ? '' : 's' }} found
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Table --}}
                            <div class="table-responsive" style="overflow-x:auto;">
                                <table class="table table-centered table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Vendor</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Magasin</th>
                                            <th>Create Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($vendors as $vendor)
                                            <tr>
                                                <td class="text-muted">{{ $loop->iteration + ($vendors->currentPage() - 1) * $vendors->perPage() }}</td>
                                                <td class="table-user">
                                                    <img src="{{ $vendor->profilePicture
                                                        ? asset('storage/profile_pictures/' . $vendor->id . '/' . $vendor->profilePicture)
                                                        : asset('frontend/images/No_Image.png') }}"
                                                        alt="vendor-image" class="me-2 rounded-circle" width="32" height="32">
                                                    <a href="{{ route('admin.edit_user', ['id' => $vendor->id]) }}?return_url={{ urlencode(url()->full()) }}"
                                                        class="text-body fw-semibold">{{ $vendor->name }}</a>
                                                </td>
                                                <td>{{ $vendor->email }}</td>
                                                <td>{{ $vendor->phoneNumber ?? '—' }}</td>
                                                <td>
                                                    @if($vendor->magasin)
                                                        <a href="{{ route('admin.magasins') }}?search={{ urlencode($vendor->magasin->name) }}"
                                                            class="text-primary text-decoration-none">
                                                            {{ $vendor->magasin->name }}
                                                        </a>
                                                        <br>
                                                        <small class="text-muted">{{ $vendor->magasin->address ?? '—' }}</small>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td>{{ $vendor->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    @php
                                                        $magasinStatus = $vendor->magasin->status ?? null;
                                                        $userStatus    = $vendor->status;
                                                    @endphp
                                                    @if ($magasinStatus === 'firstOpening')
                                                        <span class="badge" style="background:#fef3c7;color:#92400e;">Pending Approval</span>
                                                    @elseif ($userStatus === 'active')
                                                        <span class="badge bg-soft-success text-success">Active</span>
                                                    @elseif ($userStatus === 'inactive')
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
                                                            onclick="return confirm('Are you sure you want to delete this vendor?');">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-4">
                                                    <i class="fas fa-search fa-2x mb-2 d-block opacity-50"></i>
                                                    No vendors found matching your filters.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            @if ($vendors->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                                    <div class="text-muted" style="font-size:.85rem;">
                                        Showing {{ $vendors->firstItem() ?? 0 }}–{{ $vendors->lastItem() ?? 0 }} of {{ $vendors->total() }}
                                    </div>
                                    {{ $vendors->links() }}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Toggle sort direction button
    document.getElementById('sortDirToggle')?.addEventListener('click', function () {
        const input = document.getElementById('sortDirInput');
        const icon  = this.querySelector('i');
        const current = input.value;
        const next = current === 'asc' ? 'desc' : 'asc';
        input.value = next;
        icon.className = next === 'asc' ? 'mdi mdi-sort-ascending' : 'mdi mdi-sort-descending';
    });
</script>
@endpush
