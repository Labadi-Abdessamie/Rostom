@extends('vendor.master')

@section('title', 'Vendor | View Magasin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/modules/bootstrap-social/bootstrap-social.css') }}">
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
            <div class="card-header"><h4>Magasin Details</h4></div>
            <div class="card-body">

                <p><strong>Name:</strong> {{ $magasin->name }}</p>
                <p><strong>Email:</strong> {{ $magasin->email }}</p>
                <p><strong>Phone Number:</strong> {{ $magasin->phoneNumber }}</p>
                <p><strong>Location:</strong> {{ $magasin->location }}</p>
                <p><strong>Bio:</strong> {!! $magasin->bio !!}</p>

                @if ($magasin->magasinPicture)
                    <p><strong>Magasin Picture:</strong></p>
                    <img src="{{ asset('storage/' . $magasin->magasinPicture) }}" class="img-fluid mb-2" width="200">
                @endif

                @if ($magasin->vitrineVideo)
                    <p><strong>Magasin Video:</strong></p>
                    <video class="w-100 mb-2" controls>
                        <source src="{{ asset('storage/' . $magasin->vitrineVideo) }}" type="video/mp4">
                    </video>
                @endif

                <p><strong>Facebook Link:</strong> <a href="{{ $magasin->facebookLink }}" target="_blank">{{ $magasin->facebookLink }}</a></p>
                <p><strong>Instagram Link:</strong> <a href="{{ $magasin->instagramLink }}" target="_blank">{{ $magasin->instagramLink }}</a></p>
                <p><strong>TikTok Link:</strong> <a href="{{ $magasin->tiktokLink }}" target="_blank">{{ $magasin->tiktokLink }}</a></p>
                <p><strong>WhatsApp Link:</strong> <a href="{{ $magasin->whatsupLink }}" target="_blank">{{ $magasin->whatsupLink }}</a></p>

                <p><strong>Magasin Open:</strong> {{ $magasin->magasinOpen ? 'Yes' : 'No' }}</p>

                <!-- Edit button that redirects to the edit page -->
                <a href="{{ route('vendor.edit_magasin', $magasin->id) }}" class="btn btn-warning">Edit Magasin</a>
            </div>
        </div>
    </div>
</section>
@endsection
