@extends('frontend.master')

@section('title')
    {{ $website->name }} || Wishlist
@endsection

@section('content')
    <!--============================
                            BREADCRUMB START
                        ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>wishlist</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">home</a></li>
                            <li><a href>wishlist</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                            BREADCRUMB END
                        ==============================-->


    <!--============================
                            CART VIEW PAGE START
                        ==============================-->
    <section id="wsus__cart_view">
        @livewire('wishlist')
    </section>
    <!--============================
                            CART VIEW PAGE END
                        ==============================-->
@endsection
