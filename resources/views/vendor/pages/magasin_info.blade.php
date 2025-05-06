@extends('vendor.master')

@section('title', 'Vendor | Magasin')

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
            <h1>Magasin</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Magasin</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Hi, {{ $vendorName }}</h2>

            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image"
                                src="{{ $magasin->magasinPicture ? asset('storage/magasins_images/' . $magasin->id . '/' . $magasin->magasinPicture) : asset('frontend/images/vendor_details_banner.jpg') }}"
                                class="w-100">
                            @if (false)
                                <div class="profile-widget-items">
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Products</div>
                                        <div class="profile-widget-item-value">187</div>
                                    </div>
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Followers</div>
                                        <div class="profile-widget-item-value">6,8K</div>
                                    </div>
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Following</div>
                                        <div class="profile-widget-item-value">2,1K</div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="profile-widget-description">
                            <div class="profile-widget-name">{{ $magasin->name }}
                                @if (false)
                                    <div class="text-muted d-inline font-weight-normal">
                                        <div class="slash"></div> ??
                                    </div>
                                @endif
                            </div>
                            {{ $magasin->bio }}</b>.
                        </div>
                        <div class="card-footer text-center">
                            <div class="font-weight-bold mb-2">Your Social Media Accounts</div>

                            @if ($magasin->facebookLink)
                                <a href="{{ $magasin->facebookLink }}" target="_blank"
                                    class="btn btn-social-icon btn-facebook mr-1">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            @endif
                            @if ($magasin->instagramLink)
                                <a href="{{ $magasin->instagramLink }}" target="_blank"
                                    class="btn btn-social-icon btn-instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                            @if ($magasin->tiktokLink)
                                <a href="{{ $magasin->tiktokLink }}" target="_blank"
                                    class="btn btn-social-icon btn-twitter mr-1">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif

                            @if ($magasin->whatsupLink)
                                <a href="{{ $magasin->whatsupLink }}" target="_blank"
                                    class="btn btn-social-icon btn-github mr-1">
                                    <i class="fab fa-github"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form action="" method="POST">
                            @csrf
                            <div class="card-header">
                                <h4>Edit Magasin Informations</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Name</label>
                                        <input name="name" type="text" class="form-control"
                                            value="{{ $magasin->name }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-7 col-12">
                                        <label>Email</label>
                                        <input name="email" type="email" class="form-control"
                                            value="{{ $magasin->email }}" required>
                                    </div>
                                    <div class="form-group col-md-5 col-12">
                                        <label>Phone</label>
                                        <input name="phone" type="tel" class="form-control"
                                            value="{{ $magasin->phoneNumber }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Location</label>
                                        <input name="location" type="text" class="form-control"
                                            value="{{ $magasin->location }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Bio</label>
                                        <textarea class="form-control">{{ $magasin->bio }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Magasin Picture</label>
                                        <input type="file" name="magasinPicture" class="form-control-file">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Magasin video</label>
                                        @if ($magasin->vitrineVideo)
                                            <video class="w-100"
                                                src="{{ asset('storage/magasins_videos/' . $magasin->id . '/' . $magasin->vitrineVideo) }}"
                                                alt="Magasin_Video" controls>
                                            </video>
                                        @else
                                            <p>No video</p>
                                        @endif
                                        <input type="file" name="magasinPicture" class="form-control-file">
                                    </div>
                                </div>
                                @if (false)
                                    <div class="row">
                                        <div class="form-group mb-0 col-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="remember" class="custom-control-input"
                                                    id="newsletter">
                                                <label class="custom-control-label" for="newsletter">Subscribe to
                                                    newsletter</label>
                                                <div class="text-muted form-text">
                                                    You will get new information about products, offers and promotions
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
