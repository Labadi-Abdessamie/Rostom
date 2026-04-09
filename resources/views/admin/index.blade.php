@extends('admin.master')

@section('title', 'Admin || Dashboard')

@section('styles')
<style>
.adm-stat-card {
    border-radius: 16px;
    border: none;
    padding: 22px 20px;
    display: flex;
    align-items: center;
    gap: 18px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
}
.adm-stat-card .stat-icon-wrap {
    width: 56px; height: 56px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; flex-shrink: 0;
}
.adm-stat-card .stat-label { font-size: .78rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; opacity: .7; }
.adm-stat-card .stat-value { font-size: 1.75rem; font-weight: 800; line-height: 1.1; margin: 2px 0; }
.adm-stat-card .stat-sub   { font-size: .78rem; opacity: .6; }
.adm-stat-card .card-bg-ico { position: absolute; right: -10px; bottom: -10px; font-size: 5rem; opacity: .07; }

.bg-grad-blue   { background: linear-gradient(135deg,#4f46e5,#6d28d9); color:#fff; }
.bg-grad-teal   { background: linear-gradient(135deg,#0891b2,#0e7490); color:#fff; }
.bg-grad-green  { background: linear-gradient(135deg,#059669,#047857); color:#fff; }
.bg-grad-amber  { background: linear-gradient(135deg,#d97706,#b45309); color:#fff; }
.bg-grad-rose   { background: linear-gradient(135deg,#e11d48,#be123c); color:#fff; }
.bg-grad-slate  { background: linear-gradient(135deg,#475569,#334155); color:#fff; }

.adm-section-card { border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,.06); }
.adm-section-card .card-header {
    background: transparent; border-bottom: 1px solid #f1f5f9;
    padding: 16px 20px; font-weight: 700; font-size: .95rem;
    display: flex; align-items: center; justify-content: space-between;
}
.adm-table thead th { background: #f8fafc; font-size: .78rem; text-transform: uppercase; letter-spacing: .05em; color: #64748b; border: none; padding: 10px 14px; }
.adm-table tbody tr:hover { background: #f8fafc; }
.adm-table td { vertical-align: middle; padding: 10px 14px; border-color: #f1f5f9; }

.status-badge { padding: 4px 10px; border-radius: 20px; font-size: .75rem; font-weight: 600; }
.sb-pending    { background:#fef9c3; color:#854d0e; }
.sb-delivered  { background:#dcfce7; color:#166534; }
.sb-processing { background:#dbeafe; color:#1e40af; }
.sb-cancelled  { background:#fee2e2; color:#991b1b; }
</style>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
(function(){
    // -- Monthly Revenue Chart --
    var revenueLabels  = @json($chartLabels);
    var revenueData    = @json($revenueByMonth);

    new ApexCharts(document.querySelector('#revenueChart'), {
        chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: 'inherit' },
        series: [{ name: 'Revenue (DZD)', data: revenueData }],
        xaxis: { categories: revenueLabels, labels: { style: { colors: '#94a3b8', fontSize: '12px' } } },
        yaxis: { labels: { formatter: v => new Intl.NumberFormat('fr-DZ',{notation:'compact'}).format(v)+' DZD', style: { colors: '#94a3b8' } } },
        colors: ['#4f46e5'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: .85, opacityTo: .4, stops: [0,100] } },
        dataLabels: { enabled: false },
        plotOptions: { bar: { borderRadius: 6, columnWidth: '50%' } },
        grid: { borderColor: '#f1f5f9' },
        tooltip: { y: { formatter: v => new Intl.NumberFormat('fr-DZ').format(v) + ' DZD' } }
    }).render();

    // -- Order Status Donut --
    var statusLabels = @json(array_keys($orderStatusBreakdown));
    var statusData   = @json(array_values($orderStatusBreakdown));

    new ApexCharts(document.querySelector('#statusChart'), {
        chart: { type: 'donut', height: 280, fontFamily: 'inherit' },
        series: statusData,
        labels: statusLabels,
        colors: ['#f59e0b','#4f46e5','#10b981','#ef4444'],
        legend: { position: 'bottom', fontSize: '13px' },
        dataLabels: { enabled: true },
        plotOptions: { pie: { donut: { size: '65%' } } },
        tooltip: { y: { formatter: v => v + ' orders' } }
    }).render();
})();
</script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="row mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h3 class="page-title mb-0">Dashboard</h3>
                    <p class="text-muted mb-0" style="font-size:.85rem;">Welcome back — here's what's happening.</p>
                </div>
                <a href="{{ route('admin.reports') }}" class="btn btn-primary btn-sm">
                    <i class="mdi mdi-chart-bar me-1"></i> Reports &amp; Export
                </a>
            </div>
        </div>

        {{-- ===== STAT CARDS ROW 1 ===== --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-xl-2">
                <div class="card adm-stat-card bg-grad-blue mb-0">
                    <div class="stat-icon-wrap" style="background:rgba(255,255,255,.15)"><i class="mdi mdi-account-group"></i></div>
                    <div><div class="stat-label">Clients</div><div class="stat-value">{{ $totalClients }}</div><div class="stat-sub">Active</div></div>
                    <i class="mdi mdi-account-group card-bg-ico"></i>
                </div>
            </div>
            <div class="col-md-6 col-xl-2">
                <div class="card adm-stat-card bg-grad-teal mb-0">
                    <div class="stat-icon-wrap" style="background:rgba(255,255,255,.15)"><i class="mdi mdi-store"></i></div>
                    <div><div class="stat-label">Vendors</div><div class="stat-value">{{ $totalVendors }}</div><div class="stat-sub">Active</div></div>
                    <i class="mdi mdi-store card-bg-ico"></i>
                </div>
            </div>
            <div class="col-md-6 col-xl-2">
                <div class="card adm-stat-card bg-grad-green mb-0">
                    <div class="stat-icon-wrap" style="background:rgba(255,255,255,.15)"><i class="mdi mdi-package-variant-closed"></i></div>
                    <div><div class="stat-label">Products</div><div class="stat-value">{{ $totalProducts }}</div><div class="stat-sub">Listed</div></div>
                    <i class="mdi mdi-package-variant-closed card-bg-ico"></i>
                </div>
            </div>
            <div class="col-md-6 col-xl-2">
                <div class="card adm-stat-card bg-grad-amber mb-0">
                    <div class="stat-icon-wrap" style="background:rgba(255,255,255,.15)"><i class="mdi mdi-domain"></i></div>
                    <div><div class="stat-label">Magasins</div><div class="stat-value">{{ $totalActiveMagasins }}</div><div class="stat-sub">of {{ $totalMagasins }} total</div></div>
                    <i class="mdi mdi-domain card-bg-ico"></i>
                </div>
            </div>
            <div class="col-md-6 col-xl-2">
                <div class="card adm-stat-card bg-grad-rose mb-0">
                    <div class="stat-icon-wrap" style="background:rgba(255,255,255,.15)"><i class="mdi mdi-star"></i></div>
                    <div><div class="stat-label">Reviews</div><div class="stat-value">{{ $totalReviews }}</div><div class="stat-sub">{{ number_format($avgRating,1) }} / 5 avg</div></div>
                    <i class="mdi mdi-star card-bg-ico"></i>
                </div>
            </div>
            <div class="col-md-6 col-xl-2">
                <div class="card adm-stat-card bg-grad-slate mb-0">
                    <div class="stat-icon-wrap" style="background:rgba(255,255,255,.15)"><i class="mdi mdi-cart-outline"></i></div>
                    <div><div class="stat-label">Orders</div><div class="stat-value">{{ $totalOrders }}</div><div class="stat-sub">{{ $pendingOrders }} pending</div></div>
                    <i class="mdi mdi-cart-outline card-bg-ico"></i>
                </div>
            </div>
        </div>

        {{-- ===== CHARTS ROW ===== --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-8">
                <div class="card adm-section-card h-100">
                    <div class="card-header">
                        <span><i class="mdi mdi-chart-bar me-1 text-primary"></i>Monthly Revenue (DZD) — Last 6 Months</span>
                        <a href="{{ route('admin.reports') }}" class="btn btn-xs btn-outline-primary">Full Report</a>
                    </div>
                    <div class="card-body">
                        <div id="revenueChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card adm-section-card h-100">
                    <div class="card-header">
                        <span><i class="mdi mdi-chart-donut me-1 text-primary"></i>Order Status</span>
                    </div>
                    <div class="card-body">
                        <div id="statusChart"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== TABLES ROW ===== --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-5">
                <div class="card adm-section-card">
                    <div class="card-header">
                        <span><i class="mdi mdi-star-outline me-1 text-warning"></i>Top Rated Magasins</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table adm-table mb-0">
                                <thead><tr><th>#</th><th>Magasin</th><th>Rating</th><th></th></tr></thead>
                                <tbody>
                                    @foreach ($topMagasinsRating as $i => $magasin)
                                    <tr>
                                        <td class="text-muted">{{ $i+1 }}</td>
                                        <td>
                                            <div style="font-weight:600;">{{ $magasin->name }}</div>
                                            <small class="text-muted">Since {{ $magasin->created_at->format('Y') }}</small>
                                        </td>
                                        <td><span class="status-badge sb-delivered">{{ number_format($magasin->rate,1) }} ⭐</span></td>
                                        <td><a href="{{ route('frontend.vendor_details', $magasin->id) }}" class="btn btn-xs btn-light"><i class="mdi mdi-eye"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card adm-section-card">
                    <div class="card-header">
                        <span><i class="mdi mdi-fire me-1 text-danger"></i>Best Selling Products</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table adm-table mb-0">
                                <thead><tr><th>#</th><th>Product</th><th>Sold</th><th>Price</th><th></th></tr></thead>
                                <tbody>
                                    @foreach ($bestSellingProducts as $i => $product)
                                    <tr>
                                        <td class="text-muted">{{ $i+1 }}</td>
                                        <td style="font-weight:600;">{{ $product->name }}</td>
                                        <td>{{ $product->order_items_count }} units</td>
                                        <td>{{ number_format($product->price) }} DZD</td>
                                        <td><a href="{{ route('frontend.product_details', $product->id) }}" class="btn btn-xs btn-light"><i class="mdi mdi-eye"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== RECENT ORDERS ===== --}}
        <div class="row g-3">
            <div class="col-12">
                <div class="card adm-section-card">
                    <div class="card-header">
                        <span><i class="mdi mdi-cart-outline me-1 text-primary"></i>Recent Orders</span>
                        <a href="{{ route('admin.orders') }}" class="btn btn-xs btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table adm-table mb-0">
                                <thead><tr><th>#</th><th>Customer</th><th>Amount</th><th>Payment</th><th>Status</th><th>Date</th><th></th></tr></thead>
                                <tbody>
                                    @foreach ($latestOrders as $order)
                                    @php
                                        $sbClass = match($order->status) {
                                            'delivered' => 'sb-delivered',
                                            'processing' => 'sb-processing',
                                            'cancelled' => 'sb-cancelled',
                                            default => 'sb-pending',
                                        };
                                    @endphp
                                    <tr>
                                        <td class="text-muted">#{{ $order->id }}</td>
                                        <td style="font-weight:600;">{{ $order->user->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($order->totalAmount) }} DZD</td>
                                        <td>{{ ucfirst($order->paymentMethod ?? '-') }}</td>
                                        <td><span class="status-badge {{ $sbClass }}">{{ ucfirst($order->status) }}</span></td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td><a href="{{ route('admin.order_details', $order->id) }}" class="btn btn-xs btn-light"><i class="mdi mdi-eye"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection


