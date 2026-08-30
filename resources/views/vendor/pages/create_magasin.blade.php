@extends('vendor.master')

@section('title', 'Vendor | Create Magasin')

@section('styles')
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
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Create Magasin</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Create Magasin</div>
            </div>
        </div>

        <div class="section-body">
            @if (session('success'))
                <div class="alert alert-success" style="border-radius:10px;">{{ session('success') }}</div>
            @endif

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
    </div>
</section>

@section('scripts')
    <script src="{{ asset("vendor/leaflet/leaflet.min.js") }}"></script>
    <script>
        (function() {
            let map;
            let marker;
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const coordsDisplay = document.getElementById('coordsDisplay');

            const defaultLat = 35.8;
            const defaultLng = 2.5;

            map = L.map('locationMap').setView([defaultLat, defaultLng], 10);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19,
                minZoom: 2
            }).addTo(map);

            // Redraw after layout settles
            setTimeout(function() { map.invalidateSize(); }, 500);

            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                if (marker) { map.removeLayer(marker); }

                marker = L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup('Lat: ' + lat.toFixed(6) + '<br>Lng: ' + lng.toFixed(6))
                    .openPopup();

                latitudeInput.value = lat;
                longitudeInput.value = lng;
                coordsDisplay.textContent = 'Selected: ' + lat.toFixed(6) + ', ' + lng.toFixed(6);
            });
        })();
    </script>
@endsection
