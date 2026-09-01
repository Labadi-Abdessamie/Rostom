    <!--============================
        HEADER START
    ==============================-->
    <header class="wsus__header">
        <div class="container">
            <div class="wsus__header_inner">

                {{-- Hamburger — mobile only, top left corner --}}
                <button type="button" class="wsus__mobile_hamburger" id="mobileHamburgerBtn" onclick="toggleMobileNavMenu()" aria-label="Open menu">
                    <i class="fas fa-bars" id="hamburgerIcon"></i>
                </button>

                {{-- Logo — centered --}}
                <a class="wsus__header_logo" href="{{ route('frontend.index') }}">
                    <img src="{{ file_exists(public_path('frontend/images/tiarshop-logo.png')) ? asset('frontend/images/tiarshop-logo.png') : asset('frontend/images/logo.png') }}"
                         alt="{{ $website->name }}" class="img-fluid"
                         onerror="this.src='{{ asset('frontend/images/logo.png') }}'">
                </a>

                {{-- Search Bar --}}
                <form action="{{ route('frontend.search') }}" class="wsus__header_search">
                    @csrf
                    <input name="query" type="text" placeholder="Search products, brands..." class="form-control">
                    <button type="submit" class="wsus__search_btn" style="position:relative!important;display:flex!important;align-items:center!important;justify-content:center!important;float:none!important;top:auto!important;transform:none!important;right:auto!important;left:auto!important;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                {{-- Right Side: Login / Register (all right-aligned) --}}
                <div class="wsus__header_right wsus__header_right_mobile" id="headerRightMobile">
                    {{-- Login / Register — larger, clear, always visible --}}
                    <div class="wsus__mobile_auth_links">
                        @auth
                            <a href="{{ route('dashboard') }}" class="wsus__mobile_auth_btn wsus__mobile_auth_btn_primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="wsus__mobile_auth_btn">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="wsus__mobile_auth_btn wsus__mobile_auth_btn_secondary">Register</a>
                            @endif
                        @endauth
                    </div>

                    @livewire('icons')
                </div>

                {{-- Search Bar (below the logo row on mobile) --}}
                <form action="{{ route('frontend.search') }}" class="wsus__header_search wsus__header_search_mobile" id="mobileSearchForm">
                    @csrf
                    <input name="query" type="text" placeholder="Search products, brands..." class="form-control" aria-label="Search">
                    <button type="submit" class="wsus__search_btn" aria-label="Search">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

            </div>
        </div>
    </header>
    <!--============================
        HEADER END
    ==============================-->
