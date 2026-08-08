<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
    <title>@yield('title', $website->name . ' || e-Commerce Multi-vendeurs')</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('frontend/webfonts/css2.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.nice-number.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/add_row_custon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/mobile_menu.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.exzoom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/multiple-image-video.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/ranger_style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.classycountdown.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/toastr.css') }}">
    <style>
        /* ===== GLOBAL DESIGN ENHANCEMENTS ===== */
        :root {
            --color-primary: #f59e0b;
            --color-secondary: #ef4444;
            --color-dark: #0f172a;
            --color-surface: #ffffff;
            --color-muted: #64748b;
            --radius-card: 18px;
            --shadow-soft: 0 20px 60px rgba(15, 23, 42, 0.08);
        }

        body {
            background: #f8fafc;
            color: #0f172a;
            font-family: 'Inter', 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }

        .wsus__section_header {
            align-items: center;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 2.25rem !important;
            flex-wrap: wrap;
        }

        .wsus__section_header h3 {
            font-size: 1.75rem !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            position: relative;
            padding-bottom: 0.9rem;
            margin: 0;
        }

        .wsus__section_header h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 64px;
            height: 4px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
        }

        .wsus__section_header .see_btn,
        .wsus__section_header .shop_btn {
            color: #0f172a;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: color .2s ease, transform .2s ease;
        }

        .wsus__section_header .see_btn:hover,
        .wsus__section_header .shop_btn:hover {
            color: var(--color-secondary);
            transform: translateY(-1px);
        }

        .wsus__product_item,
        .wsus__hot_deals_offer,
        .wsus__hot_deals__single,
        .wsus__product_details,
        .wsus__monthly_top_banner {
            border-radius: var(--radius-card) !important;
        }

        .wsus__product_item,
        .wsus__hot_deals_offer,
        .wsus__hot_deals__single {
            background: #ffffff !important;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.07) !important;
            transition: transform .28s ease, box-shadow .28s ease !important;
            overflow: hidden !important;
        }

        .wsus__product_item:hover,
        .wsus__hot_deals_offer:hover,
        .wsus__hot_deals__single:hover {
            transform: translateY(-6px) !important;
            box-shadow: 0 28px 70px rgba(15, 23, 42, 0.12) !important;
        }

        .wsus__product_item img,
        .wsus__hot_deals__single img,
        .wsus__monthly_top_banner_img img {
            transition: transform .35s ease;
        }

        .wsus__product_item:hover img,
        .wsus__hot_deals__single:hover img {
            transform: scale(1.03);
        }

        .wsus__product_details {
            padding: 1rem 1.15rem 1.25rem !important;
        }

        .wsus__category,
        .wsus__pro_rating,
        .wsus__rating {
            color: var(--color-muted) !important;
            font-size: 0.82rem !important;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .wsus__pro_name,
        .wsus__hot_title {
            font-weight: 700 !important;
            color: #0f172a !important;
            line-height: 1.3 !important;
            margin-bottom: 0.65rem !important;
            display: block;
        }

        .wsus__price,
        .wsus__hot_deals_proce {
            font-weight: 800 !important;
            color: var(--color-primary) !important;
            font-size: 1.1rem !important;
            margin: 0.45rem 0 0 !important;
        }

        .common_btn,
        .add_cart,
        .btn-cart,
        .shop_btn,
        .banner_btn_primary,
        .banner_btn_secondary {
            border-radius: 999px !important;
            font-weight: 700 !important;
        }

        .common_btn:hover,
        .add_cart:hover,
        .btn-cart:hover,
        .shop_btn:hover,
        .banner_btn_primary:hover,
        .banner_btn_secondary:hover {
            transform: translateY(-2px) !important;
        }

        .wsus__hot_deals_offer .wsus__hot_deals_img,
        .wsus__hot_deals__single_img,
        .wsus__product_item .wsus__pro_link {
            display: block;
        }

        #wsus__hot_deals,
        #wsus__monthly_top,
        #wsus__electronic,
        #wsus__flash_sell,
        #wsus__home_services {
            padding: 70px 0 !important;
        }

        #wsus__single_banner {
            padding: 0 0 45px !important;
        }

        .wsus__monthly_top_banner {
            overflow: hidden;
            position: relative;
            min-height: 380px;
            background: linear-gradient(135deg, #fdf2e8 0%, #ffffff 100%);
            border: 1px solid rgba(15, 23, 42, 0.06);
        }

        .wsus__monthly_top_banner_img {
            position: relative;
        }

        .wsus__monthly_top_banner_img img {
            border-radius: 22px;
            object-fit: cover;
            width: 100%;
            height: 100%;
            min-height: 280px;
        }

        .wsus__monthly_top_banner_text {
            position: absolute;
            top: 50%;
            left: 1.75rem;
            transform: translateY(-50%);
            z-index: 1;
            max-width: 420px;
            padding: 1.5rem;
        }

        .wsus__monthly_top_banner_text h4 {
            color: var(--color-secondary);
            font-size: 0.9rem;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }

        .wsus__monthly_top_banner_text h3 {
            color: #0f172a;
            font-size: 2.75rem;
            line-height: 1.05;
            margin-bottom: 0.75rem;
        }

        .wsus__monthly_top_banner_text h6 {
            color: #334155;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .wsus__monthly_top_banner_text .shop_btn {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.9rem 1.75rem;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            color: #fff;
            border: none;
            box-shadow: 0 16px 32px rgba(245, 158, 11, 0.2);
        }

        @media (max-width: 991px) {
            .wsus__section_header {
                justify-content: center;
                text-align: center;
            }

            .wsus__monthly_top_banner_text {
                left: 50%;
                transform: translate(-50%, -50%);
                padding: 1.5rem 1.25rem;
                max-width: 100%;
            }
        }

        @media (max-width: 767px) {
            .wsus__section_header {
                gap: 0.75rem;
            }

            .wsus__section_header h3 {
                font-size: 1.5rem !important;
            }

            .wsus__product_details {
                padding: 1rem !important;
            }

            .wsus__monthly_top_banner {
                min-height: 320px;
            }
        }

        /* ===== HEADER / NAV / FOOTER — bold refresh ===== */
        header {
            box-shadow: 0 4px 24px rgba(15, 23, 42, 0.06);
            position: relative;
            z-index: 20;
        }

        .wsus__call_area .wsus__call {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)) !important;
            color: #fff !important;
            box-shadow: 0 10px 24px rgba(245, 158, 11, 0.25);
        }

        .wsus__search input {
            border-radius: 999px !important;
            border: 2px solid #eef2f7 !important;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .wsus__search input:focus {
            border-color: var(--color-primary) !important;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.12);
        }

        .wsus__search button {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)) !important;
            border-radius: 999px !important;
        }

        .wsus__main_menu {
            background: var(--color-dark) !important;
        }

        .wsus_menu_category_bar {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)) !important;
        }

        .wsus_menu_cat_item > li > a {
            transition: color .2s ease;
        }

        .wsus_menu_cat_item > li > a:hover {
            color: var(--color-primary) !important;
        }

        .wsus_menu_cat_droapdown,
        .wsus__sub_category {
            border-radius: 12px !important;
            box-shadow: var(--shadow-soft) !important;
            overflow: hidden;
        }

        #wsus__breadcrumb {
            background: linear-gradient(135deg, var(--color-dark) 0%, #1e293b 100%) !important;
            position: relative;
        }

        .wsus_breadcrumb_overlay {
            background: rgba(15, 23, 42, 0.35);
            padding: 3rem 0;
        }

        #wsus__breadcrumb h4 {
            color: #fff !important;
            font-weight: 800 !important;
            text-transform: capitalize;
        }

        #wsus__breadcrumb ul li a {
            color: rgba(255, 255, 255, 0.75) !important;
        }

        footer.footer_2 {
            background: var(--color-dark) !important;
            padding-top: 4rem;
        }

        footer.footer_2 .wsus__footer_content h5,
        footer.footer_2 .wsus__footer_content_2 h3 {
            color: #fff !important;
            font-weight: 800 !important;
            margin-bottom: 1.25rem;
        }

        footer.footer_2 .wsus__footer_content p,
        footer.footer_2 .wsus__footer_menu a,
        footer.footer_2 .action {
            color: rgba(226, 232, 240, 0.75) !important;
            transition: color .2s ease;
        }

        footer.footer_2 .wsus__footer_menu a:hover,
        footer.footer_2 .action:hover {
            color: var(--color-primary) !important;
        }

        footer.footer_2 .wsus__footer_social a {
            border-radius: 10px !important;
            transition: transform .2s ease, background .2s ease;
        }

        footer.footer_2 .wsus__footer_social a:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)) !important;
        }

        .wsus__footer_bottom {
            background: #0b1120 !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .wsus__footer_bottom p {
            color: rgba(226, 232, 240, 0.6) !important;
        }

        .wsus__scroll_btn {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)) !important;
            box-shadow: 0 12px 28px rgba(245, 158, 11, 0.3) !important;
        }
    </style>
