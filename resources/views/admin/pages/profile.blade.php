@extends('admin.master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">My Profile</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="mdi mdi-account-outline me-1 text-primary"></i> Basic Information
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input class="form-control" type="text" name="name" placeholder="Name"
                                            value="{{ old('name', $admin->name) }}">
                                        @error('name')
                                            <span class="text-danger font-13">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input class="form-control" type="text" name="phoneNumber" placeholder="Phone"
                                            value="{{ old('phoneNumber', $admin->phoneNumber) }}">
                                        @error('phoneNumber')
                                            <span class="text-danger font-13">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input class="form-control" type="email" name="email" placeholder="Email"
                                            value="{{ old('email', $admin->email) }}">
                                        @error('email')
                                            <span class="text-danger font-13">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Profile Picture</label>
                                        <input class="form-control" type="file" name="profilePicture">
                                        @error('profilePicture')
                                            <span class="text-danger font-13">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">About You</label>
                                        <textarea name="bio" rows="4" class="form-control" placeholder="About You">{{ old('bio', $admin->bio) }}</textarea>
                                        @error('bio')
                                            <span class="text-danger font-13">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <i class="mdi mdi-content-save me-1"></i> Save Changes
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <i class="mdi mdi-lock-outline me-1 text-primary"></i> Change Password
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update.password') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Current Password</label>
                                        <input class="form-control" type="password" name="current_password"
                                            placeholder="Current Password" required>
                                        @error('current_password')
                                            <span class="text-danger font-13">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">New Password</label>
                                        <input class="form-control" type="password" name="new_password"
                                            placeholder="New Password" required>
                                        @error('new_password')
                                            <span class="text-danger font-13">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Confirm New Password</label>
                                        <input class="form-control" type="password" name="new_password_confirmation"
                                            placeholder="Confirm New Password" required>
                                        @error('new_password_confirmation')
                                            <span class="text-danger font-13">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-danger waves-effect waves-light">
                                    <i class="mdi mdi-key-change me-1"></i> Change Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="{{ $admin->profilePicture ? asset('storage/profile_pictures/' . $admin->id . '/' . $admin->profilePicture) : asset('frontend/images/No_Image.png') }}"
                                alt="Profile Image" class="img-fluid rounded-circle mb-3"
                                style="width: 140px; height: 140px; object-fit: cover;">
                            <h5 class="mb-1">{{ $admin->name }}</h5>
                            <p class="text-muted mb-0">{{ $admin->email }}</p>
                            <span class="status-badge sb-active mt-2 d-inline-block">{{ ucfirst($admin->status ?? 'active') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
