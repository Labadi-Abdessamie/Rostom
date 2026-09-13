    <!--============================
        SINGLE BANNER START
    ==============================-->
    @if($singleBanners->count() > 0)
    <section id="wsus__single_banner" class="wsus__single_banner_2 mt-4">
        <div class="container">
            <div class="row">
                @foreach($singleBanners as $index => $banner)
                    @if($index < 2)
                    <div class="col-xl-6 col-lg-6">
                        @if($banner->design_data)
                            <x-banner-renderer :banner="$banner" />
                        @else
                            <div class="wsus__single_banner_content">
                                <div class="wsus__single_banner_img">
                                    <img src="{{ asset('storage/' . ($banner->image ?: 'frontend/images/default_banner.jpg')) }}" alt="{{ $banner->title ?? 'Banner' }}" class="img-fluid w-100">
                                </div>
                                <div class="wsus__single_banner_text">
                                    @if($banner->show_title) <h6>{{ $banner->title }}</h6> @endif
                                    @if($banner->show_description) <h3>{{ $banner->description }}</h3> @endif
                                    <a class="shop_btn" href="{{ $banner->link_url }}">shop now</a>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!--============================
        SINGLE BANNER END
    ==============================-->
