    <!--============================
        LARGE BANNER  START
    ==============================-->
    @if($largeBanners->count() > 0)
    @foreach($largeBanners as $banner)
    <section id="wsus__large_banner">
        <div class="container">
            <div class="row">
                <div class="cl-xl-12">
                    @if($banner->design_data)
                        <x-banner-renderer :banner="$banner" />
                    @else
                        <div class="wsus__large_banner_content" style="background: url({{ asset('storage/' . ($banner->image ?: 'frontend/images/default_banner.jpg')) }});">
                            <div class="wsus__large_banner_content_overlay">
                                <div class="row">
                                    <div class="col-xl-6 col-12 col-md-6">
                                        <div class="wsus__large_banner_text">
                                            @if($banner->show_title)<h3>{{ $banner->title }}</h3>@endif
                                            @if($banner->show_description)<p>{{ $banner->description }}</p>@endif
                                            <a class="shop_btn" href="{{ $banner->link_url }}">view more</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-12 col-md-6">
                                        <div class="wsus__large_banner_text wsus__large_banner_text_right">
                                            @if($banner->show_title)<h3>{{ $banner->title }}</h3>@endif
                                            <h5>up to 20% off</h5>
                                            @if($banner->show_description)<p>{{ $banner->description }}</p>@endif
                                            <a class="shop_btn" href="{{ $banner->link_url }}">shop now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endforeach
    @endif
    <!--============================
        LARGE BANNER  END
    ==============================-->
