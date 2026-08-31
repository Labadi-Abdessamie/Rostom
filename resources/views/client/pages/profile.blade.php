@extends('client.master')

@section('title')
    My Profile
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="dashboard_content">
                <!-- Page Header -->
                <div class="dash-page-header">
                    <h1><i class="fas fa-user-circle"></i>My Profile</h1>
                    <p>Update your personal information</p>
                </div>

                <!-- Messages -->
                @if (session('success'))
                    <div class="dash-alert dash-alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="dash-alert dash-alert-error">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="dash-alert dash-alert-error">
                        @foreach ($errors->all() as $error)
                            <div><i class="fas fa-times-circle"></i> {{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Profile Update Section -->
                <div class="dash-card">
                    <h2><i class="fas fa-user"></i> Basic Information</h2>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <!-- Left Side - Form Fields -->
                            <div class="col-lg-8">
                                <!-- Name -->
                                <div style="margin-bottom: 20px;">
                                    <label class="dash-label">Full Name</label>
                                    <input type="text" name="name" placeholder="Your full name" class="dash-input"
                                        value="{{ old('name', $data['name']) }}">
                                    @error('name')
                                        <span class="dash-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div style="margin-bottom: 20px;">
                                    <label class="dash-label">Email Address</label>
                                    <input type="email" name="email" placeholder="Your email" class="dash-input"
                                        value="{{ old('email', $data['email']) }}">
                                    @error('email')
                                        <span class="dash-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div style="margin-bottom: 20px;">
                                    <label class="dash-label">Phone Number</label>
                                    <input type="text" name="phoneNumber" placeholder="Your phone number" class="dash-input"
                                        value="{{ old('phoneNumber', $data['phoneNumber']) }}">
                                    @error('phoneNumber')
                                        <span class="dash-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bio -->
                                <div style="margin-bottom: 20px;">
                                    <label class="dash-label">About You</label>
                                    <textarea name="bio" placeholder="Tell us about yourself" cols="3" rows="4"
                                        class="dash-textarea">{{ old('bio', $data['bio']) }}</textarea>
                                    @error('bio')
                                        <span class="dash-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Side - Profile Picture -->
                            <div class="col-lg-4" style="text-align: center;">
                                <div style="background: #f8f7ff; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
                                    <img src="{{ Auth::user()->profilePicture ? asset('storage/profile_pictures/' . Auth::id() . '/' . Auth::user()->profilePicture) : asset('frontend/images/No_Image.png') }}"
                                        alt="Profile Image" style="width: 100%; height: 250px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">

                                    <label class="dash-label">Profile Picture</label>
                                    <input type="file" name="profilePicture" accept="image/*"
                                        style="width: 100%; padding: 10px; border: 1px dashed #c7d2fe; border-radius: 8px; cursor: pointer;">
                                    <p style="color: var(--dash-muted); font-size: 12px; margin-top: 8px;">JPG, PNG (Max 2MB)</p>
                                    @error('profilePicture')
                                        <span class="dash-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #f1f5f9;">
                            <button type="submit" class="dash-btn dash-btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Section -->
                <div class="dash-card">
                    <h2><i class="fas fa-lock"></i> Change Password</h2>

                    <form action="{{ route('profile.update.password') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Current Password -->
                            <div class="col-md-6" style="margin-bottom: 20px;">
                                <label class="dash-label">Current Password</label>
                                <input type="password" name="current_password" placeholder="Enter current password" required
                                    class="dash-input">
                            </div>

                            <!-- New Password -->
                            <div class="col-md-6" style="margin-bottom: 20px;">
                                <label class="dash-label">New Password</label>
                                <input type="password" name="new_password" placeholder="Enter new password" required
                                    class="dash-input">
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6" style="margin-bottom: 20px;">
                                <label class="dash-label">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" placeholder="Confirm new password" required
                                    class="dash-input">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #f1f5f9;">
                            <button type="submit" class="dash-btn dash-btn-danger">
                                <i class="fas fa-key"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
