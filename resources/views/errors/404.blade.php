<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="404 - Page Not Found | {{ config('app.name') }}">
    <meta name="author" content="{{ config('app.name') }}">

    <title>404 - Page Not Found | {{ config('app.name') }}</title>

    <link rel="icon" type="image/png" href="{{ file_exists(public_path('frontend/images/favicon.png')) ? asset('frontend/images/favicon.png') : asset('frontend/images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">

    <style>
        :root {
            --err-primary: #4f46e5;
            --err-primary-dark: #3730a3;
            --err-accent: #f43f5e;
            --err-accent-dark: #e11d48;
            --err-ink: #1e1b4b;
            --err-muted: #64748b;
            --err-bg: #f5f7fa;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html, body {
            height: 100%;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--err-bg);
            color: var(--err-ink);
            overflow-x: hidden;
        }

        .err-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background:
                radial-gradient(ellipse 600px 400px at 10% 10%, rgba(79, 70, 229, 0.08), transparent),
                radial-gradient(ellipse 600px 400px at 90% 90%, rgba(244, 63, 94, 0.08), transparent),
                var(--err-bg);
            position: relative;
        }

        /* Floating shapes */
        .err-shape {
            position: absolute;
            border-radius: 50%;
            opacity: .35;
            filter: blur(2px);
            z-index: 0;
        }

        .err-shape.shape-1 {
            width: 220px; height: 220px;
            background: linear-gradient(135deg, var(--err-primary) 0%, #7c3aed 100%);
            top: -60px; left: -60px;
            animation: floatA 7s ease-in-out infinite;
        }

        .err-shape.shape-2 {
            width: 160px; height: 160px;
            background: linear-gradient(135deg, var(--err-accent) 0%, #f59e0b 100%);
            bottom: -40px; right: -40px;
            animation: floatB 8s ease-in-out infinite;
        }

        .err-shape.shape-3 {
            width: 90px; height: 90px;
            background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
            top: 30%; right: 8%;
            animation: floatA 9s ease-in-out infinite reverse;
        }

        @keyframes floatA {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, -30px); }
        }
        @keyframes floatB {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-30px, 30px); }
        }

        /* Header */
        .err-header {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 32px;
        }

        .err-logo img {
            height: 40px;
            object-fit: contain;
        }

        .err-logo-text {
            font-family: 'Poppins', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--err-primary) 0%, #7c3aed 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -.02em;
        }

        .err-help {
            color: var(--err-muted);
            font-size: 14px;
            font-weight: 500;
        }

        .err-help a {
            color: var(--err-primary);
            text-decoration: none;
            font-weight: 600;
        }

        .err-help a:hover { color: var(--err-accent); }

        /* Main content */
        .err-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            position: relative;
            z-index: 1;
        }

        .err-card {
            text-align: center;
            max-width: 720px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            padding: 56px 48px;
            box-shadow:
                0 30px 60px -20px rgba(30, 27, 75, 0.15),
                0 18px 36px -18px rgba(79, 70, 229, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.7);
            position: relative;
            overflow: hidden;
            animation: cardIn .8s cubic-bezier(.2, .8, .2, 1);
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .err-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 0% 0%, rgba(244, 63, 94, 0.06), transparent 40%),
                radial-gradient(circle at 100% 100%, rgba(79, 70, 229, 0.08), transparent 40%);
            pointer-events: none;
        }

        .err-illustration {
            position: relative;
            margin-bottom: 12px;
            z-index: 1;
        }

        .err-404 {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(120px, 22vw, 200px);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, var(--err-primary) 0%, #7c3aed 50%, var(--err-accent) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -.05em;
            display: inline-block;
            position: relative;
            animation: shake 3s ease-in-out infinite;
        }

        @keyframes shake {
            0%, 100% { transform: rotate(0); }
            25% { transform: rotate(-1deg); }
            75% { transform: rotate(1deg); }
        }

        .err-emoji {
            font-size: 60px;
            display: inline-block;
            margin-left: -10px;
            vertical-align: super;
            animation: bounceEmoji 2s ease-in-out infinite;
        }

        @keyframes bounceEmoji {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-12px) rotate(-8deg); }
        }

        .err-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(244, 63, 94, 0.1);
            color: var(--err-accent-dark);
            border: 1px solid rgba(244, 63, 94, 0.2);
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 18px;
            position: relative;
            z-index: 1;
        }

        .err-badge-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--err-accent);
            animation: pulse 1.6s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.4); opacity: .5; }
        }

        .err-title {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(26px, 4vw, 34px);
            font-weight: 800;
            color: var(--err-ink);
            margin-bottom: 14px;
            letter-spacing: -.02em;
            position: relative;
            z-index: 1;
        }

        .err-message {
            color: var(--err-muted);
            font-size: 16px;
            line-height: 1.7;
            max-width: 480px;
            margin: 0 auto 32px;
            position: relative;
            z-index: 1;
        }

        .err-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .err-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 28px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14.5px;
            text-decoration: none;
            transition: all .25s ease;
            cursor: pointer;
            border: none;
        }

        .err-btn-primary {
            background: linear-gradient(135deg, var(--err-primary) 0%, #7c3aed 100%);
            color: #fff;
            box-shadow: 0 12px 28px rgba(79, 70, 229, 0.3);
        }

        .err-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 36px rgba(79, 70, 229, 0.4);
            color: #fff;
        }

        .err-btn-secondary {
            background: #fff;
            color: var(--err-ink);
            border: 1.5px solid #e2e8f0;
        }

        .err-btn-secondary:hover {
            border-color: var(--err-primary);
            color: var(--err-primary);
            transform: translateY(-2px);
        }

        .err-divider {
            margin: 36px auto 24px;
            max-width: 320px;
            text-align: center;
            color: var(--err-muted);
            font-size: 12.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .12em;
            position: relative;
            z-index: 1;
        }

        .err-divider::before,
        .err-divider::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 100px;
            height: 1px;
            background: linear-gradient(to right, transparent, #cbd5e1, transparent);
        }
        .err-divider::before { right: calc(50% + 50px); }
        .err-divider::after  { left: calc(50% + 50px); }

        .err-suggestions {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .err-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            color: var(--err-muted);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s ease;
        }

        .err-chip:hover {
            background: #eef2ff;
            border-color: #c7d2fe;
            color: var(--err-primary);
            transform: translateY(-2px);
        }

        .err-footer {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 20px;
            color: var(--err-muted);
            font-size: 13px;
        }

        .err-footer a {
            color: var(--err-primary);
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 640px) {
            .err-header { padding: 18px 20px; }
            .err-card { padding: 40px 24px; }
            .err-emoji { font-size: 44px; }
            .err-actions { flex-direction: column; }
            .err-btn { width: 100%; justify-content: center; }
            .err-divider::before, .err-divider::after { width: 50px; }
            .err-divider::before { right: calc(50% + 30px); }
            .err-divider::after  { left: calc(50% + 30px); }
        }
    </style>
