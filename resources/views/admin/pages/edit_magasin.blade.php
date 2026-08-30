@extends('admin.master')

@section('content')
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
        .map-info {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
    </style>
    <div class="content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.magasins') }}">Magasins</a></li>
                                <li class="breadcrumb-item active">Edit Magasin</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Edit Magasin</h4>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.update.magasin', $magasin->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Store Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Store Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $magasin->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $magasin->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone Number -->
                                <div class="mb-3">
                                    <label for="phoneNumber" class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phoneNumber') is-invalid @enderror"
                                        id="phoneNumber" name="phoneNumber"
                                        value="{{ old('phoneNumber', $magasin->phoneNumber) }}" required>
                                    @error('phoneNumber')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Location -->
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                                        id="location" name="location" value="{{ old('location', $magasin->location) }}"
                                        required>
                                    <div class="map-info">Click on the map to set the magasin's exact location</div>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Hidden fields for latitude and longitude -->
                                <input type="hidden" name="latitude" id="latitude" value="{{ $magasin->latitude }}">
                                <input type="hidden" name="longitude" id="longitude" value="{{ $magasin->longitude }}">

                                <!-- OpenStreetMap -->
                                <div class="mb-3">
                                    <label for="locationMap" class="form-label">Magasin Location on Map</label>
                                    <div id="locationMap"></div>
                                    <p class="map-info" id="coordsDisplay">
                                        @if ($magasin->latitude && $magasin->longitude)
                                            Selected Location: {{ $magasin->latitude }}, {{ $magasin->longitude }}
                                        @else
                                            No location selected yet. Click on the map to select.
                                        @endif
                                    </p>
                                </div>

                                <!-- Image -->
                                <div class="mb-3">
                                    <label for="magasinPicture" class="form-label">Store Image</label>
                                    <input type="file" class="form-control @error('magasinPicture') is-invalid @enderror"
                                        id="magasinPicture" name="magasinPicture" accept="image/*">
                                    @error('magasinPicture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if ($magasin->magasinPicture)
                                        <div class="mt-2">
                                            <label>Current Image:</label><br>
                                            <img src="{{ asset('storage/' . $magasin->magasinPicture) }}"
                                                alt="Current Image" width="150">
                                        </div>
                                    @endif
                                </div>

                                <!-- Rate -->
                                <div class="mb-3">
                                    <label for="rate" class="form-label">Rate</label>
                                    <input type="number" class="form-control @error('rate') is-invalid @enderror"
                                        id="rate" name="rate" min="0" max="5" step="0.1"
                                        value="{{ old('rate', $magasin->rate) }}">
                                    @error('rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Open -->
                                <div class="mb-3">
                                    <label for="magasinOpen" class="form-label">Is Open?</label>
                                    <select class="form-select @error('magasinOpen') is-invalid @enderror" id="magasinOpen"
                                        name="magasinOpen" required>
                                        <option value="1" {{ $magasin->magasinOpen ? 'selected' : '' }}>Open</option>
                                        <option value="0" {{ !$magasin->magasinOpen ? 'selected' : '' }}>Closed
                                        </option>
                                    </select>
                                    @error('magasinOpen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="magasinStatus" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="magasinStatus"
                                        name="status" required>
                                        <option value="active" {{ $magasin->status == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ $magasin->status == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="blocked" {{ $magasin->status == 'blocked' ? 'selected' : '' }}>
                                            Blocked</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Update Magasin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="{{ asset("vendor/leaflet/leaflet.min.js") }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize variables
            let map;
            let marker;
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const coordsDisplay = document.getElementById('coordsDisplay');
            
            // Default location
            const defaultLat = {{ $magasin->latitude ?? 35.8 }};
            const defaultLng = {{ $magasin->longitude ?? 2.5 }};
            
            // Initialize map
            map = L.map('locationMap').setView([defaultLat, defaultLng], 10);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19,
                minZoom: 2
            }).addTo(map);

            setTimeout(function() { map.invalidateSize(); }, 200);
            
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
