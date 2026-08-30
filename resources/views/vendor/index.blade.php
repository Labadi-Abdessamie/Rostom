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
            align-items: flex-start;
            justify-content: space-between;
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
        }
        .vd-stat-card .stat-icon {
            width: 54px; height: 54px;
            border-radius: 14px;
            background: rgba(255,255,255,.18);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .vd-stat-card .stat-info { text-align: right; position: relative; z-index: 1; }
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

        var donutCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: statusColors,
                    borderWidth: 0,
                    hoverOffset: 8,
                }]
            },
            options: {
                cutout: '72%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        bodyColor: '#fff',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function (ctx) {
                                return ' ' + ctx.label + ': ' + ctx.parsed + ' orders';
                            }
                        }
                    }
                }
            }
        });

        // Custom legend for donut
        var legendEl = document.getElementById('status-legend');
        statusLabels.forEach(function (label, i) {
            var item = document.createElement('span');
            item.style.cssText = 'display:flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;background:#f8fafc;border:1px solid #e2e8f0;';
            item.innerHTML = '<span style="width:10px;height:10px;border-radius:50%;background:' + statusColors[i] + ';display:inline-block;"></span>'
                           + '<span style="text-transform:capitalize;font-weight:600;">' + label + '</span>'
                           + '<span style="color:#1e293b;font-weight:800;">' + statusData[i] + '</span>';
            legendEl.appendChild(item);
        });
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
        <div class="row g-3 mb-4">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="vd-stat-card bg-grad-products">
                    <div class="stat-icon"><i class="fas fa-archive"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Total Products</div>
                        <div class="stat-value">{{ $totalProducts }}</div>
                        <div class="stat-change"><i class="fas fa-box-open me-1"></i>All listings</div>
                    </div>
                    <i class="fas fa-archive card-bg-icon"></i>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="vd-stat-card bg-grad-balance">
                    <div class="stat-icon"><i class="fas fa-wallet"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Balance</div>
                        <div class="stat-value" style="font-size:1.6rem;">{{ number_format($totalEarnings) }}</div>
                        <div class="stat-change">DZD earned</div>
                    </div>
                    <i class="fas fa-coins card-bg-icon"></i>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <a href="{{ route('vendor.pending_payments') }}" class="text-decoration-none">
                    <div class="vd-stat-card bg-grad-amber">
                        <div class="stat-icon"><i class="fas fa-clock"></i></div>
                        <div class="stat-info">
                            <div class="stat-label">Pending</div>
                            <div class="stat-value" style="font-size:1.6rem;">{{ number_format($pendingBalance) }}</div>
                            <div class="stat-change">DZD unconfirmed</div>
                        </div>
                        <i class="fas fa-clock card-bg-icon"></i>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="vd-stat-card bg-grad-sales">
                    <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Completed Sales</div>
                        <div class="stat-value">{{ $totalCompletedOrders }}</div>
                        <div class="stat-change"><i class="fas fa-check-circle me-1"></i>Orders fulfilled</div>
                    </div>
                    <i class="fas fa-shopping-bag card-bg-icon"></i>
                </div>
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
                <div class="vd-chart-card d-flex flex-column" style="gap:18px;">
                    <div class="vd-card-title mb-0">Order Status</div>
                    <div style="max-width:220px;margin:0 auto;width:100%;">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="d-flex flex-wrap justify-content-center gap-2" id="status-legend"
                         style="font-size:.78rem;color:#64748b;margin-top:4px;"></div>
                </div>
            </div>
        </div>

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
