<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rostom | Welcome</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            body {
                margin: 0;
                min-height: 100vh;
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                color: #0f172a;
                background: radial-gradient(circle at top left, rgba(245,158,11,0.18), transparent 28%),
                            radial-gradient(circle at bottom right, rgba(239,68,68,0.14), transparent 24%),
                            #f8fafc;
            }
            * {
                box-sizing: border-box;
            }
            a {
                color: inherit;
                text-decoration: none;
            }
            .page-shell {
                width: 100%;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1.5rem;
            }
            .hero-card {
                width: 100%;
                max-width: 1180px;
                display: grid;
                grid-template-columns: 1.45fr 1fr;
                gap: 1.75rem;
                padding: 2rem;
                border-radius: 32px;
                background: rgba(255,255,255,0.92);
                box-shadow: 0 32px 80px rgba(15,23,42,0.12);
                backdrop-filter: blur(18px);
            }
            .hero-panel {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .top-nav {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
            }
            .brand-logo {
                font-size: 1.35rem;
                font-weight: 800;
                letter-spacing: -0.03em;
            }
            .nav-links {
                display: flex;
                gap: 0.75rem;
                flex-wrap: wrap;
            }
            .nav-links a {
                padding: 0.75rem 1.25rem;
                border-radius: 999px;
                font-size: 0.92rem;
                font-weight: 700;
                transition: transform 0.2s ease, background-color 0.2s ease, color 0.2s ease;
            }
            .login-btn {
                background: #0f172a;
                color: white;
            }
            .register-btn {
                border: 1px solid rgba(15,23,42,0.15);
                background: white;
                color: #0f172a;
            }
            .login-btn:hover,
            .register-btn:hover {
                transform: translateY(-2px);
            }
            .hero-copy h1 {
                margin: 1.5rem 0 1rem;
                font-size: clamp(2.8rem, 5vw, 4.6rem);
                line-height: 1.02;
                letter-spacing: -0.045em;
                max-width: 14ch;
            }
            .hero-copy p {
                margin: 0;
                max-width: 46rem;
                font-size: 1.05rem;
                line-height: 1.9;
                color: #475569;
            }
            .hero-actions {
                margin-top: 2rem;
                display: flex;
                flex-wrap: wrap;
                gap: 1rem;
            }
            .hero-actions a {
                padding: 0.95rem 1.8rem;
                border-radius: 999px;
                font-weight: 700;
                letter-spacing: 0.02em;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .hero-actions .primary {
                background: linear-gradient(135deg, #f59e0b, #ef4444);
                color: #fff;
                box-shadow: 0 18px 40px rgba(245,158,11,0.25);
            }
            .hero-actions .secondary {
                background: #ffffff;
                color: #0f172a;
                border: 1px solid rgba(15,23,42,0.12);
            }
            .hero-actions a:hover {
                transform: translateY(-2px);
            }
            .highlight-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1rem;
                margin-top: 2.5rem;
            }
            .highlight-card {
                padding: 1.4rem;
                border-radius: 28px;
                background: #f8fafc;
                border: 1px solid rgba(15,23,42,0.05);
                box-shadow: 0 8px 24px rgba(15,23,42,0.06);
            }
            .highlight-card strong {
                display: block;
                margin-bottom: 0.85rem;
                font-size: 1rem;
                color: #0f172a;
            }
            .highlight-card span {
                font-size: 0.95rem;
                line-height: 1.8;
                color: #475569;
            }
            .visual-panel {
                position: relative;
                display: grid;
                gap: 1rem;
                align-content: stretch;
            }
            .visual-panel .callout {
                padding: 1.4rem;
                border-radius: 28px;
                background: linear-gradient(180deg, rgba(245,158,11,0.16), rgba(239,68,68,0.1));
                border: 1px solid rgba(245,158,11,0.18);
                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.35);
            }
            .callout h2 {
                margin: 0 0 0.75rem;
                font-size: 1.45rem;
                line-height: 1.15;
                color: #0f172a;
            }
            .callout p {
                margin: 0;
                color: #475569;
                line-height: 1.8;
            }
            .stats-panel {
                display: grid;
                gap: 1rem;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .stat-card {
                padding: 1.25rem;
                border-radius: 22px;
                background: white;
                border: 1px solid rgba(15,23,42,0.06);
                box-shadow: 0 20px 40px rgba(15,23,42,0.05);
            }
            .stat-card strong {
                display: block;
                font-size: 1.4rem;
                margin-bottom: 0.35rem;
                color: #0f172a;
            }
            .stat-card small {
                color: #64748b;
                font-size: 0.92rem;
                line-height: 1.7;
            }
            .accent-box {
                position: absolute;
                right: -4%;
                top: 0;
                width: 72px;
                height: 72px;
                background: rgba(245,158,11,0.16);
                border-radius: 24px;
                transform: translateY(-15%);
                z-index: 0;
            }
            @media (max-width: 950px) {
                .hero-card {
                    grid-template-columns: 1fr;
                }
                .visual-panel {
                    order: -1;
                }
            }
            @media (max-width: 680px) {
                .page-shell {
                    padding: 1.5rem;
                }
                .hero-card {
                    padding: 1.5rem;
                    gap: 1.25rem;
                }
                .top-nav {
                    flex-direction: column;
                    align-items: flex-start;
                }
                .nav-links {
                    width: 100%;
                    justify-content: flex-start;
                }
                .hero-actions {
                    flex-direction: column;
                }
                .highlight-grid,
                .stats-panel {
                    grid-template-columns: 1fr;
                }
                .brand-logo,
                .hero-copy h1 {
                    text-align: left;
                }
            }
        </style>
    @endif
</head>
<body>
    <div class="page-shell">
        <article class="hero-card">
            <div class="hero-panel">
                <div class="top-nav">
                    <div class="brand-logo">Rostom</div>
                    <div class="nav-links">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="login-btn">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="login-btn">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="register-btn">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
                <div class="hero-copy">
                    <p class="text-sm uppercase tracking-[0.25em] text-amber-700">Modern marketplace</p>
                    <h1>Welcome to a more professional, responsive store experience.</h1>
                    <p>Designed to look elegant on every device, with clearer product presentation, smoother layout flow, and a warm modern visual tone that is easy on the eyes.</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="primary">Start shopping</a>
                    <a href="{{ route('register') }}" class="secondary">Join the community</a>
                </div>
                <div class="highlight-grid">
                    <div class="highlight-card">
                        <strong>Refined product cards</strong>
                        <span>Smooth hover motion, balanced spacing, and clearer pricing hierarchy.</span>
                    </div>
                    <div class="highlight-card">
                        <strong>Responsive by default</strong>
                        <span>Looks polished on desktop, tablet, and mobile screens.</span>
                    </div>
                    <div class="highlight-card">
                        <strong>Modern visual tone</strong>
                        <span>A calming palette, premium shadows, and crisp typography.</span>
                    </div>
                    <div class="highlight-card">
                        <strong>Fast access</strong>
                        <span>Clean actions and navigation so users can engage instantly.</span>
                    </div>
                </div>
            </div>
            <div class="visual-panel">
                <div class="accent-box"></div>
                <div class="callout">
                    <h2>Built for buyers and vendors.</h2>
                    <p>Welcome visuals, polished CTA buttons, and a layout designed to highlight products without clutter.</p>
                </div>
                <div class="stats-panel">
                    <div class="stat-card">
                        <strong>80% faster</strong>
                        <small>Improved UX with cleaner information flow and less visual noise.</small>
                    </div>
                    <div class="stat-card">
                        <strong>3x more engaging</strong>
                        <small>Readable text, spacious components, and approachable section cards.</small>
                    </div>
                </div>
            </div>
        </article>
    </div>
</body>
</html>
