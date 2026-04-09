@extends('client.master')

@section('title')
    My Wishlist
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content">
                <!-- Page Header -->
                <div style="margin-bottom: 30px;">
                    <h1 style="font-size: 26px; font-weight: 700; color: #1a237e; margin-bottom: 8px;">
                        <i class="fas fa-heart" style="margin-right: 10px; color: #e91e63;"></i>My Wishlist
                    </h1>
                    <p style="color: #7f8c8d; margin: 0;">View your saved items</p>
                </div>

                @livewire('wishlist')
            </div>
        </div>
    </div>
@endsection
