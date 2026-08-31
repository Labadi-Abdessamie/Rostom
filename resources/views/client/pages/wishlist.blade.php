@extends('client.master')

@section('title')
    My Wishlist
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="dashboard_content">
                <!-- Page Header -->
                <div class="dash-page-header">
                    <h1><i class="fas fa-heart"></i>My Wishlist</h1>
                    <p>View your saved items</p>
                </div>

                @livewire('wishlist')
            </div>
        </div>
    </div>
@endsection
