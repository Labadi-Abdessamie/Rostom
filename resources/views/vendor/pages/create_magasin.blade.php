@extends('frontend.master') <!-- or your layout -->

@section('content')
    <div class="container mt-4">
        <h1>Create Magasin</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

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

        <form action="{{ route('vendor.magasin_store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Phone Number:</label>
                <input type="text" name="phoneNumber" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Magasin Picture (optional):</label>
                <input type="file" name="magasinPicture" class="form-control">
            </div>

            <div class="mb-3">
                <label>Vitrine Video (optional):</label>
                <input type="file" name="vitrineVideo" class="form-control">
            </div>

            <div class="mb-3">
                <label>Registre Commerce (required):</label>
                <input type="file" name="registreCommerce" class="form-control" required>
                <small class="form-text text-muted">Upload your business registration document for verification.</small>
            </div>

            <div class="mb-3">
                <label>Bio:</label>
                <textarea name="bio" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label>Location:</label>
                <input type="text" name="location" class="form-control" required>
                <div class="map-info">Click on the map to set your magasin's exact location</div>
            </div>

            <!-- Hidden fields for latitude and longitude -->
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <!-- OpenStreetMap -->
            <div class="mb-3">
                <label>Magasin Location on Map</label>
                <div id="locationMap"></div>
                <p class="map-info" id="coordsDisplay">No location selected yet. Click on the map to select.</p>
            </div>

            <div class="mb-3">
                <label>Facebook Link (optional):</label>
                <input type="url" name="facebookLink" class="form-control">
            </div>

            <div class="mb-3">
                <label>Instagram Link (optional):</label>
                <input type="url" name="instagramLink" class="form-control">
            </div>

            <div class="mb-3">
                <label>TikTok Link (optional):</label>
                <input type="url" name="tiktokLink" class="form-control">
            </div>

            <div class="mb-3">
                <label>WhatsApp Link (optional):</label>
                <input type="url" name="whatsupLink" class="form-control">
            </div>

            <!-- Single Category Select -->
            <div class="mb-3">
                <label>Select Category:</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Select a category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Magasin</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize variables
            let map;
            let marker;
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const coordsDisplay = document.getElementById('coordsDisplay');
            
            // Default location (center of your country - adjust as needed)
            const defaultLat = 35.8; // Algeria center
            const defaultLng = 3.0;
            
            // Initialize map
            map = L.map('locationMap').setView([defaultLat, defaultLng], 10);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19,
                minZoom: 2
            }).addTo(map);
            
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
