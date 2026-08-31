@extends('vendor.layouts.no-sidebar')
@section('title','Vendor | Create Magasin')
@section('styles')
<link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.min.css') }}" />
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap');

body { font-family:'Inter',sans-serif; }

.hero-strip {
    background: linear-gradient(135deg,#6366f1 0%,#8b5cf6 60%,#ec4899 100%);
    position:relative; overflow:hidden; border-radius:0 0 30px 30px; padding:42px 28px 50px;
    box-shadow:0 20px 60px rgba(99,102,241,.35);
}
.hero-strip::before {
    content:''; position:absolute; inset:0;
    background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,.15) 1px, transparent 0);
    background-size: 24px 24px; pointer-events:none;
}
.hero-strip::after {
    content:''; position:absolute; top:-60px; right:-60px; width:300px; height:300px;
    background:radial-gradient(circle, rgba(255,255,255,.25) 0%, transparent 70%); border-radius:50%;
}
.hero-strip .hero-inner { position:relative; z-index:2; max-width:700px; margin:0 auto; color:#fff; }
.hero-strip h1 { font-family:'Playfair Display',serif; font-weight:600; font-size:2.6rem; margin-bottom:6px; letter-spacing:-1px; text-shadow:0 4px 20px rgba(0,0,0,.2); }
.hero-strip p { font-size:1.05rem; opacity:.9; margin-bottom:0; font-weight:300; }
.hero-strip .breadcrumb { display:inline-flex; gap:10px; font-size:.82rem; opacity:.85; margin-top:10px; list-style:none; padding:0; }
.hero-strip .breadcrumb a { color:#fff; text-decoration:none; opacity:.9; }
.hero-strip .breadcrumb a:hover { text-decoration:underline; }

.form-card {
    background:rgba(255,255,255,.92); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px);
    border-radius:24px; padding:36px; margin-top:-30px; position:relative; z-index:3;
    box-shadow:0 30px 80px rgba(15,23,42,.12), 0 0 0 1px rgba(255,255,255,.4); border:1px solid rgba(255,255,255,.5);
}

.form-card label { font-weight:600; font-size:.82rem; color:#334155; letter-spacing:.2px; }
.form-card .form-control {
    border-radius:10px; padding:10px 14px; font-size:.9rem; border:1.5px solid #e2e8f0;
    background:#fff; transition:all .2s; box-shadow:inset 0 1px 2px rgba(0,0,0,.02);
}
.form-card .form-control:focus { border-color:#6366f1; box-shadow:0 0 0 4px rgba(99,102,241,.12), inset 0 1px 2px rgba(0,0,0,.02); }

.section-divider { border-top:1px solid #e2e8f0; margin:28px 0; position:relative; }
.section-divider .divider-label {
    position:absolute; left:50%; top:-10px; transform:translateX(-50%);
    background:#fff; padding:0 12px; font-size:.7rem; color:#94a3b8; letter-spacing:1px; text-transform:uppercase; font-weight:600;
}

.btn-gradient {
    background:linear-gradient(135deg,#6366f1,#8b5cf6,#ec4899); background-size:200% 200%;
    border:none; border-radius:10px; padding:12px 32px; font-weight:700; color:#fff; font-size:.95rem;
    box-shadow:0 6px 20px rgba(99,102,241,.35); transition:all .2s; letter-spacing:.3px;
}
.btn-gradient:hover { background-position:100% 0; transform:translateY(-2px); box-shadow:0 10px 30px rgba(99,102,241,.5); }

.map-card { border-radius:14px; overflow:hidden; border:1.5px solid #e2e8f0; box-shadow:0 4px 16px rgba(0,0,0,.05); }
#locationMap { height:300px !important; min-height:300px !important; }
.map-info { font-size:.75rem; color:#94a3b8; margin-top:6px; }
.coords-display { font-weight:600; color:#6366f1; font-size:.85rem; background:#f0f5ff; padding:6px 10px; border-radius:8px; display:inline-block; margin-top:4px; }

.alert { border-radius:12px; font-size:.9rem; border:none; }
</style>
@endsection

@section('content')

<div class="hero-strip">
    <div class="hero-inner">
        <h1>Create Your Magasin</h1>
        <p>Launch your store on the platform — one form away from going live.</p>
    </div>
</div>

<div style="max-width:700px; margin:0 auto; padding:0 20px 60px;">
    <div class="form-card">
        @if (session('success'))
            <div class="alert alert-success" style="border-left:4px solid #22c55e; background:#f0fdf4; color:#166534;">{{ session('success') }}</div>
        @endif
        @if (session('message'))
            <div class="alert alert-info" style="border-left:4px solid #6366f1; background:#eff6ff; color:#1e40af;">{{ session('message') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" style="border-left:4px solid #ef4444; background:#fef2f2; color:#991b1b;">
                <strong style="font-weight:700;">Please fix the following:</strong>
                <ul class="mb-0 mt-2" style="padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vendor.magasin_store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Magasin Name <span style="color:#ef4444">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Café La Rose" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Phone Number <span style="color:#ef4444">*</span></label>
                <input type="text" name="phoneNumber" class="form-control" value="{{ old('phoneNumber') }}" placeholder="05XX XXX XXX" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Email <span style="color:#ef4444">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="hello@magasin.com" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>City / Area <span style="color:#ef4444">*</span></label>
                <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="Algiers, Tiaret..." required>
            </div>
        </div>

        <div class="mb-3">
            <label>Bio <span style="color:#ef4444">*</span></label>
            <textarea name="bio" class="form-control" rows="3" placeholder="Tell customers about your store..." required>{{ old('bio') }}</textarea>
        </div>

        <div class="section-divider"><span class="divider-label">Details</span></div>

        <div class="row mb-3">
            <div class="col-md-6 mb-2">
                <label>Magasin Picture <span style="font-weight:400; color:#94a3b8;">(optional)</span></label>
                <input type="file" name="magasinPicture" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6 mb-2">
                <label>Vitrine Video <span style="font-weight:400; color:#94a3b8;">(optional)</span></label>
                <input type="file" name="vitrineVideo" class="form-control" accept="video/*">
            </div>
        </div>

        <div class="mb-3">
            <label>Registre Commerce <span style="color:#ef4444">*</span></label>
            <input type="file" name="registreCommerce" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
            <small style="color:#94a3b8; font-size:.75rem;">Upload PDF or image (max 5MB)</small>
        </div>

        <div class="mb-2">
            <label>Location on Map <span style="color:#ef4444">*</span></label>
            <div class="map-card">
                <div id="locationMap"></div>
            </div>
            <p class="map-info" id="coordsDisplay">Click on the map to pin your store location.</p>
        </div>

        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', 35.8) }}">
        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', 2.5) }}">

        <div class="section-divider"><span class="divider-label">Category & Social</span></div>

        <div class="row mb-3">
            <div class="col-md-6 mb-2">
                <label>Category <span style="color:#ef4444">*</span></label>
                <select name="category_id" class="form-control" required>
                    <option value="">— Choose —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-2">
                <label>WhatsApp Link</label>
                <input type="url" name="whatsupLink" class="form-control" value="{{ old('whatsupLink') }}" placeholder="https://wa.me/...">
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <label>Facebook</label>
                <input type="url" name="facebookLink" class="form-control" value="{{ old('facebookLink') }}" placeholder="https://facebook.com/...">
            </div>
            <div class="col-md-4 mb-2">
                <label>Instagram</label>
                <input type="url" name="instagramLink" class="form-control" value="{{ old('instagramLink') }}" placeholder="https://instagram.com/...">
            </div>
            <div class="col-md-4 mb-2">
                <label>TikTok</label>
                <input type="url" name="tiktokLink" class="form-control" value="{{ old('tiktokLink') }}" placeholder="https://tiktok.com/...">
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center pt-2" style="border-top:1px solid #e2e8f0;">
            <small style="color:#94a3b8;">Your info is protected and only used for verification.</small>
            <button type="submit" class="btn btn-gradient">Create Magasin <i class="fa-solid fa-arrow-right ms-2" style="font-size:.8em;"></i></button>
        </div>
        </form>
    </div>
</div>

@section('scripts')
<script src="{{ asset('vendor/leaflet/leaflet.min.js') }}"></script>
<script>
(function() {
    let map, marker;
    const latIn = document.getElementById('latitude');
    const lngIn = document.getElementById('longitude');
    const coordsDisplay = document.getElementById('coordsDisplay');
    const defaultLat = parseFloat(latIn.value) || 35.8;
    const defaultLng = parseFloat(lngIn.value) || 2.5;

    map = L.map('locationMap').setView([defaultLat, defaultLng], 10);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap', maxZoom: 19, minZoom: 2 }).addTo(map);

    setTimeout(function() { map.invalidateSize(); }, 400);

    if (defaultLat && defaultLng) {
        marker = L.marker([defaultLat, defaultLng]).addTo(map).bindPopup('Selected').openPopup();
        coordsDisplay.innerHTML = '<span class="coords-display">Lat: ' + defaultLat.toFixed(4) + '  •  Lng: ' + defaultLng.toFixed(4) + '</span>';
    }

    map.on('click', function(e) {
        const lat = e.latlng.lat, lng = e.latlng.lng;
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map).bindPopup('<b>Lat:</b> ' + lat.toFixed(6) + '<br><b>Lng:</b> ' + lng.toFixed(6)).openPopup();
        latIn.value = lat; lngIn.value = lng;
        coordsDisplay.innerHTML = '<span class="coords-display">Lat: ' + lat.toFixed(4) + '  •  Lng: ' + lng.toFixed(4) + '</span>';
    });
})();
</script>
@endsection
