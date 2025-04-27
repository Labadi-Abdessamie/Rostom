@extends('admin.master')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Profile</h4>
                    </div>
                </div>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="row">
                    <div class="col-xl-9 col-md-8 col-sm-8">
                        <div class="row">
                            <!-- Name -->
                            <div class="col-xl-7 m-1">
                                <input class="form-control" type="text" name="name" placeholder="Name"
                                    value="{{ old('name', $admin->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="col-xl-5 m-1">
                                <input class="form-control" type="text" name="phoneNumber" placeholder="Phone"
                                    value="{{ old('phoneNumber', $admin->phoneNumber) }}">
                                @error('phoneNumber')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-xl-5 m-1">
                                <input class="form-control" type="email" name="email" placeholder="Email"
                                    value="{{ old('email', $admin->email) }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Bio -->
                            <div class="col-xl-6 m-1">
                                <textarea name="bio" cols="3" rows="5" class="form-control" placeholder="About You">{{ old('bio', $admin->bio) }}</textarea>
                                @error('bio')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Profile Picture -->
                    <div class="col-xl-3 col-md-4 col-sm-4 col-6">
                        <div class="wsus__dash_pro_img">
                            <img src="{{ $admin->profilePicture ? asset('storage/profile_pictures/' . $admin->id . '/' . $admin->profilePicture) : asset('frontend/images/No_Image.png') }}"
                                alt="Profile Image" class="img-fluid w-100">
                            <input type="file" name="profilePicture">
                            @error('profilePicture')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
                <button type="submit" class="m-2 btn btn-primary">Save changes</button>
            </form>
            <div class="mt-4">
                <h4>Change Password</h4>
                <!-- Password Change Form -->
                <form action="{{ route('profile.update.password') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Current Password -->
                        <div class="col-sm-5 m-1">
                            <input class="form-control" type="password" name="current_password"
                                placeholder="Current Password" required>
                            @error('current_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <!-- New Password -->
                            <div class="col-sm-5 m-1">
                                <input class="form-control" type="password" name="new_password" placeholder="New Password"
                                    required>
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Confirm New Password -->
                            <div class="col-sm-5 m-1">
                                <input class="form-control" type="password" name="new_password_confirmation"
                                    placeholder="Confirm New Password" required>
                                @error('new_password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="col-xl-12">
                            <button class="m-2 btn btn-primary" type="submit">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
