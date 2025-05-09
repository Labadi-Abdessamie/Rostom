@extends('admin.master')


@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- Page Title -->
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
                        <h4 class="page-title">Magasins</h4>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- Top Bar -->
                            <div class="row justify-content-between mb-3">
                                <div class="col-md-6">
                                    <form class="search-bar position-relative">
                                        <input type="text" class="form-control" placeholder="Search...">
                                        <span class="mdi mdi-magnify"></span>
                                    </form>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-centered table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Store Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Rate</th>
                                            <th>Location</th>
                                            <th>Owner</th>
                                            <th>Open</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($magasins as $magasin)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/magasins_images/' . $magasin->id . '/' . $magasin->magasinPicture) }}"
                                                        alt="Image" class="rounded-circle" width="40" height="40">
                                                </td>
                                                <td>{{ $magasin->name }}</td>
                                                <td>{{ $magasin->phoneNumber }}</td>
                                                <td>{{ $magasin->email }}</td>
                                                <td><i class="mdi mdi-star text-warning"></i> {{ $magasin->rate }}</td>
                                                <td>{{ $magasin->location }}</td>
                                                <td>
                                                    @if ($magasin->user)
                                                        <strong>{{ $magasin->user->name }}</strong><br>
                                                        <small>{{ $magasin->user->email }}</small>
                                                    @else
                                                        <em>No Owner</em>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($magasin->magasinOpen)
                                                        <span class="badge bg-success">Open</span>
                                                    @else
                                                        <span class="badge bg-danger">Closed</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($magasin->status === 'blocked')
                                                        <span class="badge bg-danger">Blocked</span>
                                                    @elseif ($magasin->status === 'inactive')
                                                        <span class="badge bg-warning">Inactive</span>
                                                    @elseif ($magasin->status === 'firstOpening')
                                                        <span class="badge bg-warning">First Opening</span>
                                                    @elseif ($magasin->status === 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary">{{ ucfirst($magasin->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($filtre === 'demands')
                                                        <a href="{{ route('admin.show.register', $magasin->id) }}"
                                                            target="_blank" class="btn btn-sm btn-primary">Register
                                                        </a>
                                                        <form action="{{ route('admin.approve.magasin', $magasin->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                onclick="return confirm('Approve this store?')">
                                                                Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.reject.magasin', $magasin->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Reject this store?')">
                                                                Reject
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('admin.edit.magasin', $magasin->id) }}"
                                                            class="action-icon">
                                                            <i class="mdi mdi-square-edit-outline"></i>
                                                        </a>
                                                        <form action="{{ route('admin.delete.magasin', $magasin->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="action-icon btn btn-link p-0 text-danger"
                                                                onclick="return confirm('Are you sure?')">
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

                            <!-- Pagination -->
                            <div class="mt-3 d-flex justify-content-end">
                                {{ $magasins->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
