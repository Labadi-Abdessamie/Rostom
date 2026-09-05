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
    @stack('styles')
    <style>
        /* ===== CART SIDE PANEL ===== */
        .wsus__cart_panel_root {
            position: fixed;
            inset: 0;
            z-index: 99990;
            display: flex;
            pointer-events: none;
            opacity: 0;
            transition: opacity .25s ease;
        }
        .wsus__cart_panel_root.is-open {
            pointer-events: auto;
            opacity: 1;
        }
        .wsus__cart_panel_backdrop {
            flex: 1 1 auto;
            background: rgba(15,23,42,.6);
            backdrop-filter: blur(8px) saturate(140%);
            -webkit-backdrop-filter: blur(8px) saturate(140%);
        }
        .wsus__cart_panel {
            width: 420px;
            max-width: 95vw;
            height: 100vh;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            box-shadow: -20px 0 60px rgba(15,23,42,.25);
            transform: translateX(100%);
            transition: transform .4s cubic-bezier(.22,1,.36,1);
            overflow: hidden;
            border-left: 1px solid rgba(0,0,0,.06);
        }
        .wsus__cart_panel_root.is-open .wsus__cart_panel {
            transform: translateX(0);
        }
        /* ---- Header ---- */
        .wsus__cart_panel_header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.4rem;
            background: #fff;
            border-bottom: 2px solid #f1f5f9;
            flex-shrink: 0;
        }
        .wsus__cart_panel_title {
            display: flex;
            align-items: center;
            gap: .85rem;
        }
        .wsus__cart_panel_icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: linear-gradient(135deg,var(--color-primary),var(--color-secondary));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1rem;
            flex-shrink: 0;
            box-shadow: 0 6px 16px rgba(245,158,11,.3);
        }
        .wsus__cart_panel_title > div { display: flex; flex-direction: column; gap: .1rem; }
        .wsus__cart_panel_title h4 {
            margin: 0;
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a !important;
            line-height: 1.2;
        }
        .wsus__cart_panel_count {
            font-size: .75rem;
            color: var(--color-primary);
            font-weight: 700;
        }
        .wsus__cart_panel_close {
            background: #f1f5f9;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            color: #64748b;
            cursor: pointer;
            transition: background .2s, color .2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .wsus__cart_panel_close:hover {
            background: #fee2e2;
            color: #dc2626;
        }
        /* ---- Body ---- */
        .wsus__cart_panel_body {
            flex: 1 1 auto;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0 1.4rem;
            min-height: 0;
            -webkit-overflow-scrolling: touch;
        }
        /* First item: always visible at top, prevent flex collapse */
        .wsus__cart_panel_item:first-child {
            margin-top: 0;
            border-top: none;
        }
        .wsus__cart_panel_item:last-child {
            border-bottom: none;
        }
        .wsus__cart_panel_list { display: block; flex-shrink: 0; padding: 0; margin: 0; list-style: none; }
        .wsus__cart_panel_body::-webkit-scrollbar { width: 5px; }
        .wsus__cart_panel_body::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .wsus__cart_panel_item {
            display: grid;
            grid-template-columns: 72px 1fr auto;
            gap: .85rem;
            padding: .9rem 0;
            border-bottom: 1px solid #f1f5f9;
            align-items: start;
            flex-shrink: 0;
        }
        .wsus__cart_panel_list { flex-shrink: 0; }
        .wsus__cart_panel_img {
            width: 72px;
            height: 72px;
            border-radius: 12px;
            overflow: hidden;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            flex-shrink: 0;
        }
        .wsus__cart_panel_img img { width: 100%; height: 100%; object-fit: cover; }
        .wsus__cart_panel_info {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: .35rem;
        }
        .wsus__cart_panel_name {
            font-weight: 700;
            color: #0f172a;
            font-size: .88rem;
            text-decoration: none;
            display: block;
            line-height: 1.3;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .wsus__cart_panel_name:hover { color: var(--color-primary); }
        .wsus__cart_panel_price_unit { font-size: .78rem; color: #64748b; }
        .wsus__cart_panel_price_unit span { color: #94a3b8; }
        /* Qty controls */
        .wsus__cart_panel_qty {
            display: inline-flex;
            align-items: center;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            width: fit-content;
        }
        .wsus__qty_btn {
            width: 30px;
            height: 30px;
            border: none;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .7rem;
            transition: background .15s, color .15s;
            flex-shrink: 0;
        }
        .wsus__qty_btn:hover:not(:disabled) { background: #e2e8f0; color: #0f172a; }
        .wsus__qty_btn:disabled { opacity: .35; cursor: not-allowed; }
        .wsus__qty_value {
            min-width: 34px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: .85rem;
            color: #0f172a;
            border-left: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
        }
        /* Actions col (subtotal + remove) */
        .wsus__cart_panel_actions_col {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: .35rem;
            flex-shrink: 0;
        }
        .wsus__cart_panel_subtotal { font-weight: 800; color: #0f172a; font-size: .9rem; white-space: nowrap; }
        .wsus__cart_panel_remove {
            background: #fee2e2;
            border: none;
            color: #dc2626;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            transition: background .2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .wsus__cart_panel_remove:hover { background: #fecaca; }
        /* Empty state */
        .wsus__cart_panel_empty {
            text-align: center;
            padding: 3.5rem 1.5rem;
        }
        .wsus__cart_panel_empty_icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #f1f5f9;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }
        .wsus__cart_panel_empty_icon i { font-size: 2rem; color: #94a3b8; }
        .wsus__cart_panel_empty h5 { font-weight: 800; color: #0f172a; margin-bottom: .5rem; }
        .wsus__cart_panel_empty p { font-size: .85rem; color: #64748b; margin-bottom: 1.5rem; line-height: 1.5; }
        /* ---- Footer ---- */
        .wsus__cart_panel_footer {
            padding: 1.1rem 1.4rem 1.25rem;
            border-top: 2px solid #f1f5f9;
            background: #f8fafc;
            flex-shrink: 0;
        }
        .wsus__cart_panel_summary { margin-bottom: .75rem; }
        .wsus__cart_panel_row {
            display: flex;
            justify-content: space-between;
            font-size: .88rem;
            margin-bottom: .3rem;
        }
        .wsus__cart_panel_row strong { font-weight: 800; color: #0f172a; }
        .wsus__cart_panel_row span { color: #475569; }
        .wsus__cart_panel_row strong { color: #0f172a; }
        .wsus__cart_panel_row_muted { color: #94a3b8 !important; font-size: .78rem; }
        .wsus__cart_panel_row_muted span { color: #94a3b8; }
        .wsus__cart_panel_actions { display: flex; gap: .6rem; }
        .wsus__cart_panel_btn {
            flex: 1 1 auto;
            padding: .75rem .5rem;
            border-radius: 14px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            font-size: .85rem;
            transition: transform .15s, box-shadow .15s, opacity .15s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
        }
        .wsus__cart_panel_btn:hover { transform: translateY(-2px); opacity: .95; }
        .wsus__cart_panel_btn_ghost {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            color: #0f172a;
        }
        .wsus__cart_panel_btn_ghost:hover { border-color: #cbd5e1; }
        .wsus__cart_panel_btn_primary {
            background: linear-gradient(135deg,var(--color-primary),var(--color-secondary));
            color: #fff;
            border: none;
            box-shadow: 0 8px 20px rgba(245,158,11,.3);
        }
        .wsus__cart_panel_clear {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .35rem;
            margin-top: .75rem;
            background: none;
            border: none;
            color: #94a3b8;
            font-size: .78rem;
            font-weight: 600;
            cursor: pointer;
            padding: .3rem;
            width: 100%;
            transition: color .15s;
        }
        .wsus__cart_panel_clear:hover { color: #ef4444; }
        .wsus__cart_panel_secure {
            text-align: center;
            font-size: .72rem;
            color: #94a3b8;
            margin-top: .5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .3rem;
        }
        .wsus__cart_panel_secure i { color: #22c55e; }

        /* Floating cart FAB */
        .wsus__floating_cart_btn { position: fixed; right: 22px; bottom: 22px; z-index: 99980; width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg,var(--color-primary),var(--color-secondary)); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 1.25rem; box-shadow: 0 12px 32px rgba(245,158,11,.35); text-decoration: none; transition: transform .25s ease, box-shadow .25s ease; border: none; cursor: pointer; }
        .wsus__floating_cart_btn:hover { transform: translateY(-4px) scale(1.06); box-shadow: 0 18px 40px rgba(245,158,11,.45); }
        .wsus__floating_badge { position: absolute; top: -2px; right: -2px; min-width: 22px; height: 22px; border-radius: 999px; background: #dc2626; color: #fff; font-size: .7rem; font-weight: 800; display: flex; align-items: center; justify-content: center; padding: 0 5px; border: 2px solid #fff; }

        @media (max-width: 575px) {
            .wsus__cart_panel { width: 100vw; max-width: 100vw; }
            .wsus__floating_cart_btn { right: 14px; bottom: 14px; width: 52px; height: 52px; font-size: 1.05rem; }
            .wsus__cart_panel_header { padding: 1rem 1.1rem; }
            .wsus__cart_panel_body { padding: .5rem 1.1rem 0; overflow-x: hidden; }
            .wsus__cart_panel_list { flex-shrink: 0; }
            .wsus__cart_panel_footer { padding: 1rem 1.1rem; }
            .wsus__cart_panel_item {
                grid-template-columns: 60px 1fr auto;
                gap: .7rem;
                padding: .85rem 0;
            }
            .wsus__cart_panel_img { width: 60px; height: 60px; }
            .wsus__cart_panel_name { font-size: .85rem; -webkit-line-clamp: 2; }
            .wsus__cart_panel_subtotal { font-size: .85rem; }
            .wsus__cart_panel_btn { padding: .65rem .4rem; font-size: .8rem; }
        }
        @media (max-width: 380px) {
            .wsus__cart_panel_item {
                grid-template-columns: 56px 1fr auto;
                gap: .55rem;
            }
            .wsus__cart_panel_img { width: 56px; height: 56px; }
        }

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

        /* ===== HEADER / NAV / FOOTER ===== */
        /* Force header layout regardless of style.css */
        header.wsus__header,
        header {
            display: block !important;
            overflow: visible !important;
            height: auto !important;
            min-height: auto !important;
        }

        /* Override logo width: don't let style.css force 75% */
        .wsus__header .wsus__header_logo,
        .wsus__header_logo {
            width: auto !important;
        }

        .wsus__header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
            box-shadow: 0 4px 24px rgba(15, 23, 42, 0.25) !important;
            position: relative;
            z-index: 20;
            padding: 0.9rem 0;
            overflow: hidden;
        }

        .wsus__header_inner {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            width: 100%;
            flex-wrap: nowrap;
        }

        .wsus__header_search {
            flex: 1 1 auto;
            min-width: 220px;
            max-width: 520px;
            margin: 0 0.5rem;
        }

        .wsus__header .wsus__header_logo {
            flex: 0 0 auto;
            display: inline-block;
        }

        .wsus__header .wsus__header_logo img {
            max-height: 52px;
            max-width: 160px;
            width: auto;
            height: auto;
            object-fit: contain;
            filter: brightness(1.15);
        }

        .wsus__header_search {
            flex: 1 1 auto;
            display: flex;
            align-items: center;
            min-width: 0;
            margin: 0;
        }

        .wsus__header_search form,
        .wsus__search,
        .wsus__search form {
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            gap: 0 !important;
            position: relative !important;
            overflow: visible !important;
            line-height: normal !important;
        }

        .wsus__header_search input {
            flex: 1 1 auto;
            min-width: 0;
            border-radius: 999px 0 0 999px !important;
            border: 2px solid rgba(255, 255, 255, 0.2) !important;
            border-right: none !important;
            padding: 0.55rem 1.1rem;
            font-size: 0.9rem;
            line-height: normal !important;
            height: auto !important;
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.1) !important;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .wsus__header_search input::placeholder {
            color: rgba(255, 255, 255, 0.55) !important;
        }

        .wsus__header_search input:focus {
            border-color: var(--color-primary) !important;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.2) !important;
            outline: none;
            background: rgba(255, 255, 255, 0.15) !important;
        }

        .wsus__header_search .wsus__search_btn {
            flex: 0 0 auto;
            border-radius: 0 999px 999px 0 !important;
            border: 2px solid var(--color-primary) !important;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)) !important;
            color: #fff !important;
            padding: 0.55rem 0.95rem;
            cursor: pointer;
            transition: opacity .2s ease, transform .2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wsus__header_search .wsus__search_btn:hover {
            opacity: 0.85;
        }

        /* Force override of style.css conflicting .wsus__search rules */
        .wsus__search form,
        .wsus__search,
        .wsus__search input,
        .wsus__search button,
        .wsus__search form input,
        .wsus__search form button {
            position: relative !important;
            overflow: visible !important;
            line-height: normal !important;
            height: auto !important;
            border-radius: 0 !important;
            border: none !important;
            float: none !important;
            top: auto !important;
            transform: none !important;
            right: auto !important;
            left: auto !important;
            background: none !important;
        }

        .wsus__search_btn,
        .wsus__search form button[type="submit"] {
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .wsus__header_right {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-left: 0.75rem;
            white-space: nowrap;
        }

        .wsus__header_contact {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            color: inherit;
            flex: 0 0 auto;
        }

        .wsus__header_contact:hover {
            opacity: 0.9;
        }

        .wsus__header_contact_icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .wsus__header_contact_text {
            line-height: 1.15;
        }

        .wsus__header_contact small {
            display: block;
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .wsus__header_contact strong {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff;
        }

        @media (max-width: 991px) {
            .wsus__header_contact_text {
                display: none;
            }

            .wsus__header_inner {
                gap: 0.75rem;
            }
        }

        @media (max-width: 575px) {
            .wsus__header .wsus__header_logo img {
                max-height: 40px;
            }

            .wsus__header_right {
                gap: 0.5rem;
            }
        }

        /* ===== NAVBAR ===== */
        .wsus__main_menu {
            background: var(--color-dark) !important;
            width: 100%;
            height: auto;
            box-shadow: none;
            position: relative;
            z-index: 15;
        }

        .wsus__menu_item {
            height: auto;
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0;
        }

        .wsus__menu_item li {
            margin: 0;
            float: none;
            height: auto;
            display: flex;
            align-items: center;
        }

        .wsus__menu_item li a {
            position: relative;
            text-transform: capitalize;
            font-weight: 500;
            letter-spacing: 0.2px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            padding: 0.85rem 1rem;
            border-radius: 6px;
            transition: color .2s ease, background .2s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .wsus__menu_item li a i {
            font-size: 0.85rem;
        }

        .wsus__menu_item li a:hover,
        .wsus__menu_item li a.active {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.1);
        }

        .wsus__menu_item li a.active {
            color: var(--color-primary) !important;
            font-weight: 600;
        }

        .wsus__menu_auth_btn {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)) !important;
            color: #fff !important;
            border-radius: 999px !important;
            padding: 0.5rem 1.1rem !important;
            font-weight: 600 !important;
            font-size: 0.85rem !important;
        }

        .wsus__menu_auth_btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .wsus__menu_item_right {
            margin-left: auto;
        }

        /* ===== ICON AREA ===== */
        .wsus__icon_area {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .wsus__icon_area li {
            margin: 0;
        }

        .wsus__icon_btn {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff !important;
            text-decoration: none;
            font-size: 1.05rem;
            transition: background .2s ease, color .2s ease, transform .2s ease;
        }

        .wsus__icon_btn i {
            color: #ffffff !important;
            font-family: 'Font Awesome 5 Free' !important;
        }

        .wsus__icon_btn i.fas {
            font-weight: 900 !important;
        }

        .wsus__icon_btn i.far {
            font-weight: 400 !important;
        }

        .wsus__icon_btn:hover {
            background: rgba(255, 255, 255, 0.18);
            color: #fff !important;
            transform: translateY(-2px);
        }

        .wsus__icon_badge {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 18px;
            height: 18px;
            border-radius: 999px;
            background: var(--color-secondary) !important;
            color: #fff !important;
            font-size: 0.65rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            line-height: 1;
        }

        /* ===== BREADCRUMB ===== */
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

        /* ===== FOOTER ===== */
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
            display: none; /* hidden by default, shown by JS .active */
            animation: none !important;
        }
        .wsus__scroll_btn i {
            color: #fff;
            font-size: 16px;
        }

        /* ============================================
           MOBILE-ONLY HEADER (<= 575px)
           ============================================ */
        @media (max-width: 575px) {
            /* HEADER — compact dark navbar, single row */
            .wsus__header {
                padding: 10px 0 !important;
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
                box-shadow: 0 2px 12px rgba(0,0,0,0.3) !important;
            }
            .wsus__header > .container { padding: 0 12px !important; }

            .wsus__header_inner {
                display: grid !important;
                grid-template-columns: auto 1fr auto !important;
                grid-template-areas: "hamburger logo right" !important;
                align-items: center !important;
                gap: 10px !important;
                width: 100% !important;
            }

            /* Each child in the inner row must be inline-flex, no wrapping */
            .wsus__header_inner > * {
                flex-shrink: 0 !important;
            }

            /* Hamburger — TOP-LEFT corner, first child */
            .wsus__mobile_hamburger {
                grid-area: hamburger !important;
                flex-shrink: 0 !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 42px !important;
                height: 42px !important;
                border-radius: 8px !important;
                background: rgba(255,255,255,0.1) !important;
                border: 1px solid rgba(255,255,255,0.2) !important;
                color: #fff !important;
                font-size: 16px !important;
                cursor: pointer !important;
                transition: all .2s ease !important;
            }
            .wsus__mobile_hamburger:hover,
            .wsus__mobile_hamburger.active {
                background: rgba(255,255,255,0.2) !important;
            }

            /* Logo — CENTERED in the top row */
            .wsus__header_logo {
                grid-area: logo !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 100% !important;
                flex: 0 0 auto !important;
            }
            .wsus__header_logo img {
                max-height: 42px !important;
                max-width: 130px !important;
                width: auto !important;
                height: auto !important;
                object-fit: contain !important;
            }

            /* Right side — pushed to the right column */
            .wsus__header_right,
            .wsus__header_right_mobile {
                grid-area: right !important;
                flex: 0 0 auto !important;
                display: flex !important;
                align-items: center !important;
                justify-content: flex-end !important;
                gap: 5px !important;
                margin-left: 0 !important;
                flex-wrap: nowrap !important;
                min-width: 0 !important;
                overflow: visible !important;
                max-width: none !important;
            }

            /* Auth links — compact pill buttons outside hamburger */
            .wsus__mobile_auth_links {
                display: flex !important;
                align-items: center !important;
                gap: 3px !important;
                flex-shrink: 0 !important;
            }
            .wsus__mobile_auth_btn {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 7px 12px !important;
                border-radius: 999px !important;
                font-size: 13px !important;
                font-weight: 700 !important;
                text-decoration: none !important;
                white-space: nowrap !important;
                transition: all .2s ease !important;
                flex-shrink: 0 !important;
            }
            .wsus__mobile_auth_btn:not(.wsus__mobile_auth_btn_primary) {
                background: rgba(255,255,255,0.1) !important;
                color: rgba(255,255,255,0.85) !important;
                border: 1px solid rgba(255,255,255,0.2) !important;
            }
            .wsus__mobile_auth_btn:not(.wsus__mobile_auth_btn_primary):hover {
                background: rgba(255,255,255,0.18) !important;
                color: #fff !important;
            }
            .wsus__mobile_auth_btn_primary {
                background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)) !important;
                color: #fff !important;
                border: none !important;
            }
            .wsus__mobile_auth_btn_primary:hover {
                opacity: 0.85 !important;
            }

            /* Hide the original desktop search bar on mobile */
            .wsus__header_search:not(.wsus__header_search_mobile) {
                display: none !important;
            }

            /* Compact mobile search — own row below, full width */
            .wsus__header_search_mobile {
                grid-area: right !important;
                grid-row: 2 !important;
                grid-column: 1 / -1 !important;
                display: flex !important;
                align-items: stretch !important;
                max-width: 100% !important;
                min-width: 0 !important;
                margin: 8px 0 0 0 !important;
                min-height: 40px !important;
            }
            .wsus__header_search_mobile input {
                flex: 1 1 auto !important;
                height: 40px !important;
                font-size: 14px !important;
                padding: 4px 14px !important;
                border-radius: 999px 0 0 999px !important;
                min-width: 0 !important;
                width: auto !important;
            }
            .wsus__header_search_mobile .wsus__search_btn {
                flex: 0 0 48px !important;
                width: 48px !important;
                min-width: 48px !important;
                height: 40px !important;
                border-radius: 0 999px 999px 0 !important;
                padding: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                clip: auto !important;
                clip-path: none !important;
            }

            /* Hide contact on mobile */
            .wsus__header_contact { display: none !important; }

            /* MAIN MENU — hide entirely on mobile (navigation goes into hamburger menu) */
            .wsus__main_menu { display: none !important; }

            /* Icon area — shrink badges on mobile */
            .wsus__icon_area li { margin: 0 !important; }
            .wsus__icon_btn {
                width: 34px !important;
                height: 34px !important;
                font-size: 0.9rem !important;
            }
            .wsus__icon_badge {
                min-width: 16px !important;
                height: 16px !important;
                font-size: 0.6rem !important;
                top: -4px !important;
                right: -4px !important;
            }

            /* Mobile nav overlay */
            .wsus__mobile_nav_overlay {
                display: block !important;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                background: rgba(0,0,0,0.5) !important;
                z-index: 99998 !important;
                opacity: 0 !important;
                pointer-events: none !important;
                transition: opacity .3s ease !important;
            }
            .wsus__mobile_nav_overlay.active {
                opacity: 1 !important;
                pointer-events: all !important;
            }

            /* Mobile nav menu — slides in from LEFT to right */
            .wsus__mobile_nav_menu {
                display: flex !important;
                flex-direction: column !important;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 280px !important;
                height: 100vh !important;
                background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%) !important;
                z-index: 99999 !important;
                transform: translateX(-100%) !important;
                transition: transform .3s ease !important;
                overflow-y: auto !important;
                scrollbar-width: none !important;
                box-shadow: 4px 0 24px rgba(0,0,0,0.4) !important;
            }
            .wsus__mobile_nav_menu.active {
                transform: translateX(0) !important;
            }

            /* Mobile nav header */
            .wsus__mobile_nav_header {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 14px 16px !important;
                border-bottom: 1px solid rgba(255,255,255,0.1) !important;
                background: rgba(0,0,0,0.2) !important;
            }
            .wsus__mobile_nav_header .wsus__mobile_nav_title {
                font-size: 16px !important;
                font-weight: 700 !important;
                color: #fff !important;
                margin: 0 !important;
                letter-spacing: 0.5px !important;
            }
            .wsus__mobile_nav_close {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 32px !important;
                height: 32px !important;
                border-radius: 8px !important;
                background: rgba(255,255,255,0.1) !important;
                border: none !important;
                color: #fff !important;
                font-size: 14px !important;
                cursor: pointer !important;
                transition: background .2s ease !important;
            }
            .wsus__mobile_nav_close:hover {
                background: rgba(220,53,69,0.4) !important;
            }

            /* Mobile nav links */
            .wsus__mobile_nav_links {
                list-style: none !important;
                margin: 0 !important;
                padding: 8px 0 !important;
            }
            .wsus__mobile_nav_links li a {
                display: flex !important;
                align-items: center !important;
                gap: 12px !important;
                padding: 13px 18px !important;
                color: rgba(255,255,255,0.85) !important;
                font-size: 14px !important;
                font-weight: 500 !important;
                text-decoration: none !important;
                border-bottom: 1px solid rgba(255,255,255,0.06) !important;
                transition: all .2s ease !important;
            }
            .wsus__mobile_nav_links li a:hover,
            .wsus__mobile_nav_links li a.active {
                background: rgba(245,158,11,0.12) !important;
                color: var(--color-primary) !important;
            }
            .wsus__mobile_nav_links li a i {
                width: 20px !important;
                text-align: center !important;
                font-size: 15px !important;
                flex-shrink: 0 !important;
                color: rgba(255,255,255,0.5) !important;
            }
            .wsus__mobile_nav_links li a:hover i,
            .wsus__mobile_nav_links li a.active i {
                color: var(--color-primary) !important;
            }

            /* Mobile nav section label */
            .wsus__mobile_nav_section_label {
                padding: 10px 18px 4px !important;
                font-size: 11px !important;
                font-weight: 700 !important;
                color: rgba(255,255,255,0.35) !important;
                text-transform: uppercase !important;
                letter-spacing: 1px !important;
            }
        }

        /* Hide mobile-only elements on desktop */
        @media (min-width: 576px) {
            .wsus__mobile_hamburger { display: none !important; }
            .wsus__mobile_auth_links { display: none !important; }
            .wsus__header_search_mobile { display: none !important; }
            .wsus__mobile_nav_overlay { display: none !important; }
            .wsus__mobile_nav_menu { display: none !important; }
        }
        @media (min-width: 576px) and (max-width: 767px) {
            .wsus__header { padding: 12px 0 !important; }
            .wsus__header_inner { gap: 10px !important; }
            .wsus__header_search { max-width: 240px !important; }
            .wsus__header_logo img { max-height: 42px !important; max-width: 130px !important; }
            .wsus__header_contact_text { font-size: 12px !important; }
            .wsus__main_menu .row { gap: 10px !important; }
            .wsus__main_menu .col { flex: 1 1 100% !important; max-width: 100% !important; }
            .wsus__menu_item { flex-wrap: wrap !important; gap: 8px !important; }
            .wsus__menu_item > li > a {
                padding: 9px 13px !important;
                font-size: 13px !important;
                border-radius: 10px !important;
            }
            .wsus__menu_item_right { border-top: 1px solid rgba(0,0,0,.06) !important; padding-top: 8px !important; }
        }
        @media (min-width: 768px) and (max-width: 991px) {
            .wsus__header_logo img { max-height: 48px !important; max-width: 130px !important; }
            .wsus__header_search { max-width: 280px !important; }
            .wsus__menu_item > li > a { padding: 8px 12px !important; font-size: 13.5px !important; }
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

    <!-- ========== Mobile Hamburger Nav (hidden on desktop) ========== -->
    <div class="wsus__mobile_nav_overlay" id="mobileNavOverlay" onclick="toggleMobileNavMenu()"></div>
    <nav class="wsus__mobile_nav_menu" id="mobileNavMenu" aria-label="Mobile navigation">
        <div class="wsus__mobile_nav_header">
            <h2 class="wsus__mobile_nav_title">TiarShop Menu</h2>
            <button type="button" class="wsus__mobile_nav_close" onclick="toggleMobileNavMenu()" aria-label="Close menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="wsus__mobile_nav_links">
            <li><a href="{{ route('frontend.index') }}" class="{{ Route::currentRouteName() == 'frontend.index' ? 'active' : '' }}"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="{{ route('frontend.products') }}" class="{{ Route::currentRouteName() == 'frontend.products' ? 'active' : '' }}"><i class="fas fa-box-open"></i> Products</a></li>
            <li><a href="{{ route('frontend.vendor') }}" class="{{ Route::currentRouteName() == 'frontend.vendor' ? 'active' : '' }}"><i class="fas fa-store"></i> Vendors</a></li>
            <li><a href="{{ route('frontend.about') }}" class="{{ Route::currentRouteName() == 'frontend.about' ? 'active' : '' }}"><i class="fas fa-building"></i> About</a></li>
            <li><a href="{{ route('frontend.team') }}" class="{{ Route::currentRouteName() == 'frontend.team' ? 'active' : '' }}"><i class="fas fa-users"></i> Team</a></li>
            @auth
                @if(Auth::user()->role === 'client')
                    <li><a href="javascript:void(0)" onclick="openCartPanel()"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                @endif
            @else
                <li><a href="{{ route('frontend.cart') }}" class="{{ Route::currentRouteName() == 'frontend.cart' ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> Cart</a></li>
            @endauth
            <li><a href="{{ route('frontend.contact') }}" class="{{ Route::currentRouteName() == 'frontend.contact' ? 'active' : '' }}"><i class="fas fa-envelope"></i> Contact</a></li>
        </ul>
        <div class="wsus__mobile_nav_section_label">Account</div>
        <ul class="wsus__mobile_nav_links">
            @auth
                <li><a href="{{ route('dashboard') }}"><i class="fas fa-user-circle"></i>
                    @switch(Auth::user()->role)
                        @case('client') My Dashboard @break
                        @case('vendor') Magasin @break
                        @case('admin') Dashboard @break
                        @default Dashboard
                    @endswitch
                </a></li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            @else
                <li><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Register</a></li>
                @endif
            @endauth
        </ul>
        @auth
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @endauth
    </nav>
    <!-- Mobile Hamburger Nav End -->

    <livewire:notification />
    <livewire:cart-panel />

    {{-- Floating bottom-right cart button --}}
    <a href="javascript:void(0)" onclick="openCartPanel()" class="wsus__floating_cart_btn" id="floatingCartBtn" aria-label="Open cart">
        <i class="fas fa-shopping-cart"></i>
        <span class="wsus__floating_badge" id="floatingCartBadge">0</span>
    </a>
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
        // ===== CART SIDE PANEL =====
        function openCartPanel() {
            sessionStorage.setItem('cartPanelOpen', '1');
            const btn = document.getElementById('cartPanelOpenBtn');
            if (btn) btn.click();
            document.body.style.overflow = 'hidden';
        }
        function closeCartPanel() {
            sessionStorage.removeItem('cartPanelOpen');
            const btn = document.getElementById('cartPanelCloseBtn');
            if (btn) btn.click();
            document.body.style.overflow = '';
        }
        document.addEventListener('click', function (e) {
            if (e.target.closest('[data-cart-panel-close]')) { closeCartPanel(); }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { closeCartPanel(); }
        });
        // Restore open state on page load
        window.addEventListener('load', function () {
            if (sessionStorage.getItem('cartPanelOpen') === '1') {
                openCartPanel();
            }
        });
        // Keep floating badge synced with navbar badge
        setInterval(function () {
            const b = document.getElementById('cartIconBadge');
            const f = document.getElementById('floatingCartBadge');
            if (b && f) f.textContent = b.textContent || '0';
        }, 1000);
    </script>

    <script>
        // Mobile hamburger toggle
        function toggleMobileNavMenu() {
            var menu = document.getElementById('mobileNavMenu');
            var overlay = document.getElementById('mobileNavOverlay');
            var btn = document.getElementById('mobileHamburgerBtn');
            var icon = document.getElementById('hamburgerIcon');
            if (!menu || !overlay) return;
            var isActive = menu.classList.contains('active');
            if (isActive) {
                menu.classList.remove('active');
                overlay.classList.remove('active');
                if (btn) btn.classList.remove('active');
                if (icon) { icon.classList.remove('fa-times'); icon.classList.add('fa-bars'); }
                document.body.style.overflow = '';
            } else {
                menu.classList.add('active');
                overlay.classList.add('active');
                if (btn) btn.classList.add('active');
                if (icon) { icon.classList.remove('fa-bars'); icon.classList.add('fa-times'); }
                document.body.style.overflow = 'hidden';
            }
        }
        // Close mobile menu on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                var menu = document.getElementById('mobileNavMenu');
                if (menu && menu.classList.contains('active')) {
                    toggleMobileNavMenu();
                }
            }
        });
        // Close mobile menu on resize to desktop
        var resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth > 575) {
                    var menu = document.getElementById('mobileNavMenu');
                    var overlay = document.getElementById('mobileNavOverlay');
                    var btn = document.getElementById('mobileHamburgerBtn');
                    if (menu) menu.classList.remove('active');
                    if (overlay) overlay.classList.remove('active');
                    if (btn) btn.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }, 150);
        });
    </script>

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
