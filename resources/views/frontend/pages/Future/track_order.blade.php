@extends('frontend.master')

@section('title')
    ATLAS MALL || Track Order
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
                        <h4>order tracking</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">home</a></li>
                            <li><a href="#">order tracking</a></li>
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
        TRACKING ORDER START
    ==============================-->
    <section id="wsus__login_register">
        <div class="container">
            <div class="wsus__track_area">
                <div class="row">
                    <div class="col-xl-5 col-md-10 col-lg-8 m-auto">
                        <form class="tack_form">
                            <h4 class="text-center">order tracking</h4>
                            <p class="text-center">tracking your order status</p>
                            <div class="wsus__track_input">
                                <label class="d-block mb-2">order id*</label>
                                <input type="text" placeholder="#H25-21578455">
                            </div>
                            <div class="wsus__track_input">
                                <label class="d-block mb-2">email address*</label>
                                <input type="email" placeholder="customer-email@gmail.com">
                            </div>
                            <button type="submit" class="common_btn">track</button>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="wsus__track_header">
                            <div class="wsus__track_header_text">
                                <div class="row">
                                    <div class="col-xl-3 col-sm-6 col-lg-3">
                                        <div class="wsus__track_header_single">
                                            <h5>estimated delivery time:</h5>
                                            <p>20 nov 2021</p>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-lg-3">
                                        <div class="wsus__track_header_single">
                                            <h5>shopping by:</h5>
                                            <p>one shop</p>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-lg-3">
                                        <div class="wsus__track_header_single">
                                            <h5>status:</h5>
                                            <p>order Processing</p>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-lg-3">
                                        <div class="wsus__track_header_single border_none">
                                            <h5>tracking:</h5>
                                            <p>BD096547155HGU</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <ul class="progtrckr" data-progtrckr-steps="4">
                            <li class="progtrckr_done icon_one check_mark">Order pending</li>
                            <li class="progtrckr_done icon_two ">order Processing</li>
                            <li class="icon_three">on the way</li>
                            <li class="icon_four red_mark">ready for delivery</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        TRACKING ORDER END
    ==============================-->

@endsection
