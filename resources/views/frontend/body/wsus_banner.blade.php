    <!--============================
        BANNER PART 2 START
    ==============================-->
    <style>
        #wsus__banner { position: relative; overflow: hidden; }
        .wsus__banner_content { border-radius: 16px; overflow: hidden; box-shadow: 0 8px 40px rgba(0,0,0,.18); }
        .wsus__single_slider {
            min-height: 500px;
            background-size: cover !important;
            background-position: center !important;
            display: flex;
            align-items: center;
            position: relative;
        }
        .wsus__single_slider::before {
            content:'';
            position:absolute;
            inset:0;
            background: linear-gradient(100deg, rgba(15,23,42,.75) 45%, rgba(15,23,42,.15) 100%);
        }
        .wsus__single_slider_text {
            position: relative;
            z-index: 2;
            padding: 60px 60px;
            max-width: 560px;
        }
        .wsus__single_slider_text h3 {
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #f59e0b;
            margin-bottom: 12px;
        }
        .wsus__single_slider_text h1 {
            font-size: clamp(2rem, 4vw, 3.2rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 28px;
        }
        .banner_cta_group { display: flex; gap: 14px; flex-wrap: wrap; }
        .banner_btn_primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            color: #fff !important;
            padding: 13px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: .93rem;
            letter-spacing: .5px;
            text-decoration: none;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 20px rgba(245,158,11,.4);
        }
        .banner_btn_primary:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(245,158,11,.55); }
        .banner_btn_secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,.12);
            color: #fff !important;
            padding: 13px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: .93rem;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,.3);
            backdrop-filter: blur(4px);
            transition: background .2s;
        }
        .banner_btn_secondary:hover { background: rgba(255,255,255,.22); }
        .slick-dots { bottom: 18px !important; }
        .slick-dots li button:before { color: #fff !important; font-size: 10px !important; opacity: .6; }
        .slick-dots li.slick-active button:before { opacity: 1; color: #f59e0b !important; }
    </style>
    <section id="wsus__banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__banner_content">
                        <div class="row banner_slider">
                            @foreach ($banners as $banner)
                                <div class="col-xl-12">
                                    <div class="wsus__single_slider"
                                        style="background: url({{ asset('storage/banners/' . $banner->image) }});">
                                        <div class="wsus__single_slider_text">
                                            <h3>{{ $banner->title }}</h3>
                                            <h1>{{ $banner->description }}</h1>
                                            <div class="banner_cta_group">
                                                <a class="banner_btn_primary" href="{{ route($banner->link) }}">
                                                    Shop Now <i class="fas fa-arrow-right"></i>
                                                </a>
                                                <a class="banner_btn_secondary" href="{{ route('frontend.products') }}">
                                                    Explore All <i class="fas fa-th-large"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BANNER PART 2 END
    ==============================-->