</head>

<body>
    <!-- ========== header Start ========== -->
    @include('frontend.body.header')
    <!-- header End -->

    <!-- ========== Lmain_menu Start ========== -->
    @include('frontend.body.main_menu')
    <!-- main_menu End -->

    <!-- ========== mobile_menu Start ========== -->
    @include('frontend.body.mobile_menu')
    <!-- mobile_menu End -->

    <livewire:notification />
    {{--    ! Popup same as product-details
    <!-- ========== PRODUCT MODAL VIEW Start ========== -->
    @include('frontend.body.product_popup_modal')
    <!-- PRODUCT MODAL VIEW End -->
    --}}


    <!-- ============================================================== -->
    <!-- Start main Content here -->
    <!-- ============================================================== -->
    @yield('content')
    <!-- end main content-->

    <!-- ========== Footer Start ========== -->
    @include('frontend.body.footer')
    <!-- Footer End -->

    <!--jquery library js-->
    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>
    <!--bootstrap js-->
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('frontend/js/Font-Awesome.js') }}"></script>
    <!--select2 js-->
    <script src="{{ asset('frontend/js/select2.min.js') }}"></script>
    <!--slick slider js-->
    <script src="{{ asset('frontend/js/slick.min.js') }}"></script>
    <!--simplyCountdown js-->
    <script src="{{ asset('frontend/js/simplyCountdown.js') }}"></script>
    <!--product zoomer js-->
    <script src="{{ asset('frontend/js/jquery.exzoom.js') }}"></script>
    <!--nice-number js-->
    <script src="{{ asset('frontend/js/jquery.nice-number.min.js') }}"></script>
    <!--counter js-->
    <script src="{{ asset('frontend/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countup.min.js') }}"></script>
    <!--add row js-->
    <script src="{{ asset('frontend/js/add_row_custon.js') }}"></script>
    <!--multiple-image-video js-->
    <script src="{{ asset('frontend/js/multiple-image-video.js') }}"></script>
    <!--sticky sidebar js-->
    <script src="{{ asset('frontend/js/sticky_sidebar.js') }}"></script>
    <!--price ranger js-->
    <script src="{{ asset('frontend/js/ranger_jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frontend/js/ranger_slider.js') }}"></script>
    <!--isotope js-->
    <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
    <!--venobox js-->
    <script src="{{ asset('frontend/js/venobox.min.js') }}"></script>
    <!--classycountdown js-->
    <script src="{{ asset('frontend/js/jquery.classycountdown.js') }}"></script>

    <!--main/custom js-->
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <script type="text/javascript" src="{{ asset('frontend/js/toastr.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}")
            @endforeach
        @endif

        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-left",
                    }
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-left",
                    }
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-left",
                    }
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-left",
                    }
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>
</body>

</html>
