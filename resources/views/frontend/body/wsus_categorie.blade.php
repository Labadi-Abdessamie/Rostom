    <!--============================
        ELECTRONIC PART START
    ==============================-->
    <section id="wsus__electronic">
        <div class="container">
            @if (count($categoryProducts) > 0)
                <div class="row">
                    <div class="col-xl-12">
                        <div class="wsus__section_header">
                            <h3>{{ $categoryProducts[0]->category->name }}</h3>
                            <a class="see_btn"
                                href="{{ route('frontend.products', ['category' => $categoryProducts[0]->category->id]) }}">see
                                more <i class="fas fa-caret-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row flash_sell_slider">
                    @foreach ($categoryProducts as $categoryProduct)
                        <div class="col-xl-3 col-sm-6 col-lg-4">
                            <div class="wsus__product_item">
                                @if (false)
                                    <span class="wsus__new">New</span>
                                @endif
                                @if (false)
                                    <span class="wsus__minus">-20%</span>
                                @endif
                                <a class="wsus__pro_link"
                                    href="{{ route('frontend.product_details', ['id' => $categoryProduct->id]) }}">
                                    <img src="{{ asset('frontend/images/mobile_1.jpg') }}" alt="product"
                                        class="img-fluid w-100 img_1" />
                                    <img src="{{ asset('frontend/images/mobile_2.jpg') }}" alt="product"
                                        class="img-fluid w-100 img_2" />
                                </a>
                                <ul class="wsus__single_pro_icon">
                                    @if (false)
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                                    class="far fa-eye"></i></a></li>
                                    @endif
                                    <li class="cursor-pointer">
                                        @livewire('add-to-wishlist', ['product' => $categoryProduct], key($categoryProduct->id))
                                    </li>
                                    <li class="cursor-pointer">
                                        @livewire('add-to-compare', ['productId' => $categoryProduct->id])
                                    </li>
                                </ul>
                                <div class="wsus__product_details">
                                    <a class="wsus__category"
                                        href="{{ route('frontend.products', ['category' => $categoryProduct->category->id]) }}">{{ $categoryProduct->category->name }}</a>
                                    <p class="wsus__pro_rating">
                                        @if ($categoryProduct->rate_average != 0)
                                            @for ($i = 1; $i <= $categoryProduct->rate_average; $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                            @if ($categoryProduct->rate_average != floor($categoryProduct->rate_average))
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                        @else
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @endif
                                        <span>({{ $categoryProduct->reviews->count() }} review)</span>
                                    </p>
                                    <a class="wsus__pro_name"
                                        href="{{ route('frontend.product_details', ['id' => $categoryProduct->id]) }}">{{ $categoryProduct->name }}</a>
                                    <p class="wsus__price">DZ {{ $categoryProduct->price }}
                                        @if (false)
                                            <del>$199</del>
                                        @endif
                                    </p>
                                    @livewire('add-to-cart', ['product' => $categoryProduct], key($categoryProduct->id))
                                    {{--
                                    <form action="{{ route('frontend.cart.add_item', ['id' => $categoryProduct->id]) }}"
                                        method="POST">
                                        @csrf
                                        <button class="btn add_cart" type="submit">add to cart
                                        </button>
                                    </form>
                                    --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
            @endif
        </div>
        </div>
    </section>
    <!--============================
        ELECTRONIC PART END
    ==============================-->
