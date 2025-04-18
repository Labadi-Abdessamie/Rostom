{{--

@extends('frontend.master')

@section('title')
ATLAS MALL || Product Compare
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
                        <h4>compare</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">home</a></li>
                            <li><a href="#">product</a></li>
                            <li><a href="#">compare</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
            BREADCRUMB END
        ==============================-->


    <!--==========================
            COMPARE START
        ===========================-->
    <section id="wsus__compare">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="wsus__compare_list">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr class="d-flex">
                                        <td class="wsus__compare_img">
                                            <p>Product details</p>
                                        </td>
                                        <td class="wsus__compare_img"><img src="{{ asset('frontend/images/blazer_2.jpg') }}"
                                                alt="product" class="img-fluid w-100">
                                        </td>
                                        <td class="wsus__compare_img"><img
                                                src="{{ asset('frontend/images/headphone_1.jpg') }}" alt="product"
                                                class="img-fluid w-100">
                                        </td>
                                        <td class="wsus__compare_img"><img src="{{ asset('frontend/images/kids_1.jpg') }}"
                                                alt="product" class="img-fluid w-100">
                                        </td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="wsus__compare_text">
                                            <p>Product Name</p>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <p>Product Name</p>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <p>Product Name</p>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <p>Product Name</p>
                                        </td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="wsus__compare_text">
                                            <p>Price</p>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <p class="wsus__compare_price">$120.00</p>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <p class="wsus__compare_price">$142.00</p>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <p class="wsus__compare_price">$165.00</p>
                                        </td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="wsus__compare_text">
                                            <p>Rating</p>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <p class="compare_rating"><i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                                <i class="fal fa-star"></i>
                                                <span>(71)</span>
                                            </p>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="fal fa-star"></i>
                                            <span>(145)</span>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="fal fa-star"></i>
                                            <span>(22)</span>
                                        </td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="wsus__compare_text">
                                            <p>size</p>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <span class="wsus__compare_size"> 950 sqft</span>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <span class="wsus__compare_size"> 11000 sqft</span>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <span class="wsus__compare_size"> 720 sqft</span>
                                        </td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="wsus__compare_text">
                                            <p>Item Availability</p>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <span class="wsus__compare_stock">In Stock</span>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <span class="wsus__compare_stock_out">Out Of Stock</span>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <span class="wsus__compare_stock">In Stock</span>
                                        </td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="wsus__compare_text">
                                            <p>Dimensions</p>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <span class="wsus__n_a">n/a</span>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <span class="wsus__n_a">n/a</span>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <span class="wsus__n_a">n/a</span>
                                        </td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="wsus__compare_text">
                                            <p>description</p>
                                        </td>
                                        <td class="wsus__compare_text wsus__compare_des">
                                            <p><span>color : </span> pearl</p>
                                            <p><span>Fabric : </span> 100% Cotton</p>
                                            <p><span>Materials : </span>Yearn</p>
                                            <p><span>Packaging : </span>1 pice poly</p>
                                            <p><span>Cleaning : </span>Washable</p>
                                        </td>
                                        <td class="wsus__compare_text wsus__compare_des">
                                            <p><span>color : </span> white</p>
                                            <p><span>Fabric : </span> 100% Cotton</p>
                                            <p><span>Materials : </span>Yearn</p>
                                            <p><span>Packaging : </span>1 pice poly</p>
                                            <p><span>Cleaning : </span>Washable</p>
                                        </td>
                                        <td class="wsus__compare_text wsus__compare_des">
                                            <p><span>color : </span> blue</p>
                                            <p><span>Fabric : </span> 100% Cotton</p>
                                            <p><span>Materials : </span>Yearn</p>
                                            <p><span>Packaging : </span>1 pice poly</p>
                                            <p><span>Cleaning : </span>Washable</p>
                                        </td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="wsus__compare_text">
                                            <p>Add To Cart </p>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <a href="#" class="common_btn">add to cart</a>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <a href="#" class="common_btn">add to cart</a>
                                        </td>
                                        <td class="wsus__compare_text">
                                            <a href="#" class="common_btn">add to cart</a>
                                        </td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="wsus__compare_text">
                                            <p>remove </p>
                                        </td>
                                        <td class="wsus__compare_text wsus__del_area">
                                            <a href="#" class="wsus__compare_del"><i class="far fa-times"></i></a>
                                        </td>
                                        <td class="wsus__compare_text wsus__del_area">
                                            <a href="#" class="wsus__compare_del"><i class="far fa-times"></i></a>
                                        </td>
                                        <td class="wsus__compare_text wsus__del_area">
                                            <a href="#" class="wsus__compare_del"><i class="far fa-times"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==========================
            COMPARE END
        ===========================-->
@endsection
                    --}}

@extends('frontend.master')

@section('title')
    ATLAS MALL || Product Compare
@endsection

@section('content')
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>compare</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">home</a></li>
                            <li><a href="{{ route('frontend.products') }}">product</a></li>
                            <li><a>compare</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="wsus__compare">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="wsus__compare_list">
                        <div class="table-responsive">
                            <table class="table">
                                @livewire('compare')
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
