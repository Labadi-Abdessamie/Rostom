    <!--============================
        HEADER START
    ==============================-->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-2 col-md-1 d-lg-none">
                    <div class="wsus__mobile_menu_area">
                        <span class="wsus__mobile_menu_icon"><i class="fal fa-bars"></i></span>
                    </div>
                </div>
                <div class="col-xl-2 col-7 col-md-8 col-lg-2">
                    <div class="wsus_logo_area">
                        <a class="wsus__header_logo" href="{{ route('frontend.index') }}">
                            <img src="{{ asset('frontend/images/logo_2.png') }}" alt="logo" class="img-fluid w-100">
                        </a>
                    </div>
                </div>
                <div class="col-xl-5 col-md-6 col-lg-4 d-none d-lg-block">
                    <div class="wsus__search">
                        <form>
                            <input type="text" placeholder="Search...">
                            <button type="submit"><i class="far fa-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="col-xl-5 col-3 col-md-3 col-lg-6">
                    <div class="wsus__call_icon_area">
                        <div class="wsus__call_area">
                            <div class="wsus__call">
                                <i class="fas fa-user-headset"></i>
                            </div>
                            <div class="wsus__call_text">
                                <p>support@atlas-mall.dz</p>
                                <p>+213770707070</p>
                            </div>
                        </div>
                        <ul class="wsus__icon_area">
                            @if (Auth::check())
                                <li><a href="{{ route('frontend.wishlist') }}"><i
                                            class="fal fa-heart"></i><span>1</span></a></li>
                            @else
                                <li><a href="{{ route('login') }}"><i class="fal fa-heart"></i><span>05</span></a></li>
                            @endif


                            <li><a href="{{ route('frontend.compare') }}"><i
                                        class="fal fa-random"></i><span>03</span></a></li>
                            @if (Auth::check())
                                <li><a class="wsus__cart_icon cursor-pointer"><i class="fal fa-shopping-bag"></i>
                                        @if (session()->has('cart'))
                                            <span>{{ count(session('cart', [])) }}</span>
                                        @else
                                            <span>0</span>
                                            {{-- ! wtf this is a huge problem --}}
                                        @endif
                                    </a>
                                </li>
                            @else
                                <li><a class="wsus__cart_icon" href="{{ route('login') }}"><i
                                            class="fal fa-shopping-bag"></i><span>4</span></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @auth
            <div class="wsus__mini_cart">
                <h4>shopping cart <span class="wsus_close_mini_cart"><i class="far fa-times"></i></span></h4>
                <ul>
                    @if ($cart != [])
                        @php $total = 0 @endphp
                        @foreach ($cart as $key => $item)
                            <li>
                                <div class="wsus__cart_img">
                                    <a href="{{ route('frontend.cart.remove_item', ['id' => $key]) }}"><img
                                            src="{{ asset('frontend/images/tab_2.jpg') }}" alt="product"
                                            class="img-fluid w-100"></a>
                                    <form action="{{ route('frontend.cart.remove_item', ['id' => $key]) }}" method="POST">
                                        @csrf
                                        <button class="btn" type="submit">
                                            <a class="wsis__del_icon" href=""><i class="fas fa-minus-circle"></i></a>
                                        </button>
                                    </form>
                                </div>
                                <div class="wsus__cart_text">
                                    <a class="wsus__cart_title"
                                        href="{{ route('frontend.product_details', ['id' => $key]) }}">
                                        {{ $item['product']['name'] }} </a>
                                    <span> × {{ $item['quantity'] }}</span>
                                    <p>DZ {{ $item['product']['price'] }}
                                        @if (false)
                                            <del>DZ 150</del>
                                        @endif
                                    </p>
                                </div>
                            </li>
                            @php $total += $item['product']['price'] * $item['quantity']; @endphp
                        @endforeach
                    @else
                    @endif
                </ul>
                <h5>sub total <span>
                        @if (@empty($cart))
                            DZ 0
                        @else
                            DZ {{ $total }}
                        @endif
                    </span></h5>
                <div class="wsus__minicart_btn_area">
                    <a class="common_btn" href="{{ route('frontend.cart') }}">view cart</a>
                    <a class="common_btn" href="{{ route('frontend.check_out') }}">checkout</a>
                </div>
            </div>
        @endauth
    </header>
    <!--============================
        HEADER END
    ==============================-->
