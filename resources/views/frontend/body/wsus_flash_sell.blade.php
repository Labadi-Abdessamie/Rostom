    <!--============================
        FLASH SELL START
    ==============================-->

    <section id="wsus__flash_sell" class="wsus__flash_sell_2">
        <div class=" container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="offer_time" style="background: url({{ asset('frontend/images/flash_sell_bg.jpg') }})">
                        <div class="wsus__flash_coundown">
                            <span class=" end_text">flash sell</span>
                            <div class="simply-countdown simply-countdown-one"></div>
                            <a class="common_btn" href="{{-- route('frontend.flash_sale') --}}">see more <i
                                    class="fas fa-caret-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row flash_sell_slider">
                @foreach ($sliderProducts as $sliderProduct)
                    <div class="col-xl-3 col-sm-6 col-lg-4">
                        <div class="wsus__product_item">
                            @if (false)
                                <span class="wsus__new">New</span>
                            @endif
                            @if (false)
                                <span class="wsus__minus">-20%</span>
                            @endif
                            <a class="wsus__pro_link"
                                href="{{ route('frontend.product_details', ['id' => $sliderProduct->id]) }}">
                                <img src="{{ asset('storage/products_images/' . $sliderProduct->id . '/' . $sliderProduct->principalImage) }}"
                                    alt="product" class="img-fluid w-100 img_1" />
                                <img src="
                                        @if (@empty($sliderProduct->productImages)) {{ asset('storage/products_images/' . $sliderProduct->id . '/' . $sliderProduct->productImages[0]) }}
                                        @else {{ asset('storage/products_images/' . $sliderProduct->id . '/' . $sliderProduct->principalImage) }} @endif
                                        "
                                    alt="product" class="img-fluid w-100 img_2" />
                            </a>
                            <ul class="wsus__single_pro_icon">
                                @if (false)
                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                                class="far fa-eye"></i></a></li>
                                @endif
                                <li class="cursor-pointer">
                                    @livewire('add-to-wishlist', ['product' => $sliderProduct], key($sliderProduct->id))
                                </li>
                                <li class="cursor-pointer">
                                    @livewire('add-to-compare', ['productId' => $sliderProduct->id])
                                </li>
                            </ul>
                            <div class="wsus__product_details">
                                <a class="wsus__category"
                                    href="{{ route('frontend.products', ['category' => $sliderProduct->category->id]) }}">{{ $sliderProduct->category->name }}
                                </a>
                                <p class="wsus__pro_rating">
                                    @if ($sliderProduct->rate_average != 0)
                                        @for ($i = 1; $i <= $sliderProduct->rate_average; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @if ($sliderProduct->rate_average != floor($sliderProduct->rate_average))
                                            <i class="fas fa-star-half-alt"></i>
                                        @endif
                                    @else
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @endif
                                    <span>({{ $sliderProduct->reviews->count() }} review)</span>
                                </p>
                                <a class="wsus__pro_name"
                                    href="{{ route('frontend.product_details', ['id' => $sliderProduct->id]) }}">{{ $sliderProduct->name }}</a>
                                <p class="wsus__price">DZ {{ $sliderProduct->price }}
                                    @if (false)
                                        <del>$200</del>
                                    @endif
                                </p>
                                @livewire('add-to-cart', ['product' => $sliderProduct], key($sliderProduct->id))
                                {{-- <livewire:cart :item_Id="$sliderProduct->id" :actionType="'addItem'" /> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--============================
        FLASH SELL END
    ==============================-->
