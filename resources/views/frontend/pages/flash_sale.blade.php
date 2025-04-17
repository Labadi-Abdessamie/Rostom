@extends('frontend.master')

@section('title')
    ATLAS MALL || Flash Sale
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
                        <h4>Flash Sale</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">Home</a></li>
                            <li><a href="#">flash sale</a></li>
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
        DAILY DEALS DETAILS START
    ==============================-->
    <section id="wsus__daily_deals">
        <div class="container">
            <div class="wsus__offer_details_area">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="wsus__offer_details_banner">
                            <img src="{{asset('frontend/images/offer_banner_2.png')}}" alt="offrt img" class="img-fluid w-100">
                            <div class="wsus__offer_details_banner_text">
                                <p>apple watch</p>
                                <span>up 50% 0ff</span>
                                <p>for all poduct</p>
                                <p><b>today only</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="wsus__offer_details_banner">
                            <img src="{{asset('frontend/images/offer_banner_3.png')}}" alt="offrt img" class="img-fluid w-100">
                            <div class="wsus__offer_details_banner_text">
                                <p>xiaomi power bank</p>
                                <span>up 37% 0ff</span>
                                <p>for all poduct</p>
                                <p><b>today only</b></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="wsus__section_header rounded-0">
                            <h3>flash sell</h3>
                            <div class="wsus__offer_countdown">
                                <span class="end_text">ends time :</span>
                                <div class="simply-countdown simply-countdown-one"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-3">
                        <div class="wsus__offer_det_single">
                            <div class="wsus__product_item">
                                <a class="wsus__pro_link" href="{{ route('frontend.product_details') }}">
                                    <img src="{{asset('frontend/images/offer_3333.jpg')}}" alt="product" class="img-fluid w-100 img_1" />
                                    <img src="{{asset('frontend/images/pro9_9.jpg')}}" alt="product" class="img-fluid w-100 img_2" />
                                </a>
                                <div class="wsus__product_details">
                                    <a class="wsus__category" href="#">fashion </a>
                                    <p class="wsus__pro_rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span>(120 review)</span>
                                    </p>
                                    <a class="wsus__pro_name" href="#">men's fashion sholder bag</a>
                                    <p class="wsus__price">$159 <del>$200</del></p>
                                    <a class="add_cart" href="#">add to cart</a>
                                </div>
                            </div>
                            <div class="wsus__offer_progress">
                                <p><span>Sold 91</span> <span>Total 120</span></p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65"
                                        aria-valuemin="0" aria-valuemax="100">65%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="wsus__offer_det_single">
                            <div class="wsus__product_item">
                                <a class="wsus__pro_link" href="{{ route('frontend.product_details') }}">
                                    <img src="{{asset('frontend/images/offer_1111.jpg')}}" alt="product" class="img-fluid w-100 img_1" />
                                    <img src="{{asset('frontend/images/pro2_2.jpg')}}" alt="product" class="img-fluid w-100 img_2" />
                                </a>
                                <div class="wsus__product_details">
                                    <a class="wsus__category" href="#">fashion </a>
                                    <p class="wsus__pro_rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span>(72 review)</span>
                                    </p>
                                    <a class="wsus__pro_name" href="#">men's casual shoes</a>
                                    <p class="wsus__price">$159 <del>$200</del></p>
                                    <a class="add_cart" href="#">add to cart</a>
                                </div>
                            </div>
                            <div class="wsus__offer_progress">
                                <p><span>Sold 91</span> <span>Total 120</span></p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65"
                                        aria-valuemin="0" aria-valuemax="100">65%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="wsus__offer_det_single">
                            <div class="wsus__product_item">
                                <a class="wsus__pro_link" href="{{ route('frontend.product_details') }}">
                                    <img src="{{asset('frontend/images/offer_6.jpg')}}" alt="product" class="img-fluid w-100 img_1" />
                                    <img src="{{asset('frontend/images/offer_8.jpg')}}" alt="product" class="img-fluid w-100 img_2" />
                                </a>
                                <div class="wsus__product_details">
                                    <a class="wsus__category" href="#">Electronics </a>
                                    <p class="wsus__pro_rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span>(120 review)</span>
                                    </p>
                                    <a class="wsus__pro_name" href="#">man casual fashion cap</a>
                                    <p class="wsus__price">$115</p>
                                    <a class="add_cart" href="#">add to cart</a>
                                </div>
                            </div>
                            <div class="wsus__offer_progress">
                                <p><span>Sold 91</span> <span>Total 120</span></p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65"
                                        aria-valuemin="0" aria-valuemax="100">65%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="wsus__offer_det_single">
                            <div class="wsus__product_item">
                                <a class="wsus__pro_link" href="{{ route('frontend.product_details') }}">
                                    <img src="{{asset('frontend/images/offer_3333.jpg')}}" alt="product" class="img-fluid w-100 img_1" />
                                    <img src="{{asset('frontend/images/pro9_9.jpg')}}" alt="product" class="img-fluid w-100 img_2" />
                                </a>
                                <div class="wsus__product_details">
                                    <a class="wsus__category" href="#">fashion </a>
                                    <p class="wsus__pro_rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span>(120 review)</span>
                                    </p>
                                    <a class="wsus__pro_name" href="#">men's fashion sholder bag</a>
                                    <p class="wsus__price">$159 <del>$200</del></p>
                                    <a class="add_cart" href="#">add to cart</a>
                                </div>
                            </div>
                            <div class="wsus__offer_progress">
                                <p><span>Sold 91</span> <span>Total 120</span></p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65"
                                        aria-valuemin="0" aria-valuemax="100">65%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        DAILY DEALS DETAILS END
    ==============================-->
@endsection
