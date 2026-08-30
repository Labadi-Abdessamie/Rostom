    <!--============================
        HEADER START
    ==============================-->
    <header class="wsus__header">
        <div class="container">
            <div class="wsus__header_inner">

                {{-- Logo --}}
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

                {{-- Right Side: Contact + Icons --}}
                <div class="wsus__header_right">
                    <a href="tel:+213{{ $website->contact_phone }}" class="wsus__header_contact">
                        <span class="wsus__header_contact_icon">
                            <i class="fas fa-phone-volume"></i>
                        </span>
                        <span class="wsus__header_contact_text">
                            <small>Need Help?</small>
                            <strong>+213 {{ $website->contact_phone }}</strong>
                        </span>
                    </a>
                    @livewire('icons')
                </div>

            </div>
        </div>
    </header>
    <!--============================
        HEADER END
    ==============================-->
