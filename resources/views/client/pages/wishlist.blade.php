@extends('client.master')

@section('title')
    Dashboard || Wishlist
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            @livewire('wishlist')
        </div>
    </div>
@endsection
