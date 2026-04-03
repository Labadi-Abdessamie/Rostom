@extends('client.master')

@section('title')
    My Profile
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content">
                <!-- Page Header -->
                <div style="margin-bottom: 30px;">
                    <h1 style="font-size: 26px; font-weight: 700; color: #1a237e; margin-bottom: 8px;">
                        <i class="fas fa-user-circle" style="margin-right: 10px; color: #3498db;"></i>My Profile
                    </h1>
                    <p style="color: #7f8c8d; margin: 0;">Update your personal information</p>
                </div>

                <!-- Messages -->
                @if (session('success'))
                    <div style="background: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; padding: 15px; margin-bottom: 20px; color: #155724;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 15px; margin-bottom: 20px; color: #721c24;">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 15px; margin-bottom: 20px; color: #721c24;">
                        @foreach ($errors->all() as $error)
                            <div><i class="fas fa-times-circle"></i> {{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Profile Update Section -->
                <div style="background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 30px;">
                    <h2 style="font-size: 20px; font-weight: 700; color: #1a237e; margin-bottom: 25px;">
                        <i class="fas fa-user"></i> Basic Information
                    </h2>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <!-- Left Side - Form Fields -->
                            <div class="col-lg-8">
                                <!-- Name -->
                                <div style="margin-bottom: 20px;">
                                    <label style="display: block; margin-bottom: 8px; color: #1a237e; font-weight: 600;">Full Name</label>
                                    <input type="text" name="name" placeholder="Your full name" 
                                        value="{{ old('name', $data['name']) }}"
                                        style="width: 100%; padding: 12px; border: 1px solid #bdc3c7; border-radius: 5px; font-size: 14px; box-sizing: border-box;">
                                    @error('name')
                                        <span style="color: #e74c3c; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div style="margin-bottom: 20px;">
                                    <label style="display: block; margin-bottom: 8px; color: #1a237e; font-weight: 600;">Email Address</label>
                                    <input type="email" name="email" placeholder="Your email" 
                                        value="{{ old('email', $data['email']) }}"
                                        style="width: 100%; padding: 12px; border: 1px solid #bdc3c7; border-radius: 5px; font-size: 14px; box-sizing: border-box;">
                                    @error('email')
                                        <span style="color: #e74c3c; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div style="margin-bottom: 20px;">
                                    <label style="display: block; margin-bottom: 8px; color: #1a237e; font-weight: 600;">Phone Number</label>
                                    <input type="text" name="phoneNumber" placeholder="Your phone number" 
                                        value="{{ old('phoneNumber', $data['phoneNumber']) }}"
                                        style="width: 100%; padding: 12px; border: 1px solid #bdc3c7; border-radius: 5px; font-size: 14px; box-sizing: border-box;">
                                    @error('phoneNumber')
                                        <span style="color: #e74c3c; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bio -->
                                <div style="margin-bottom: 20px;">
                                    <label style="display: block; margin-bottom: 8px; color: #1a237e; font-weight: 600;">About You</label>
                                    <textarea name="bio" placeholder="Tell us about yourself" cols="3" rows="4"
                                        style="width: 100%; padding: 12px; border: 1px solid #bdc3c7; border-radius: 5px; font-size: 14px; box-sizing: border-box; font-family: inherit;">{{ old('bio', $data['bio']) }}</textarea>
                                    @error('bio')
                                        <span style="color: #e74c3c; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Side - Profile Picture -->
                            <div class="col-lg-4" style="text-align: center;">
                                <div style="background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
                                    <img src="{{ Auth::user()->profilePicture ? asset('storage/profile_pictures/' . Auth::id() . '/' . Auth::user()->profilePicture) : asset('frontend/images/No_Image.png') }}"
                                        alt="Profile Image" style="width: 100%; height: 250px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                                    
                                    <label style="display: block; margin-bottom: 8px; color: #1a237e; font-weight: 600;">Profile Picture</label>
                                    <input type="file" name="profilePicture" accept="image/*" style="width: 100%; padding: 10px; border: 1px dashed #bdc3c7; border-radius: 5px; cursor: pointer;">
                                    <p style="color: #7f8c8d; font-size: 12px; margin-top: 8px;">JPG, PNG (Max 2MB)</p>
                                    @error('profilePicture')
                                        <span style="color: #e74c3c; font-size: 12px; display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #e0e0e0;">
                            <button type="submit" style="background: #1a237e; color: white; padding: 12px 30px; border: none; border-radius: 5px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Section -->
                <div style="background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <h2 style="font-size: 20px; font-weight: 700; color: #1a237e; margin-bottom: 25px;">
                        <i class="fas fa-lock"></i> Change Password
                    </h2>

                    <form action="{{ route('profile.update.password') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Current Password -->
                            <div class="col-md-6" style="margin-bottom: 20px;">
                                <label style="display: block; margin-bottom: 8px; color: #1a237e; font-weight: 600;">Current Password</label>
                                <input type="password" name="current_password" placeholder="Enter current password" required
                                    style="width: 100%; padding: 12px; border: 1px solid #bdc3c7; border-radius: 5px; font-size: 14px; box-sizing: border-box;">
                            </div>

                            <!-- New Password -->
                            <div class="col-md-6" style="margin-bottom: 20px;">
                                <label style="display: block; margin-bottom: 8px; color: #1a237e; font-weight: 600;">New Password</label>
                                <input type="password" name="new_password" placeholder="Enter new password" required
                                    style="width: 100%; padding: 12px; border: 1px solid #bdc3c7; border-radius: 5px; font-size: 14px; box-sizing: border-box;">
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6" style="margin-bottom: 20px;">
                                <label style="display: block; margin-bottom: 8px; color: #1a237e; font-weight: 600;">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" placeholder="Confirm new password" required
                                    style="width: 100%; padding: 12px; border: 1px solid #bdc3c7; border-radius: 5px; font-size: 14px; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #e0e0e0;">
                            <button type="submit" style="background: #e74c3c; color: white; padding: 12px 30px; border: none; border-radius: 5px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                                <i class="fas fa-key"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
