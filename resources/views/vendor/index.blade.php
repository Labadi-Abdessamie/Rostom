@extends('vendor.master')

@section('title', 'Vendor Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">
    <style>
        /* ===== VENDOR DASHBOARD ENHANCEMENTS ===== */
        .section { padding: 28px 28px 0; }

        /* Stat cards */
        .vd-stat-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }
        @media (max-width: 1024px) {
            .vd-stat-row { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 576px) {
            .vd-stat-row { grid-template-columns: 1fr; }
        }
        .vd-stat-card {
            border-radius: 18px;
            padding: 28px 28px 24px;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 30px rgba(0,0,0,.18);
            transition: transform .25s, box-shadow .25s;
            min-height: 140px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }
        .vd-stat-card:hover { transform: translateY(-4px); box-shadow: 0 14px 40px rgba(0,0,0,.25); }
        .vd-stat-card::after {
            content: '';
            position: absolute;
            right: -30px; top: -30px;
            width: 130px; height: 130px;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
        }
        .vd-stat-card .card-bg-icon {
            position: absolute;
            right: 20px; bottom: 14px;
            font-size: 5rem;
            opacity: .1;
            line-height: 1;
            pointer-events: none;
        }
        .vd-stat-card .stat-icon {
            width: 54px; height: 54px;
            border-radius: 14px;
            background: rgba(255,255,255,.18);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .vd-stat-card .stat-info {
            flex: 1 1 auto;
            min-width: 0;
            text-align: right;
            position: relative;
            z-index: 1;
        }
        .vd-stat-card .stat-label {
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            opacity: .8;
            margin-bottom: 6px;
        }
        .vd-stat-card .stat-value {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            word-break: break-word;
        }
        .vd-stat-card .stat-change {
            font-size: .78rem;
            opacity: .75;
            margin-top: 4px;
        }
        .bg-grad-products { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .bg-grad-balance  { background: linear-gradient(135deg, #0ea5e9, #06b6d4); }
        .bg-grad-amber    { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .bg-grad-sales    { background: linear-gradient(135deg, #10b981, #059669); }

        /* Chart card */
        .vd-chart-card {
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            padding: 24px;
            height: 100%;
        }
        .vd-chart-card .vd-card-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .vd-chart-card .vd-card-title::before {
            content: '';
            display: inline-block;
            width: 4px; height: 20px;
            border-radius: 99px;
            background: linear-gradient(180deg, #6366f1, #8b5cf6);
        }

        /* Top product list */
        .vd-product-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .vd-product-item:last-child { border-bottom: none; }
        .vd-product-item img {
            width: 52px; height: 52px;
            object-fit: cover;
            border-radius: 10px;
            flex-shrink: 0;
            border: 2px solid #f1f5f9;
        }
        .vd-product-item .vd-prod-name {
            font-weight: 600;
            font-size: .88rem;
            color: #1e293b;
            line-height: 1.3;
        }
        .vd-product-item .vd-prod-stars i { font-size: .72rem; color: #f59e0b; }
        .vd-product-item .vd-prod-count { font-size: .75rem; color: #94a3b8; }
        .vd-product-item .ms-auto a {
            font-size: .78rem;
            padding: 5px 14px;
            border-radius: 50px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            transition: opacity .2s;
        }
        .vd-product-item .ms-auto a:hover { opacity: .85; }

        /* Sidebar improvements */
        .main-sidebar { background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%) !important; }
        .sidebar-menu a { transition: background .2s, padding-left .2s; }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(99,102,241,.15) !important;
            border-left: 3px solid #6366f1;
        }
        .sidebar-brand a { color: #f59e0b !important; font-weight: 800 !important; }
        .menu-header { color: rgba(255,255,255,.35) !important; font-size: .68rem !important; letter-spacing: 2px; }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/modules/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/chart.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('vendor/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script>
    (function () {
        // ===== Monthly Revenue Bar Chart =====
        var labels  = @json($chartLabels);
        var revenue = @json($revenueByMonth);

        var barCtx = document.getElementById('revenueChart').getContext('2d');
        var barGrad = barCtx.createLinearGradient(0, 0, 0, 260);
        barGrad.addColorStop(0, 'rgba(99,102,241,.85)');
        barGrad.addColorStop(1, 'rgba(139,92,246,.4)');

        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    data: revenue,
                    backgroundColor: barGrad,
                    borderRadius: 8,
                    borderSkipped: false,
                    hoverBackgroundColor: '#6366f1',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#94a3b8',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: function (ctx) {
                                return ' ' + new Intl.NumberFormat('fr-DZ').format(ctx.parsed.y) + ' DZD';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8', font: { size: 11 } }
                    },
                    y: {
                        grid: { color: '#f1f5f9', drawBorder: false },
                        beginAtZero: true,
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 11 },
                            callback: function (val) {
                                if (val >= 1000000) return (val / 1000000).toFixed(1) + 'M DZD';
                                if (val >= 1000)    return (val / 1000).toFixed(0) + 'k DZD';
                                return val + ' DZD';
                            }
                        }
                    }
                }
            }
        });

        // ===== Order Status Donut =====
        var statusData   = @json(array_values($statusBreakdown));
        var statusLabels = @json(array_keys($statusBreakdown));
        var statusColors = ['#f59e0b', '#10b981', '#6366f1', '#ef4444'];

        var donutCanvas = document.getElementById('statusChart');
        donutCanvas.width = 240;
        donutCanvas.height = 240;
        var donutCtx = donutCanvas.getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: statusColors,
                    borderWidth: 4,
                    borderColor: '#fff',
                    hoverOffset: 14,
                }]
            },
            options: {
                cutout: '70%',
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: function (ctx) {
                                return ' ' + ctx.label + ': ' + ctx.parsed + ' orders';
                            }
                        }
                    }
                }
            }
        });

        // Show total in center
        var donutTotal = statusData.reduce(function (a, b) { return a + b; }, 0);
        var totalEl = document.getElementById('vd-donut-total');
        if (totalEl) totalEl.textContent = donutTotal;

        // Update total
        var donutTotal = statusData.reduce(function (a, b) { return a + b; }, 0);
        var totalEl = document.getElementById('vd-donut-total');
        if (totalEl) totalEl.textContent = donutTotal;

        // Set the most-recent status (highest count)
        var topIdx = 0;
        for (var i = 1; i < statusData.length; i++) {
            if (statusData[i] > statusData[topIdx]) topIdx = i;
        }
        var topNameEl = document.getElementById('vd-top-status-name');
        if (topNameEl && donutTotal > 0) {
            topNameEl.textContent = statusData[topIdx] + ' ' + statusLabels[topIdx];
        }
    })();
    </script>
