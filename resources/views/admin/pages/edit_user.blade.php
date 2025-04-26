@extends('admin.master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Edit {{ $type }}</h4>
                    </div>
                </div>
            </div>
            <form action="{{ route('admin.update_user', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-2">
                    <label for="name">{{ $type }} Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}"
                        required>
                </div>

                <div class="form-group mb-2">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}"
                        readonly>
                </div>

                <div class="form-group mb-2">
                    <label for="phone">Phone Number</label>
                    <input type="phone" id="phone" name="phoneNumber" class="form-control"
                        value="{{ $user->phoneNumber }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="userStatus" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="userStatus" name="status"
                        required>
                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="blocked" {{ $user->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update {{ $type }}</button>
            </form>
        </div>
    </div>
@endsection
