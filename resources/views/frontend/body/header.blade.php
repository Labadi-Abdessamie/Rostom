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


                            <li><a href="{{ route('frontend.compare') }}"><i class="fal fa-random"></i>
                                    @if (session()->has('compare'))
                                        <span>{{ count(session('compare', [])) }}</span>
                                    @else
                                        <span>00</span>
                                    @endif
                                </a></li>
                            @if (Auth::check())
                                <li><a class="wsus__cart_icon cursor-pointer"><i class="fal fa-shopping-bag"></i>
                                        @if (session()->has('cart'))
                                            <span>{{ count(session('cart', [])) }}</span>
                                        @else
                                            <span>0</span>
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
            @livewire('cart', ['type' => 'mini'])
        @endauth
    </header>
    <!--============================
        HEADER END
    ==============================-->
