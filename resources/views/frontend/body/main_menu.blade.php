    <!--============================
        MAIN MENU START
    ==============================-->
    <nav class="wsus__main_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">

                    {{-- Main Navigation --}}
                    <ul class="wsus__menu_item">
                        <li>
                            <a href="{{ route('frontend.index') }}"
                               class="{{ Route::currentRouteName() == 'frontend.index' ? 'active' : '' }}">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('frontend.products') }}"
                               class="{{ Route::currentRouteName() == 'frontend.products' ? 'active' : '' }}">
                                <i class="fas fa-box-open"></i> Products
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('frontend.vendor') }}"
                               class="{{ Route::currentRouteName() == 'frontend.vendor' ? 'active' : '' }}">
                                <i class="fas fa-store"></i> Vendors
                            </a>
                        </li>
                        @auth
                            @if(Auth::user()->role === 'client')
                                <li>
                                    <a href="javascript:void(0)" onclick="openCartPanel()"
                                       class="{{ Route::currentRouteName() == 'frontend.cart' ? 'active' : '' }}">
                                        <i class="fas fa-shopping-cart"></i> Cart
                                    </a>
                                </li>
                            @endif
                        @else
                            <li>
                                <a href="{{ route('frontend.cart') }}"
                                   class="{{ Route::currentRouteName() == 'frontend.cart' ? 'active' : '' }}">
                                    <i class="fas fa-shopping-cart"></i> Cart
                                </a>
                            </li>
                        @endauth
                        <li>
                            <a href="{{ route('frontend.contact') }}"
                               class="{{ Route::currentRouteName() == 'frontend.contact' ? 'active' : '' }}">
                                <i class="fas fa-envelope"></i> Contact
                            </a>
                        </li>
                    </ul>

                </div>
                <div class="col-auto">
                    {{-- Auth / Dashboard --}}
                    <ul class="wsus__menu_item wsus__menu_item_right">
                        @auth
                            <li>
                                <a href="{{ route('dashboard') }}" class="wsus__menu_auth_btn">
                                    <i class="fas fa-user-circle"></i>
                                    @switch(Auth::user()->role)
                                        @case('client') My Dashboard @break
                                        @case('vendor') Magasin @break
                                        @case('admin') Dashboard @break
                                        @default Dashboard
                                    @endswitch
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}"
                                   class="{{ Route::currentRouteName() == 'login' ? 'active' : '' }}">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!--============================
        MAIN MENU END
    ==============================-->