@endsection

@section('content')
    <section class="section">

        {{-- ===== NEW ORDER NOTIFICATION ===== --}}
        @if($newOrderCount > 0)
            <a href="{{ route('vendor.orders') }}" class="text-decoration-none d-block mb-3">
                <div class="alert alert-info d-flex align-items-center gap-3 mb-0" style="border-radius:14px; border:none; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border-left:4px solid #f59e0b;">
                    <div style="width:48px;height:48px;border-radius:12px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:1.3rem;">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div>
                        <strong style="font-size:1.05rem;">{{ $newOrderCount }} New Order{{ $newOrderCount === 1 ? '' : 's' }}</strong>
                        <div style="font-size:.82rem;opacity:.9;">You have new pending orders waiting for processing.</div>
                    </div>
                    <span class="badge bg-white text-info ms-auto" style="font-size:.9rem;padding:8px 14px;font-weight:700;">{{ $newOrderCount }} new</span>
                </div>
            </a>
        @endif

        {{-- ===== STAT CARDS ===== --}}
        <div class="vd-stat-row mb-4">
            <div class="vd-stat-card bg-grad-products" onclick="window.location='{{ route('vendor.products') }}'" style="cursor:pointer;">
                <div class="stat-icon"><i class="fas fa-archive"></i></div>
                <div class="stat-info">
                    <div class="stat-label">Total Products</div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                    <div class="stat-change"><i class="fas fa-box-open me-1"></i>All listings</div>
                </div>
                <i class="fas fa-archive card-bg-icon"></i>
            </div>
            <div class="vd-stat-card bg-grad-balance" onclick="window.location='{{ route('vendor.dashboard') }}'" style="cursor:pointer;">
                <div class="stat-icon"><i class="fas fa-wallet"></i></div>
                <div class="stat-info">
                    <div class="stat-label">Balance</div>
                    <div class="stat-value" style="font-size:1.6rem;">{{ number_format($totalEarnings) }}</div>
                    <div class="stat-change">DZD earned</div>
                </div>
                <i class="fas fa-coins card-bg-icon"></i>
            </div>
            <div class="vd-stat-card bg-grad-amber" onclick="window.location='{{ route('vendor.pending_payments') }}'">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-info">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value" style="font-size:1.6rem;">{{ $pendingBalance !== null ? number_format($pendingBalance) : '0' }}</div>
                    <div class="stat-change">DZD unconfirmed</div>
                </div>
                <i class="fas fa-clock card-bg-icon"></i>
            </div>
            <div class="vd-stat-card bg-grad-sales" onclick="window.location='{{ route('vendor.orders') }}'" style="cursor:pointer;">
                <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
                <div class="stat-info">
                    <div class="stat-label">Completed Sales</div>
                    <div class="stat-value">{{ $totalCompletedOrders }}</div>
                    <div class="stat-change"><i class="fas fa-check-circle me-1"></i>Orders fulfilled</div>
                </div>
                <i class="fas fa-shopping-bag card-bg-icon"></i>
            </div>
        </div>

        {{-- ===== CHART + TOP PRODUCTS ===== --}}
        <div class="row g-3 mb-4">
            <div class="col-lg-8">
                <div class="vd-chart-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="vd-card-title mb-0">Monthly Revenue</div>
                        <span style="font-size:.78rem;color:#94a3b8;font-weight:600;">Last 6 months · DZD</span>
                    </div>
                    <canvas id="revenueChart" height="158"></canvas>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="vd-chart-card d-flex flex-column" style="gap:28px; align-items:center; text-align:center; padding-top:28px; padding-bottom:28px;">
                    <div style="align-self:flex-start; width:100%;">
                        <div class="vd-card-title mb-1">Order Status</div>
                        <div style="font-size:.78rem; color:#94a3b8; font-weight:600;">Real-time breakdown</div>
                    </div>
                    <div style="position:relative; width:240px; height:240px; margin:8px auto 4px;">
                        <canvas id="statusChart" style="width:240px !important; height:240px !important;"></canvas>
                    </div>
                    <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:14px 18px; font-size:.85rem; color:#64748b; margin-top:6px; padding:0 12px;">
                        <span><span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#f59e0b;margin-right:5px;"></span>pending</span>
                        <span><span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#10b981;margin-right:5px;"></span>delivered</span>
                        <span><span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#6366f1;margin-right:5px;"></span>processing</span>
                        <span><span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:#ef4444;margin-right:5px;"></span>cancelled</span>
                    </div>
                    <div style="margin-top:auto; padding-top:16px; border-top:1px solid #f1f5f9; width:100%; text-align:center;">
                        <div style="font-size:.75rem; color:#94a3b8;">Most recent</div>
                        <div style="font-weight:700; color:#1e293b; font-size:.88rem;">Delivered <span id="vd-top-status-name">3</span></div>
                    </div>
                </div>
            </div>
        </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="vd-chart-card" style="overflow-y:auto; max-height: 420px;">
                        <div class="vd-card-title">Top 5 Products</div>
                        @foreach ($topProducts as $product)
                            <div class="vd-product-item">
                                <img src="{{ asset('storage/products_images/' . $product->id . '/' . $product->principalImage) }}"
                                     alt="{{ $product->name }}">
                                <div>
                                    <div class="vd-prod-name">{{ Str::limit($product->name, 30) }}</div>
                                    <div class="vd-prod-stars">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i class="{{ $i < $product->rate_average ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <div class="vd-prod-count">{{ $product->rate_count }} reviews</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('frontend.product_details', ['id' => $product->id]) }}">View</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        {{-- ===== PENDING PAYMENTS LIST ===== --}}
        <div class="row g-3 mb-4" style="margin-top:22px;">
            <div class="col-12">
                <div class="card adm-section-card">
                    <div class="card-header">
                        <span><i class="mdi mdi-cash-clock-outline me-1 text-warning"></i>Pending Payment Confirmations</span>
                        <a href="{{ route('vendor.pending_payments') }}" class="btn btn-xs btn-outline-amber">View All &rarr;</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table adm-table mb-0">
                                <thead><tr><th>Order #</th><th>Customer</th><th>Amount (DZD)</th><th>Status</th><th>Payment</th><th>Action</th></tr></thead>
                                <tbody>
                                    @forelse($pendingPaymentOrders ?? [] as $order)
                                        <tr>
                                            <td class="text-muted">#{{ $order->id }}</td>
                                            <td style="font-weight:600;">{{ $order->user->name ?? 'N/A' }}</td>
                                            <td>{{ number_format($order->totalAmount) }}</td>
                                            <td><span class="status-badge sb-delivered">Delivered</span></td>
                                            <td><span class="status-badge sb-pending">Pending</span></td>
                                            <td>
                                                <a href="{{ route('vendor.pending_payments') }}" class="btn btn-xs btn-amber">Confirm</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="text-center text-muted py-3">No pending payments.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
