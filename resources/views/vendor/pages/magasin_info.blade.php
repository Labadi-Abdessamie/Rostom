@extends('vendor.master')

@section('title', 'Vendor | View Magasin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset("vendor/leaflet/leaflet.min.css") }}" />
    <style>
        #locationMap {
            height: 400px !important;
            min-height: 400px !important;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 10px;
            z-index: 1 !important;
        }
        .leaflet-container { z-index: 1 !important; }
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Magasin Information</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">View Magasin</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Magasin Details</h4>
                </div>
                <div class="card-body">

                    <p><strong>Name:</strong> {{ $magasin->name }}</p>
                    <p><strong>Email:</strong> {{ $magasin->email }}</p>
                    <p><strong>Phone Number:</strong> {{ $magasin->phoneNumber }}</p>
                    <p><strong>Location:</strong> {{ $magasin->location }}</p>
                    
                    @if ($magasin->latitude && $magasin->longitude)
                        <p><strong>Magasin Location on Map:</strong></p>
                        <div id="locationMap"></div>
                    @endif
                    
                    <p><strong>Bio:</strong> {!! $magasin->bio !!}</p>

                    @if ($magasin->magasinPicture)
                        <p><strong>Magasin Picture:</strong></p>
                        <img src="{{ $magasin->magasinPicture ? asset('storage/magasins_images/' . $magasin->id . '/' . $magasin->magasinPicture) : asset('frontend/images/vendor_details_banner.jpg') }}"
                            class="img-fluid mb-2" width="200">
                    @endif

                    @if ($magasin->vitrineVideo)
                        <p><strong>Magasin Video:</strong></p>
                        <video class="w-100 mb-2" controls>
                            <source
                                src="{{ $magasin->vitrineVideo ? asset('storage/magasins_videos/' . $magasin->id . '/' . $magasin->vitrineVideo) : '' }}"
                                type="video/mp4">
                        </video>
                    @endif

                    <p><strong>Facebook Link:</strong> <a href="{{ $magasin->facebookLink }}"
                            target="_blank">{{ $magasin->facebookLink }}</a></p>
                    <p><strong>Instagram Link:</strong> <a href="{{ $magasin->instagramLink }}"
                            target="_blank">{{ $magasin->instagramLink }}</a></p>
                    <p><strong>TikTok Link:</strong> <a href="{{ $magasin->tiktokLink }}"
                            target="_blank">{{ $magasin->tiktokLink }}</a></p>
                    <p><strong>WhatsApp Link:</strong> <a href="{{ $magasin->whatsupLink }}"
                            target="_blank">{{ $magasin->whatsupLink }}</a></p>

                    <p><strong>Magasin Open:</strong> {{ $magasin->magasinOpen ? 'Yes' : 'No' }}</p>

                    <a href="{{ route('vendor.edit_magasin', $magasin->id) }}" class="btn btn-warning">Edit Magasin</a>
                </div>
            </div>
            @if (false)

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
                    </div>
                </div>
            @endif
    </section>

    <script src="{{ asset("vendor/leaflet/leaflet.min.js") }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lat = {{ $magasin->latitude ?? 35.8 }};
            const lng = {{ $magasin->longitude ?? 2.5 }};

            const map = L.map('locationMap').setView([lat, lng], 14);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19,
                minZoom: 2
            }).addTo(map);

            L.marker([lat, lng])
                .addTo(map)
                .bindPopup('<strong>{{ $magasin->name }}</strong><br>{{ $magasin->location }}');

            // Force redraw when rendered inside card layout
            setTimeout(function() { map.invalidateSize(); }, 300);
        });
    </script>
@endsection
