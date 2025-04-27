@extends('client.master')

@section('title')
    Dashboard || Profile
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <h3><i class="far fa-user"></i> Profile</h3>

                <!-- Display Success/Error Messages -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">
                        <h4>Basic Information</h4>
                        <!-- Profile Update Form -->
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-xl-9">
                                    <div class="row">
                                        <!-- Name -->
                                        <div class="col-xl-12 col-md-12">
                                            <div class="wsus__dash_pro_single">
                                                <i class="fas fa-user-tie"></i>
                                                <input type="text" name="name" placeholder="Name"
                                                    value="{{ old('name', $data['name']) }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Phone Number -->
                                        <div class="col-xl-6 col-md-6">
                                            <div class="wsus__dash_pro_single">
                                                <i class="far fa-phone-alt"></i>
                                                <input type="text" name="phoneNumber" placeholder="Phone"
                                                    value="{{ old('phoneNumber', $data['phoneNumber']) }}">
                                                @error('phoneNumber')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-xl-6 col-md-6">
                                            <div class="wsus__dash_pro_single">
                                                <i class="fal fa-envelope-open"></i>
                                                <input type="email" name="email" placeholder="Email"
                                                    value="{{ old('email', $data['email']) }}">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Bio -->
                                        <div class="col-xl-12">
                                            <div class="wsus__dash_pro_single">
                                                <textarea name="bio" cols="3" rows="5" placeholder="About You">{{ old('bio', $data['bio']) }}</textarea>
                                                @error('bio')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile Picture -->
                                <div class="col-xl-3 col-sm-6 col-md-6">
                                    <div class="wsus__dash_pro_img">
                                        <img src="{{ Auth::user()->profilePicture ? asset('storage/profile_pictures/' . Auth::id() . '/' . Auth::user()->profilePicture) : asset('frontend/images/No_Image.png') }}"
                                            alt="Profile Image" class="img-fluid w-100">
                                        <input type="file" name="profilePicture">
                                        @error('profilePicture')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-xl-12">
                                    <button class="common_btn mb-4 mt-2" type="submit">Update Profile</button>
                                </div>
                            </div>
                        </form>
                        <div class="wsus__dash_pass_change mt-4">
                            <h4>Change Password</h4>
                            <!-- Password Change Form -->
                            <form action="{{ route('profile.update.password') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <!-- Current Password -->
                                    <div class="col-xl-4 col-md-6">
                                        <div class="wsus__dash_pro_single">
                                            <i class="fas fa-unlock-alt"></i>
                                            <input type="password" name="current_password" placeholder="Current Password"
                                                required>
                                        </div>
                                    </div>

                                    <!-- New Password -->
                                    <div class="col-xl-4 col-md-6">
                                        <div class="wsus__dash_pro_single">
                                            <i class="fas fa-lock-alt"></i>
                                            <input type="password" name="new_password" placeholder="New Password" required>
                                        </div>
                                    </div>

                                    <!-- Confirm New Password -->
                                    <div class="col-xl-4">
                                        <div class="wsus__dash_pro_single">
                                            <i class="fas fa-lock-alt"></i>
                                            <input type="password" name="new_password_confirmation"
                                                placeholder="Confirm New Password" required>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-xl-12">
                                        <button class="common_btn" type="submit">Change Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
