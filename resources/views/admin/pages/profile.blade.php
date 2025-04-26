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
                    <div class="col-xl-9">
                        <div class="row">
                            <!-- Name -->
                            <div class="col-xl-7 col-md-6 m-1">
                                <input class="form-control" type="text" name="name" placeholder="Name"
                                    value="{{ old('name', $admin->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="col-xl-5 col-md-6 m-1">
                                <input class="form-control" type="text" name="phoneNumber" placeholder="Phone"
                                    value="{{ old('phoneNumber', $admin->phoneNumber) }}">
                                @error('phoneNumber')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-xl-5 col-md-6 m-1">
                                <input class="form-control" type="email" name="email" placeholder="Email"
                                    value="{{ old('email', $admin->email) }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Bio -->
                            <div class="col-xl-6 col-md-6 m-1">
                                <textarea name="bio" cols="3" rows="5" class="form-control" placeholder="About You">{{ old('bio', $admin->bio) }}</textarea>
                                @error('bio')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Profile Picture -->
                    <div class="col-xl-3 col-sm-6 col-md-5">
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
        </div>
    </div>
@endsection
