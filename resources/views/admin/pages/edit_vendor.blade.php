@extends('admin.master')

@section('content')
    <div class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Edit Vendor</h4>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Vendor Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $vendor->name }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $vendor->email }}" readonly>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="phone" id="phone" name="phone" class="form-control" value="{{ $vendor->phoneNumber }}" readonly>
                </div>

                <div class="form-group">
                    <label for="vendorStatus">Status</label>
                    <select name="vendorStatus" id="vendorStatus" class="form-control" required>
                        <option value="active" {{ $vendor->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $vendor->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="blocked" {{ $vendor->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="client" {{ $vendor->role == 'client' ? 'selected' : '' }}>Client</option>
                        <option value="vendor" {{ $vendor->role == 'vendor' ? 'selected' : '' }}>Vendor</option>
                        <option value="admin" {{ $vendor->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Vendor</button>
            </form>
        </div>
    </div>
@endsection
