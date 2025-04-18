    <!--============================
        HOT DEALS START
    ==============================-->
    <section id="wsus__hot_deals" class="wsus__hot_deals_2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__section_header">
                        <h3>Latest Products</h3>
                    </div>
                </div>
            </div>
            <div class="row hot_deals_slider_2">
                @foreach ($secondSliderProducts as $secondSliderProduct)
                    <div class="col-xl-4 col-lg-6">
                        <div class="wsus__hot_deals_offer">
                            <div class="wsus__hot_deals_img">
                                <img src="{{ asset('frontend/images/pro0010.jpg') }}" alt="mobile"
                                    class="img-fluid w-100">
                            </div>
                            <div class="wsus__hot_deals_text">
                                <a class="wsus__hot_title"
                                    href="{{ route('frontend.product_details', ['id' => $secondSliderProduct->id]) }}">{{ $secondSliderProduct->name }}</a>
                                <p class="wsus__rating">
                                    @if ($secondSliderProduct->rate_average != 0)
                                        @for ($i = 1; $i <= $secondSliderProduct->rate_average; $i++)
                                            <i class="far fa-star"></i>
                                        @endfor
                                        @if ($secondSliderProduct->rate_average != floor($secondSliderProduct->rate_average))
                                            <i class="fas fa-star-half-alt"></i>
                                        @endif
                                    @else
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @endif
                                    <span>({{ $secondSliderProduct->reviews->count() }} Review)</span>
                                </p>
                                <p class="wsus__hot_deals_proce">DZ {{ $secondSliderProduct->price }}
                                    @if (false)
                                        <del>$200</del>
                                    @endif
                                </p>
                                <P class="wsus__details">
                                    {{ $secondSliderProduct->short_description }}
                                </P>
                                <ul>
                                    <li>
                                        @livewire('add-to-cart', ['product' => $secondSliderProduct], key($secondSliderProduct->id))
                                        {{--
                                        <form
                                            action="{{ route('frontend.cart.add_item', ['id' => $secondSliderProduct->id]) }}"
                                            method="POST">
                                            @csrf
                                            <div>
                                                <button class="btn" type="submit">
                                                    <a class="add_cart">add to cart</a>
                                                </button>
                                            </div>
                                        </form>
                                        --}}

                                    </li>
                                    <li><a href="#"><i class="far fa-heart"></i></a></li>
                                    <li class="cursor-pointer">
                                        @livewire('add-to-compare', ['productId' => $secondSliderProduct->id])
                                    </li>
                                </ul>
                                {{--
                                <div class="simply-countdown simply-countdown-one"></div>
                                --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="wsus__hot_large_item">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="wsus__section_header justify-content-start">
                            <div class="monthly_top_filter2 mb-1">
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
                <div class="row grid2">
                    @foreach ($regularProducts as $regularProduct)
                        <div class="col-xl-3 col-sm-6 col-md-4 col-lg-4 {{ $regularProduct->category->name }}">
                            <div class="wsus__product_item">
                                @if (false)
                                    <span class="wsus__new">New</span>
                                @endif
                                @if (false)
                                    <span class="wsus__minus">-20%</span>
                                @endif
                                <a class="wsus__pro_link"
                                    href="{{ route('frontend.product_details', ['id' => $regularProduct->id]) }}">
                                    <img src="{{ asset('frontend/images/charger_2.jpg') }}" alt="product"
                                        class="img-fluid w-100 img_1" />
                                    <img src="{{ asset('frontend/images/charger_1.jpg') }}" alt="product"
                                        class="img-fluid w-100 img_2" />
                                </a>
                                <ul class="wsus__single_pro_icon">
                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                                class="far fa-eye"></i></a></li>
                                    <li><a href="#"><i class="far fa-heart"></i></a></li>
                                    <li class="cursor-pointer">
                                        @livewire('add-to-compare', ['productId' => $regularProduct->id])
                                    </li>
                                </ul>
                                <div class="wsus__product_details">
                                    <a class="wsus__category" href="#">{{ $regularProduct->category->name }}</a>
                                    <p class="wsus__pro_rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span>({{ $regularProduct->reviews->count() }} Review)</span>
                                    </p>
                                    <a class="wsus__pro_name"
                                        href="{{ route('frontend.product_details', ['id' => $regularProduct->id]) }}">{{ $regularProduct->name }}</a>
                                    <p class="wsus__price">DZ {{ $regularProduct->price }}
                                        @if (false)
                                            <del>$ 50</del>
                                        @endif
                                    </p>
                                    @livewire('add-to-cart', ['product' => $regularProduct], key($regularProduct->id))
                                    {{--
                                    <form action="{{ route('frontend.cart.add_item', ['id' => $regularProduct->id]) }}"
                                        method="POST">
                                        @csrf
                                        <button class="btn add_cart" type="submit">add to cart</button>
                                    </form>
                                    --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <section id="wsus__single_banner" class="home_2_single_banner">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            <div class="wsus__single_banner_content banner_1">
                                <div class="wsus__single_banner_img">
                                    <img src="{{ asset('frontend/images/single_banner_44.jpg') }}" alt="banner"
                                        class="img-fluid w-100">
                                </div>
                                <div class="wsus__single_banner_text">
                                    <h6>sell on <span>35% off</span></h6>
                                    <h3>smart watch</h3>
                                    <a class="shop_btn" href="#">shop now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="wsus__single_banner_content single_banner_2">
                                        <div class="wsus__single_banner_img">
                                            <img src="{{ asset('frontend/images/single_banner_55.jpg') }}"
                                                alt="banner" class="img-fluid w-100">
                                        </div>
                                        <div class="wsus__single_banner_text">
                                            <h6>New Collection</h6>
                                            <h3>kid's fashion</h3>
                                            <a class="shop_btn" href="#">shop now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-lg-4">
                                    <div class="wsus__single_banner_content">
                                        <div class="wsus__single_banner_img">
                                            <img src="{{ asset('frontend/images/single_banner_66.jpg') }}"
                                                alt="banner" class="img-fluid w-100">
                                        </div>
                                        <div class="wsus__single_banner_text">
                                            <h6>sell on <span>42% off</span></h6>
                                            <h3>winter collection</h3>
                                            <a class="shop_btn" href="#">shop now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="wsus__hot_small_item wsus__hot_small_item_2">
                <div class="row">
                    @foreach ($randomProducts as $randomProduct)
                        <div class="col-xl-2 col-6 col-sm-6 col-md-4 col-lg-3">
                            <a class="wsus__hot_deals__single"
                                href="{{ route('frontend.product_details', ['id' => $randomProduct->id]) }} ">
                                <div class="wsus__hot_deals__single_img">
                                    <img src="{{ asset('frontend/images/pro4_4.jpg') }}" alt="bag"
                                        class="img-fluid w-100">
                                </div>
                                <div class="wsus__hot_deals__single_text">
                                    <h5>{{ $randomProduct->name }}</h5>
                                    <p class="wsus__rating">
                                        @if ($randomProduct->rate_average != 0)
                                            @for ($i = 1; $i <= $randomProduct->rate_average; $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                            @if ($randomProduct->rate_average != floor($randomProduct->rate_average))
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
                                    <p class="wsus__tk">DZ {{ $randomProduct->price }}
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
    </section>
    <!--============================
        HOT DEALS END
    ==============================-->
