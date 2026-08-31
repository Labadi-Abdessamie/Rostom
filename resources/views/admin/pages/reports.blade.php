@extends('admin.master')

@section('title', 'Admin || Reports')

@section('styles')
<style>
.rpt-stat-card {
    border-radius: 14px; border: none;
    padding: 20px 18px;
    box-shadow: 0 4px 16px rgba(0,0,0,.07);
    display: flex; align-items: center; gap: 16px;
    position: relative; overflow: hidden;
}
.rpt-stat-card .rpt-icon {
    width: 50px; height: 50px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.35rem; flex-shrink: 0;
}
.rpt-stat-card .rpt-label { font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: #64748b; }
.rpt-stat-card .rpt-value { font-size: 1.55rem; font-weight: 800; color: #0f172a; line-height: 1.1; }

.export-card { border-radius: 14px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,.07); }
.export-card .card-header {
    background: transparent; border-bottom: 1px solid #f1f5f9;
    padding: 14px 20px; font-weight: 700; font-size: .92rem;
}
.export-btn {
    display: flex; align-items: center; gap: 10px;
    padding: 14px 18px; border-radius: 12px; border: 1.5px solid #e2e8f0;
    background: #f8fafc; text-decoration: none; color: #1e293b;
    font-weight: 600; font-size: .9rem; transition: all .18s;
}
.export-btn:hover { background: #4f46e5; color: #fff; border-color: #4f46e5; }
.export-btn .export-icon { font-size: 1.5rem; }

.rpt-table thead th { background: #f8fafc; font-size: .75rem; text-transform: uppercase; letter-spacing: .04em; color: #64748b; border: none; padding: 10px 14px; }
.rpt-table td { vertical-align: middle; padding: 10px 14px; border-color: #f1f5f9; }
</style>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
(function(){
    // 12-month revenue bar chart
    new ApexCharts(document.querySelector('#monthlyRevenueChart'), {
        chart: { type: 'bar', height: 300, toolbar: { show: false }, fontFamily: 'inherit' },
        series: [{ name: 'Revenue (DZD)', data: @json($monthlyRevenue) }],
        xaxis: { categories: @json($monthlyLabels), labels: { style: { colors: '#94a3b8', fontSize: '11px' }, rotate: -30 } },
        yaxis: { labels: { formatter: v => new Intl.NumberFormat('fr-DZ',{notation:'compact'}).format(v)+' DZD', style: { colors: '#94a3b8' } } },
        colors: ['#4f46e5'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: .9, opacityTo: .4, stops: [0,100] } },
        dataLabels: { enabled: false },
        plotOptions: { bar: { borderRadius: 5, columnWidth: '55%' } },
        grid: { borderColor: '#f1f5f9' },
        tooltip: { y: { formatter: v => new Intl.NumberFormat('fr-DZ').format(v) + ' DZD' } }
    }).render();

    // Order status donut
    new ApexCharts(document.querySelector('#statusDonut'), {
        chart: { type: 'donut', height: 300, fontFamily: 'inherit' },
        series: @json(array_values($orderStatusBreakdown)),
        labels: @json(array_keys($orderStatusBreakdown)),
        colors: ['#f59e0b','#4f46e5','#10b981','#ef4444'],
        legend: { position: 'bottom' },
        plotOptions: { pie: { donut: { size: '65%' } } },
        tooltip: { y: { formatter: v => v + ' orders' } }
    }).render();
})();
</script>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">

        {{-- Header --}}
        <div class="row mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h3 class="page-title mb-0">Reports &amp; Analytics</h3>
                    <p class="text-muted mb-0" style="font-size:.85rem;">Overview of all platform activity — export any section as CSV.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="mdi mdi-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>

        {{-- ===== KEY STATS ===== --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="rpt-stat-card">
                    <div class="rpt-icon" style="background:#ede9fe; color:#4f46e5;"><i class="mdi mdi-currency-usd"></i></div>
                    <div><div class="rpt-label">Total Revenue</div><div class="rpt-value">{{ number_format($totalRevenue) }} <small style="font-size:.7rem;color:#64748b;">DZD</small></div></div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="rpt-stat-card">
                    <div class="rpt-icon" style="background:#dcfce7; color:#059669;"><i class="mdi mdi-cart-check"></i></div>
                    <div><div class="rpt-label">Delivered Orders</div><div class="rpt-value">{{ $deliveredOrders }}</div></div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="rpt-stat-card">
                    <div class="rpt-icon" style="background:#fef9c3; color:#d97706;"><i class="mdi mdi-clock-outline"></i></div>
                    <div><div class="rpt-label">Pending Orders</div><div class="rpt-value">{{ $pendingOrders }}</div></div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="rpt-stat-card">
                    <div class="rpt-icon" style="background:#fee2e2; color:#e11d48;"><i class="mdi mdi-cart-remove"></i></div>
                    <div><div class="rpt-label">Cancelled Orders</div><div class="rpt-value">{{ $cancelledOrders }}</div></div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="rpt-stat-card">
                    <div class="rpt-icon" style="background:#dbeafe; color:#1d4ed8;"><i class="mdi mdi-account-group"></i></div>
                    <div><div class="rpt-label">Total Clients</div><div class="rpt-value">{{ $totalClients }}</div></div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="rpt-stat-card">
                    <div class="rpt-icon" style="background:#f0fdf4; color:#059669;"><i class="mdi mdi-store"></i></div>
                    <div><div class="rpt-label">Active Magasins</div><div class="rpt-value">{{ $totalActiveMagasins }} <small style="font-size:.7rem;color:#64748b;">/ {{ $totalMagasins }}</small></div></div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="rpt-stat-card">
                    <div class="rpt-icon" style="background:#fef3c7; color:#d97706;"><i class="mdi mdi-star"></i></div>
                    <div><div class="rpt-label">Avg Rating</div><div class="rpt-value">{{ number_format($avgRating, 1) }} <small style="font-size:.7rem;color:#64748b;">/ 5 ({{ $totalReviews }} reviews)</small></div></div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="rpt-stat-card">
                    <div class="rpt-icon" style="background:#f3e8ff; color:#7c3aed;"><i class="mdi mdi-package-variant"></i></div>
                    <div><div class="rpt-label">Total Products</div><div class="rpt-value">{{ $totalProducts }}</div></div>
                </div>
            </div>
        </div>

        {{-- ===== CHARTS ===== --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-8">
                <div class="card export-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="mdi mdi-chart-bar me-1 text-primary"></i>Monthly Revenue — Last 12 Months (DZD)</span>
                        <a href="{{ route('admin.export_csv', 'revenue') }}" class="btn btn-xs btn-outline-primary">
                            <i class="mdi mdi-download me-1"></i>Export CSV
                        </a>
                    </div>
                    <div class="card-body"><div id="monthlyRevenueChart"></div></div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card export-card">
                    <div class="card-header"><span><i class="mdi mdi-chart-donut me-1 text-primary"></i>Order Status Distribution</span></div>
                    <div class="card-body"><div id="statusDonut"></div></div>
                </div>
            </div>
        </div>

        {{-- ===== CSV EXPORTS ===== --}}
        <div class="row g-3 mb-4">
            <div class="col-12">
                <div class="card export-card">
                    <div class="card-header"><i class="mdi mdi-file-download-outline me-1 text-success"></i>Export Data as CSV</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3 col-sm-6">
                                <a href="{{ route('admin.export_csv', 'orders') }}" class="export-btn">
                                    <span class="export-icon"><i class="mdi mdi-cart-outline"></i></span>
                                    <div>
                                        <div style="font-size:.8rem;color:#64748b;">All Orders</div>
                                        <div>Orders Report</div>
                                    </div>
                                    <i class="mdi mdi-download ms-auto"></i>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <a href="{{ route('admin.export_csv', 'products') }}" class="export-btn">
                                    <span class="export-icon"><i class="mdi mdi-package-variant-closed"></i></span>
                                    <div>
                                        <div style="font-size:.8rem;color:#64748b;">All Products</div>
                                        <div>Products Report</div>
                                    </div>
                                    <i class="mdi mdi-download ms-auto"></i>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <a href="{{ route('admin.export_csv', 'customers') }}" class="export-btn">
                                    <span class="export-icon"><i class="mdi mdi-account-group-outline"></i></span>
                                    <div>
                                        <div style="font-size:.8rem;color:#64748b;">Clients &amp; Vendors</div>
                                        <div>Customers Report</div>
                                    </div>
                                    <i class="mdi mdi-download ms-auto"></i>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <a href="{{ route('admin.export_csv', 'revenue') }}" class="export-btn">
                                    <span class="export-icon"><i class="mdi mdi-chart-line"></i></span>
                                    <div>
                                        <div style="font-size:.8rem;color:#64748b;">Monthly Breakdown</div>
                                        <div>Revenue Report</div>
                                    </div>
                                    <i class="mdi mdi-download ms-auto"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== TOP PRODUCTS ===== --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-7">
                <div class="card export-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="mdi mdi-fire me-1 text-danger"></i>Top 10 Best Selling Products</span>
                        <a href="{{ route('admin.export_csv', 'products') }}" class="btn btn-xs btn-outline-primary"><i class="mdi mdi-download me-1"></i>CSV</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table rpt-table mb-0">
                                <thead><tr><th>#</th><th>Product</th><th>Price</th><th>Units Sold</th><th>Magasin</th></tr></thead>
                                <tbody>
                                    @foreach ($topProducts as $i => $product)
                                    <tr>
                                        <td class="text-muted">{{ $i+1 }}</td>
                                        <td style="font-weight:600;">{{ $product->name }}</td>
                                        <td>{{ number_format($product->price) }} DZD</td>
                                        <td>
    <div style="display:flex;align-items:center;gap:10px;width:100%;">
        <div style="flex:1;height:8px;background:#f1f5f9;border-radius:999px;overflow:hidden;">
            @php $maxUnits = $topProducts->max('order_items_count') ?: 1; @endphp
            <div style="height:100%;width:{{ ($product->order_items_count / $maxUnits) * 100 }}%;background:linear-gradient(90deg,#4f46e5 0%,#7c3aed 100%);border-radius:999px;"></div>
        </div>
        <span style="min-width:36px;text-align:right;font-weight:800;color:#1e1b4b;font-size:1rem;">{{ $product->order_items_count }}</span>
    </div>
</td>
                                        <td class="text-muted">{{ $product->magasin->name ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="card export-card">
                    <div class="card-header"><span><i class="mdi mdi-star-outline me-1 text-warning"></i>Top Rated Magasins</span></div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table rpt-table mb-0">
                                <thead><tr><th>#</th><th>Magasin</th><th>Rating</th><th>Status</th></tr></thead>
                                <tbody>
                                    @foreach ($topMagasins as $i => $magasin)
                                    <tr>
                                        <td class="text-muted">{{ $i+1 }}</td>
                                        <td style="font-weight:600;">{{ $magasin->name }}</td>
                                        <td>{{ number_format($magasin->rate, 1) }} ⭐</td>
                                        <td>
                                            @if($magasin->status === 'active')
                                                <span class="badge bg-success bg-opacity-15 text-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-15 text-secondary">{{ ucfirst($magasin->status) }}</span>
                                            @endif
                                        </td>
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
