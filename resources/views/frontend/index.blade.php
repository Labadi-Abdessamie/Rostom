@extends('frontend.master')

@section('title')
    {{ $website->name }} || Home
@endsection

@section('content')
    <!-- ========== BANNER Start ========== -->
    @include('frontend.body.wsus_banner')
    <!-- BANNER End -->

    {{--
    @include('frontend.body.product_popup_modal')
    --}}
    <!-- ========== FLASH SELL Start ========== -->
    @include('frontend.body.wsus_flash_sell')
    <!-- FLASH SELL End -->

    <!-- ========== MONTHLY TOP PRODUCT Start ========== -->
    @include('frontend.body.wsus_monthly_top')
    <!-- MONTHLY TOP PRODUCT End -->

    {{-- ! Brands slider
    <!-- ========== BRAND SLIDER Start ========== -->
    @include('frontend.body.wsus_brand_sleder')
    <!-- BRAND SLIDER End -->
    --}}

    <!-- ========== SINGLE BANNER Start ========== -->
    @include('frontend.body.wsus_single_banner')
    <!-- SINGLE BANNER End -->

    <!-- ========== HOT DEALS Start ========== -->
    @include('frontend.body.wsus_hot_deals')
    <!-- HOT DEALS End -->

    <!-- ========== categorie Start ========== -->
    @include('frontend.body.wsus_categorie')
    <!-- categorie End -->

    <!-- ========== categorie Start ========== -->
    @include('frontend.body.wsus_large_banner')
    <!-- categorie End -->

    {{--
    <!-- ========== WEEKLY BEST ITEM Start ========== -->
    @include('frontend.body.wsus_weekly_best')
    <!-- WEEKLY BEST ITEM End -->
    --}}

    <!-- ========== HOME SERVICES Start ========== -->
    @include('frontend.body.wsus_home_services')
    <!-- HOME SERVICES End -->

    {{--
    <!-- ========== Blogs Start ========== -->
    @include('frontend.body.wsus_blogs')
    <!-- Blogs End -->
    --}}
@endsection
