@extends('frontend.master') <!-- or your layout -->

@section('content')
<div class="container">
    <h1>Create Magasin</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
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
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Magasin</button>
    </form>
</div>
@endsection