    <!--============================
        HERO BANNER START
    ==============================-->
    @if($heroBanners->count() > 0)
    <section id="wsus__banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__banner_content">
                        <div class="row banner_slider">
                            @foreach ($heroBanners as $banner)
                                <div class="col-xl-12">
                                    @if(!empty($banner->image))
                                        @php $link = $banner->link_url; @endphp
                                        <div class="wsus__design_banner" style="position:relative;width:100%;aspect-ratio:16/9;overflow:hidden;border-radius:6px;">
                                            @if(!empty($link) && $link !== '#')
                                                <a href="{{ $link }}" style="display:block;width:100%;height:100%;">
                                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                                                </a>
                                            @else
                                                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                                            @endif
                                        </div>
                                    @elseif($banner->design_data)
                                        <x-banner-renderer :banner="$banner" />
                                    @else
                                        <div class="wsus__single_slider"
                                            style="background: url({{ asset('storage/' . ($banner->image ?: 'frontend/images/default_banner.jpg')) }});">
                                            <div class="wsus__single_slider_text">
                                                @if($banner->show_title)
                                                    <h3>{{ $banner->title }}</h3>
                                                @endif
                                                @if($banner->show_description)
                                                    <h1>{{ $banner->description }}</h1>
                                                @endif
                                                <div class="banner_cta_group">
                                                    <a class="banner_btn_primary" href="{{ $banner->link_url }}">
                                                        Shop Now <i class="fas fa-arrow-right"></i>
                                                    </a>
                                                    <a class="banner_btn_secondary" href="{{ route('frontend.products') }}">
                                                        Explore All <i class="fas fa-th-large"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .banner-blob { animation: floatBlob 20s ease-in-out infinite; }
        .banner-blob-delay { animation: floatBlob 25s ease-in-out infinite reverse; }
        @keyframes floatBlob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -20px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }
        .pulse-anim { animation: pulseIcon 3s ease-in-out infinite; }
        @keyframes pulseIcon {
            0%, 100% { opacity: 0.8; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.1); }
        }
        .shimmer-anim { animation: shimmerSlide 2.5s linear infinite; }
        @keyframes shimmerSlide {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
    @endif
    <!--============================
        HERO BANNER END
    ==============================-->
