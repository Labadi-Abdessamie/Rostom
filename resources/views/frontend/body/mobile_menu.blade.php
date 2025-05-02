    <!--============================
        MOBILE MENU START
    ==============================-->
    <section id="wsus__mobile_menu">
        <span class="wsus__mobile_menu_close"><i class="fal fa-times"></i></span>
        <ul class="wsus__mobile_menu_header_icon d-inline-flex">
            @if (Auth::check())
                @if (Auth::user()->role === 'client')
                    <li><a href="{{ route('frontend.wishlist') }}"><i class="fal fa-heart"></i>
                            @if (session()->has('wishlist'))
                                <span>{{ count(session('wishlist', [])) }}</span>
                            @else
                                <span>0</span>
                            @endif
                        </a></li>
                @endif
            @else
                <li><a href="{{ route('login') }}"><i class="fal fa-heart"></i><span>05</span></a></li>
            @endif
            <li><a href="{{ route('frontend.compare') }}"><i class="fal fa-random"></i>
                    @if (session()->has('compare'))
                        <span>{{ count(session('compare', [])) }}</span>
                    @else
                        <span>0</span>
                    @endif
                </a>
            </li>
        </ul>
        <form>
            <input type="text" placeholder="Search">
            <button type="submit"><i class="far fa-search"></i></button>
        </form>

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                    role="tab" aria-controls="pills-home" aria-selected="true">Categories</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                    role="tab" aria-controls="pills-profile" aria-selected="false">main menu</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="wsus__mobile_menu_main_menu">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <ul class="wsus_mobile_menu_category">
                            @if (count($categories) > 0)
                                @foreach ($categories as $category)
                                    <li>
                                        @if (count($category->childrens) > 0)
                                            <a href="#" class="accordion-button collapsed"
                                                data-bs-toggle="collapse" data-bs-target="#{{ $category->name }}"
                                                aria-expanded="false" aria-controls="{{ $category->name }}"><i
                                                    class="fal fa-tshirt"></i>
                                                {{ $category->name }}</a>
                                            <div id="{{ $category->name }}" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <ul>
                                                        @foreach ($category->childrens as $firstLevelChild)
                                                            <li>
                                                                <a
                                                                    href="{{ route('frontend.products', ['category' => $firstLevelChild->id]) }}">{{ $firstLevelChild->name }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                <li><a href=""><i class="fas fa-ban"></i>Categories Are none</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="wsus__mobile_menu_main_menu">
                    <div class="accordion accordion-flush" id="accordionFlushExample2">
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">home</a></li>
                            <li><a href="{{ route('frontend.products') }}">products</a></li>
                            <li><a href="{{ route('frontend.vendor') }}">vendors</a></li>
                            @if (Auth::user())
                                @if (Auth::user()->role == 'client')
                                    <li><a href="{{ route('frontend.cart') }}">Cart</a></li>
                                @endif
                            @endif
                            <li><a href="{{ route('frontend.contact') }}">Contact</a></li>

                            @if (false)
                                <li><a href="index.html">home</a></li>
                                <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseThree" aria-expanded="false"
                                        aria-controls="flush-collapseThree">shop</a>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushExample2">
                                        <div class="accordion-body">
                                            <ul>
                                                <li><a href="#">men's</a></li>
                                                <li><a href="#">wemen's</a></li>
                                                <li><a href="#">kid's</a></li>
                                                <li><a href="#">others</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li><a href="vendor.html">vendor</a></li>
                                <li><a href="blog.html">blog</a></li>
                                <li><a href="daily_deals.html">campain</a></li>
                                <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseThree101" aria-expanded="false"
                                        aria-controls="flush-collapseThree101">pages</a>
                                    <div id="flush-collapseThree101" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushExample2">
                                        <div class="accordion-body">
                                            <ul>
                                                <li><a href="404.html">404</a></li>
                                                <li><a href="faqs.html">faq</a></li>
                                                <li><a href="invoice.html">invoice</a></li>
                                                <li><a href="about_us.html">about</a></li>
                                                <li><a href="team.html">team</a></li>
                                                <li><a href="product_grid_view.html">product grid view</a></li>
                                                <li><a href="product_grid_view.html">product list view</a></li>
                                                <li><a href="team_details.html">team details</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li><a href="track_order.html">track order</a></li>
                                <li><a href="daily_deals.html">daily deals</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        MOBILE MENU END
    ==============================-->
