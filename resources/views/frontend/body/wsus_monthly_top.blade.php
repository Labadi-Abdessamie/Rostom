    <!--============================
       MONTHLY TOP PRODUCT START
    ==============================-->
    <section id="wsus__monthly_top" class="wsus__monthly_top_2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="wsus__monthly_top_banner">
                        <div class="wsus__monthly_top_banner_img">
                            <img src="{{ asset('frontend/images/monthly_top_img3.jpg') }}" alt="img"
                                class="img-fluid w-100">
                            <span></span>
                        </div>
                        <div class="wsus__monthly_top_banner_text">
                            <h4>Black Friday Sale</h4>
                            <h3>Up To <span>70% Off</span></h3>
                            <H6>Everything</H6>
                            <a class="shop_btn" href="#">shop now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__section_header for_md">
                        <h3>Monthly Products</h3>
                        <div class="monthly_top_filter">
                            <button class="ms-0 active" data-filter="*">All</button>
                            @php $i=0;@endphp
                            @foreach ($categories as $category)
                                @if ($i == 4)
                                    <button class="me-0"
                                        data-filter=".{{ $category->name }}">{{ $category->name }}</button>
                                    @break

                                @else
                                    <button data-filter=".{{ $category->name }}">{{ $category->name }}</button>
                                @endif
                                @php $i++; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="row grid">
                        @foreach ($monthlyProducts as $monthlyProduct)
                            <div
                                class="col-xl-2 col-6 col-sm-6 col-md-4 col-lg-3 {{ $monthlyProduct->category->name }}">
                                <a class="wsus__hot_deals__single"
                                    href="{{ route('frontend.product_details', ['id' => $monthlyProduct->id]) }} ">
                                    <div class="wsus__hot_deals__single_img">
                                        <img src="{{ asset('frontend/images/pro8_8.jpg') }}" alt="bag"
                                            class="img-fluid w-100">

                                    </div>
                                    <div class="wsus__hot_deals__single_text">
                                        <h5>{{ $monthlyProduct->name }}</h5>
                                        <p class="wsus__rating">
                                            @if ($monthlyProduct->rate_average != 0)
                                                @for ($i = 1; $i <= $monthlyProduct->rate_average; $i++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                                @if ($monthlyProduct->rate_average != floor($monthlyProduct->rate_average))
                                                    <i class="fas fa-star-half-alt"></i>
                                                @endif
                                            @else
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @endif
                                        </p>
                                        <p class="wsus__tk">
                                            DZ {{ $monthlyProduct->price }}
                                            @if (false)
                                                <del>130.00</del>
                                            @endif
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
       MONTHLY TOP PRODUCT END
    ==============================-->
