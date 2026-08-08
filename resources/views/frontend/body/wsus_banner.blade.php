    <!--============================
        BANNER PART 2 START
    ==============================-->
    <style>
        #wsus__banner {
            position: relative;
            overflow: hidden;
            padding: 40px 0 0;
        }

        .wsus__banner_content {
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 26px 90px rgba(15, 23, 42, 0.12);
        }

        .wsus__single_slider {
            min-height: 520px;
            background-size: cover !important;
            background-position: center !important;
            display: flex;
            align-items: center;
            position: relative;
        }

        .wsus__single_slider::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, rgba(15, 23, 42, 0.72) 35%, rgba(15, 23, 42, 0.18) 100%);
        }

        .wsus__single_slider_text {
            position: relative;
            z-index: 2;
            padding: 56px 60px;
            max-width: 560px;
        }

        .wsus__single_slider_text h3 {
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: #f59e0b;
            margin-bottom: 16px;
        }

        .wsus__single_slider_text h1 {
            font-size: clamp(2.5rem, 5vw, 4.25rem);
            font-weight: 800;
            color: #ffffff;
            line-height: 1.05;
            margin-bottom: 24px;
            max-width: 13ch;
        }

        .wsus__single_slider_text p {
            color: rgba(255, 255, 255, 0.88);
            max-width: 520px;
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 28px;
        }

        .banner_cta_group {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .banner_btn_primary,
        .banner_btn_secondary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.96rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .banner_btn_primary {
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            color: #fff !important;
            box-shadow: 0 16px 34px rgba(245, 158, 11, 0.26);
        }

        .banner_btn_primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 42px rgba(245, 158, 11, 0.32);
        }

        .banner_btn_secondary {
            background: rgba(255, 255, 255, 0.18);
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, 0.28);
            backdrop-filter: blur(10px);
        }

        .banner_btn_secondary:hover {
            background: rgba(255, 255, 255, 0.28);
        }

        .slick-dots {
            bottom: 18px !important;
        }

        .slick-dots li button:before {
            color: #fff !important;
            font-size: 10px !important;
            opacity: 0.6;
        }

        .slick-dots li.slick-active button:before {
            opacity: 1;
            color: #f59e0b !important;
        }

        @media (max-width: 991px) {
            .wsus__single_slider_text {
                padding: 40px 34px;
            }
        }

        @media (max-width: 767px) {
            .wsus__single_slider {
                min-height: 420px;
            }

            .wsus__single_slider_text {
                padding: 28px 24px;
            }

            .banner_cta_group {
                justify-content: center;
            }
        }
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
