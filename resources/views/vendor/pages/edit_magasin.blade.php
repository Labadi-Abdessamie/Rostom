@extends('vendor.master')

@section('title', 'Vendor | Edit Magasin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <style>
        #locationMap {
            height: 400px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 10px;
        }
        .map-info {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
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
                    <div class="card-header">
                        <h4>Magasin Information</h4>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input name="name" type="text" class="form-control" value="{{ $magasin->name }}" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" type="email" class="form-control" value="{{ $magasin->email }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input name="phoneNumber" type="text" class="form-control"
                                value="{{ $magasin->phoneNumber }}" required>
                        </div>

                        <div class="form-group">
                            <label>Location</label>
                            <input name="location" type="text" class="form-control" value="{{ $magasin->location }}"
                                required>
                            <div class="map-info">Click on the map to set your magasin's exact location</div>
                        </div>

                        <!-- Hidden fields for latitude and longitude -->
                        <input type="hidden" name="latitude" id="latitude" value="{{ $magasin->latitude }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ $magasin->longitude }}">

                        <!-- OpenStreetMap -->
                        <div class="form-group">
                            <label>Magasin Location on Map</label>
                            <div id="locationMap"></div>
                            <p class="map-info" id="coordsDisplay">
                                @if ($magasin->latitude && $magasin->longitude)
                                    Selected Location: {{ $magasin->latitude }}, {{ $magasin->longitude }}
                                @else
                                    No location selected yet. Click on the map to select.
                                @endif
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Bio</label>
                            <textarea name="bio" class="form-control summernote">{{ $magasin->bio }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Magasin Picture</label><br>
                            @if ($magasin->magasinPicture)
                                <img src="{{ asset('storage/magasins_images/' . $magasin->id . '/' . $magasin->magasinPicture) }}"
                                    class="img-fluid mb-2" width="200">
                            @endif
                            <input type="file" name="magasinPicture" class="form-control-file">
                        </div>

                        <div class="form-group">
                            <label>Magasin Video</label><br>
                            @if ($magasin->vitrineVideo)
                                <video class="w-100 mb-2" controls>
                                    <source
                                        src="{{ asset('storage/magasins_videos/' . $magasin->id . '/' . $magasin->vitrineVideo) }}"
                                        type="video/mp4">
                                </video>
                            @endif
                            <input type="file" name="vitrineVideo" class="form-control-file">
                        </div>

                        <div class="form-group">
                            <label>Facebook Link</label>
                            <input name="facebookLink" type="url" class="form-control"
                                value="{{ $magasin->facebookLink }}">
                        </div>

                        <div class="form-group">
                            <label>Instagram Link</label>
                            <input name="instagramLink" type="url" class="form-control"
                                value="{{ $magasin->instagramLink }}">
                        </div>

                        <div class="form-group">
                            <label>TikTok Link</label>
                            <input name="tiktokLink" type="url" class="form-control"
                                value="{{ $magasin->tiktokLink }}">
                        </div>

                        <div class="form-group">
                            <label>WhatsApp Link</label>
                            <input name="whatsupLink" type="url" class="form-control"
                                value="{{ $magasin->whatsupLink }}">
                        </div>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize variables
            let map;
            let marker;
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const coordsDisplay = document.getElementById('coordsDisplay');
            
            // Default location (center of your country - adjust as needed)
            const defaultLat = {{ $magasin->latitude ?? 35.8 }};
            const defaultLng = {{ $magasin->longitude ?? 3.0 }};
            
            // Initialize map
            map = L.map('locationMap').setView([defaultLat, defaultLng], 10);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19,
                minZoom: 2
            }).addTo(map);
            
            // Add existing marker if coordinates exist
            @if ($magasin->latitude && $magasin->longitude)
                marker = L.marker([{{ $magasin->latitude }}, {{ $magasin->longitude }}])
                    .addTo(map)
                    .bindPopup('Magasin Location');
                map.setView([{{ $magasin->latitude }}, {{ $magasin->longitude }}], 15);
            @endif
            
            // Handle map clicks
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                
                // Remove existing marker
                if (marker) {
                    map.removeLayer(marker);
                }
                
                // Add new marker
                marker = L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup('Selected Location<br>Lat: ' + lat.toFixed(6) + '<br>Lng: ' + lng.toFixed(6))
                    .openPopup();
                
                // Update hidden inputs
                latitudeInput.value = lat;
                longitudeInput.value = lng;
                
                // Update display
                coordsDisplay.textContent = 'Selected Location: ' + lat.toFixed(6) + ', ' + lng.toFixed(6);
            });
        });
    </script>
@endsection