</head>

<body>
    <div class="err-wrapper">
        <span class="err-shape shape-1"></span>
        <span class="err-shape shape-2"></span>
        <span class="err-shape shape-3"></span>

        <header class="err-header">
            <a href="{{ url('/') }}" class="err-logo">
                @if (file_exists(public_path('frontend/images/tiarshop-logo.png')))
                    <img src="{{ asset('frontend/images/tiarshop-logo.png') }}" alt="{{ config('app.name') }}">
                @elseif (file_exists(public_path('logo.png')))
                    <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}">
                @else
                    <span class="err-logo-text">{{ config('app.name', 'TiarShop') }}</span>
                @endif
            </a>
            <div class="err-help">
                Need help? <a href="{{ url('/contact') }}">Contact us</a>
            </div>
        </header>

        <main class="err-main">
            <div class="err-card">
                <div class="err-illustration">
                    <div class="err-404">404<span class="err-emoji">🔍</span></div>
                </div>

                <span class="err-badge">
                    <span class="err-badge-dot"></span>
                    Page Not Found
                </span>

                <h1 class="err-title">Oops! This page took a wrong turn.</h1>
                <p class="err-message">
                    The page you're looking for doesn't exist, has been moved, or is temporarily unavailable.
                    Don't worry — let's get you back on track.
                </p>

                <div class="err-actions">
                    <a href="{{ url('/') }}" class="err-btn err-btn-primary">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                    <a href="javascript:history.back()" class="err-btn err-btn-secondary">
                        <i class="fas fa-arrow-left"></i> Go Back
                    </a>
                </div>

                <div class="err-divider">Or try one of these</div>

                <div class="err-suggestions">
                    <a href="{{ url('/shop') }}" class="err-chip">
                        <i class="fas fa-store"></i> Browse Shop
                    </a>
                    <a href="{{ url('/cart') }}" class="err-chip">
                        <i class="fas fa-shopping-cart"></i> View Cart
                    </a>
                    <a href="{{ url('/wishlist') }}" class="err-chip">
                        <i class="fas fa-heart"></i> Wishlist
                    </a>
                    <a href="{{ url('/contact') }}" class="err-chip">
                        <i class="fas fa-envelope"></i> Support
                    </a>
                </div>
            </div>
        </main>

        <footer class="err-footer">
            &copy; {{ date('Y') }} {{ config('app.name', 'TiarShop') }}. All rights reserved.
        </footer>
    </div>
</body>

</html>
