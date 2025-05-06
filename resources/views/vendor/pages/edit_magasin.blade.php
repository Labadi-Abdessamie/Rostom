@extends('vendor.master')

@section('title', 'Vendor | Edit Magasin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('vendor/modules/summernote/summernote-bs4.js') }}"></script>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Magasin</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Edit Magasin</div>
        </div>
    </div>

    <div class="section-body">
        <form action="{{ route('vendor.update_magasin', $magasin->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card">
                <div class="card-header"><h4>Magasin Information</h4></div>
                <div class="card-body">

                    <!-- Name -->
                    <div class="form-group">
                        <label>Name</label>
                        <input name="name" type="text" class="form-control" value="{{ $magasin->name }}" required>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" type="email" class="form-control" value="{{ $magasin->email }}" required>
                    </div>

                    <!-- Phone Number -->
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input name="phoneNumber" type="text" class="form-control" value="{{ $magasin->phoneNumber }}" required>
                    </div>

                    <!-- Location -->
                    <div class="form-group">
                        <label>Location</label>
                        <input name="location" type="text" class="form-control" value="{{ $magasin->location }}" required>
                    </div>

                    <!-- Bio -->
                    <div class="form-group">
                        <label>Bio</label>
                        <textarea name="bio" class="form-control summernote">{{ $magasin->bio }}</textarea>
                    </div>

                    <!-- Magasin Picture -->
                    <div class="form-group">
                        <label>Magasin Picture</label><br>
                        @if ($magasin->magasinPicture)
                            <img src="{{ asset('storage/' . $magasin->magasinPicture) }}" class="img-fluid mb-2" width="200">
                        @endif
                        <input type="file" name="magasinPicture" class="form-control-file">
                    </div>

                    <!-- Magasin Video -->
                    <div class="form-group">
                        <label>Magasin Video</label><br>
                        @if ($magasin->vitrineVideo)
                            <video class="w-100 mb-2" controls>
                                <source src="{{ asset('storage/' . $magasin->vitrineVideo) }}" type="video/mp4">
                            </video>
                        @endif
                        <input type="file" name="vitrineVideo" class="form-control-file">
                    </div>

                    <!-- Social Media Links -->
                    <div class="form-group">
                        <label>Facebook Link</label>
                        <input name="facebookLink" type="url" class="form-control" value="{{ $magasin->facebookLink }}">
                    </div>

                    <div class="form-group">
                        <label>Instagram Link</label>
                        <input name="instagramLink" type="url" class="form-control" value="{{ $magasin->instagramLink }}">
                    </div>

                    <div class="form-group">
                        <label>TikTok Link</label>
                        <input name="tiktokLink" type="url" class="form-control" value="{{ $magasin->tiktokLink }}">
                    </div>

                    <div class="form-group">
                        <label>WhatsApp Link</label>
                        <input name="whatsupLink" type="url" class="form-control" value="{{ $magasin->whatsupLink }}">
                    </div>

                    <!-- Magasin Open -->
                    <div class="form-group">
                        <label>Magasin Open</label>
                        <select name="magasinOpen" class="form-control" required>
                            <option value="1" {{ $magasin->magasinOpen ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$magasin->magasinOpen ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
