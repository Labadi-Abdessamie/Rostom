@extends('frontend.master')

@section('title')
    ATLAS MALL || Daily Deals
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
                        <h4>daily deals</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">home</a></li>
                            <li><a href="#">daily deals</a></li>
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
        DAILY DEALS START
    ==============================-->
    <section id="wsus__daily_deals">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__daily_deals_single">
                        <div class="wsus__daily_deals_single_img">
                            <a class="link_img" href="#"> <img src="{{asset('frontend/images/daily_deals_1.jpg')}}" alt="offer"
                                    class="img-fluid w-100"></a>
                            <p>up to -70% off</p>
                            <a class="live" href="#">live now</a>
                        </div>
                        <div class="wsus__daily_deals_text">
                            <a class="deals_title" href="#">smart watch collection</a>
                            <p>sale start date: 07 dec 2021</p>
                            <p>sale end date: 29 dec 2021</p>
                            <a class="common_btn" href="daily_deals_details.html">view deals</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__daily_deals_single">
                        <div class="wsus__daily_deals_single_img">
                            <a class="link_img" href="#"> <img src="{{asset('frontend/images/daily_deals_2.jpg')}}" alt="offer"
                                    class="img-fluid w-100"></a>
                            <p>up to -35% off</p>
                            <a class="live" href="#">live now</a>
                        </div>
                        <div class="wsus__daily_deals_text">
                            <a class="deals_title" href="#">new arrival offer</a>
                            <p>sale start date: 07 dec 2021</p>
                            <p>sale end date: 29 dec 2021</p>
                            <a class="common_btn" href="daily_deals_details.html">view deals</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__daily_deals_single">
                        <div class="wsus__daily_deals_single_img">
                            <a class="link_img" href="#"> <img src="{{asset('frontend/images/daily_deals_3.jpg')}}" alt="offer"
                                    class="img-fluid w-100"></a>
                            <p>up to -49% off</p>
                            <a class="live" href="#">live now</a>
                        </div>
                        <div class="wsus__daily_deals_text">
                            <a class="deals_title" href="#">samsung new year offer</a>
                            <p>sale start date: 07 dec 2021</p>
                            <p>sale end date: 29 dec 2021</p>
                            <a class="common_btn" href="daily_deals_details.html">view deals</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__daily_deals_single">
                        <div class="wsus__daily_deals_single_img">
                            <a class="link_img" href="#"><img src="{{asset('frontend/images/daily_deals_4.jpg')}}" alt="offer"
                                    class="img-fluid w-100"></a>
                            <p>up to -31% off</p>
                            <a class="live" href="#">live now</a>
                        </div>
                        <div class="wsus__daily_deals_text">
                            <a class="deals_title" href="#">winter collection</a>
                            <p>sale start date: 07 dec 2021</p>
                            <p>sale end date: 29 dec 2021</p>
                            <a class="common_btn" href="daily_deals_details.html">view deals</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        DAILY DEALS END
    ==============================-->
@endsection
