@extends('client.master')

@section('title')
    Dashboard
@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
@endpush

@section('content')
<style>
    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .dashboard_content {
        background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f7 100%);
        min-height: 100vh;
        padding: 50px 30px;
    }

    /* ===== HEADER & WELCOME SECTION ===== */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 45px;
        padding-bottom: 30px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    }

    .welcome-section {
        flex: 1;
    }

    .welcome-section h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 44px;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 8px 0;
        letter-spacing: -0.8px;
    }

    .welcome-section p {
        font-size: 15px;
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }

    .header-actions {
        display: flex;
        gap: 16px;
        align-items: center;
    }

    .notification-bell {
        width: 44px;
        height: 44px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .notification-bell:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }

    .user-avatar {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .user-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
    }

    /* ===== STATS CARDS ===== */
    .stats-section {
        margin-bottom: 50px;
    }

    .stats-title {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 24px;
        letter-spacing: -0.3px;
    }

    .stat-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 28px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, transparent 0%, #4f46e5 100%);
    }

    .stat-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
        transform: translateY(-8px);
    }

    .stat-card:nth-child(2)::before {
        background: linear-gradient(90deg, transparent 0%, #3b82f6 100%);
    }

    .stat-card:nth-child(3)::before {
        background: linear-gradient(90deg, transparent 0%, #8b5cf6 100%);
    }

    .stat-card:nth-child(4)::before {
        background: linear-gradient(90deg, transparent 0%, #ec4899 100%);
    }

    .stat-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .stat-info h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 48px;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 8px 0;
    }

    .stat-info p {
        font-size: 13px;
        color: #94a3b8;
        margin: 0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .stat-icon-box {
        width: 64px;
        height: 64px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        background: linear-gradient(135deg, #e0f2fe 0%, #e0f8f9 100%);
        color: #4f46e5;
    }

    .stat-card:nth-child(2) .stat-icon-box {
        background: linear-gradient(135deg, #dbeafe 0%, #e0f2fe 100%);
        color: #3b82f6;
    }

    .stat-card:nth-child(3) .stat-icon-box {
        background: linear-gradient(135deg, #ede9fe 0%, #f3e8ff 100%);
        color: #8b5cf6;
    }

    .stat-card:nth-child(4) .stat-icon-box {
        background: linear-gradient(135deg, #fbf0f9 0%, #fce7f3 100%);
        color: #ec4899;
    }

    /* ===== QUICK ACTIONS ===== */
    .quick-actions-section {
        margin-bottom: 50px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 26px;
    }

    .action-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 36px 24px;
        text-align: center;
        text-decoration: none;
        color: inherit;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: block;
        position: relative;
        overflow: hidden;
    }

    .action-card::before {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, transparent 100%);
        transition: all 0.5s ease;
    }

    .action-card:hover::before {
        top: 0;
        left: 0;
    }

    .action-card:hover {
        border-color: #cbd5e1;
        transform: translateY(-12px);
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
    }

    .action-inner {
        position: relative;
        z-index: 1;
    }

    .action-icon {
        font-size: 48px;
        margin-bottom: 18px;
        display: inline-block;
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, #e0f2fe 0%, #e0f8f9 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4f46e5;
        margin: 0 auto 18px;
        transition: all 0.3s ease;
    }

    .action-card:hover .action-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .action-card:nth-child(2) .action-icon {
        background: linear-gradient(135deg, #dbeafe 0%, #e0f2fe 100%);
        color: #3b82f6;
    }

    .action-card:nth-child(3) .action-icon {
        background: linear-gradient(135deg, #ede9fe 0%, #f3e8ff 100%);
        color: #8b5cf6;
    }

    .action-card:nth-child(4) .action-icon {
        background: linear-gradient(135deg, #fbf0f9 0%, #fce7f3 100%);
        color: #ec4899;
    }

    .action-title {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 6px 0;
    }

    .action-desc {
        font-size: 13px;
        color: #94a3b8;
        margin: 0;
    }

    /* ===== ACCOUNT INFORMATION ===== */
    .account-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 36px;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }

    .account-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
    }

    .card-title {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 28px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-title i {
        color: #4f46e5;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 28px;
    }

    .info-item {
        padding: 20px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    .info-label i {
        color: #4f46e5;
        font-size: 13px;
    }

    .info-value {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        word-break: break-word;
    }

    /* ===== TIMELINE / RECENT ACTIVITY ===== */
    .timeline-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 36px;
        transition: all 0.3s ease;
    }

    .timeline-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
    }

    .timeline {
        position: relative;
    }

    .timeline-item {
        padding: 24px 0;
        padding-left: 40px;
        position: relative;
        border-left: 2px solid #e2e8f0;
    }

    .timeline-item:last-child {
        border-left-color: transparent;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 26px;
        width: 14px;
        height: 14px;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border-radius: 50%;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }

    .timeline-item h5 {
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 6px 0;
    }

    .timeline-item p {
        font-size: 13px;
        color: #94a3b8;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .timeline-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 12px;
        background: linear-gradient(135deg, #e0f2fe 0%, #e0f8f9 100%);
        color: #4f46e5;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .info-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .dashboard_content {
            padding: 30px 20px;
        }

        .dashboard-header {
            margin-bottom: 30px;
        }

        .welcome-section h1 {
            font-size: 32px;
        }

        .header-actions {
            width: 100%;
            justify-content: flex-end;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .account-card, .timeline-card {
            padding: 24px;
        }

        .stat-info h3 {
            font-size: 36px;
        }

        .welcome-section p {
            font-size: 13px;
        }
    }
</style>

<!-- Dashboard Header with Welcome & Actions -->
<div class="row">
    <div class="col-12">
        <div class="dashboard_content">
            <div class="dashboard-header">
                <div class="welcome-section">
                    <h1>Welcome back, {{ Auth::user()->name }}! 👋</h1>
                    <p>{{ date('l, F j, Y') }} — Dashboard Overview</p>
                </div>
                <div class="header-actions">
                    <div class="notification-bell" title="Notifications">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="user-avatar" title="{{ Auth::user()->name }}">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
            <!-- Performance Stats Section -->
            <div class="stats-section">
                <h2 class="stats-title"><i class="fas fa-chart-line"></i> Performance Overview</h2>
                <div class="row stats-grid">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-content">
                                <div class="stat-info">
                                    <h3>{{ App\Models\Order::where('user_id', Auth::id())->count() }}</h3>
                                    <p>Total Orders</p>
                                </div>
                                <div class="stat-icon-box">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-content">
                                <div class="stat-info">
                                    <h3>{{ App\Models\Bag::where('user_id', Auth::id())->where('type', 'wishlist')->count() }}</h3>
                                    <p>Wishlist Items</p>
                                </div>
                                <div class="stat-icon-box">
                                    <i class="fas fa-heart"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-content">
                                <div class="stat-info">
                                    <h3>{{ App\Models\Review::where('user_id', Auth::id())->count() }}</h3>
                                    <p>Reviews</p>
                                </div>
                                <div class="stat-icon-box">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-content">
                                <div class="stat-info">
                                    <h3>{{ App\Models\Address::where('user_id', Auth::id())->count() }}</h3>
                                    <p>Addresses</p>
                                </div>
                                <div class="stat-icon-box">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Section -->
            <div class="quick-actions-section">
                <div class="section-header">
                    <h2 class="stats-title"><i class="fas fa-zap"></i> Quick Access</h2>
                </div>
                <div class="row actions-grid">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <a href="{{ route('client.orders') }}" class="action-card">
                            <div class="action-inner">
                                <div class="action-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <h5 class="action-title">My Orders</h5>
                                <p class="action-desc">View & track orders</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <a href="{{ route('client.wishlist') }}" class="action-card">
                            <div class="action-inner">
                                <div class="action-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <h5 class="action-title">Wishlist</h5>
                                <p class="action-desc">Saved items</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <a href="{{ route('client.reviews') }}" class="action-card">
                            <div class="action-inner">
                                <div class="action-icon">
                                    <i class="fas fa-pen-fancy"></i>
                                </div>
                                <h5 class="action-title">Reviews</h5>
                                <p class="action-desc">Written reviews</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <a href="{{ route('client.address') }}" class="action-card">
                            <div class="action-inner">
                                <div class="action-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <h5 class="action-title">Addresses</h5>
                                <p class="action-desc">Manage addresses</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Account Information Card -->
            <div class="account-card">
                <h3 class="card-title">
                    <i class="fas fa-user-circle"></i>
                    Account Information
                </h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-user"></i>
                            Full Name
                        </div>
                        <div class="info-value">{{ Auth::user()->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>
                            Email Address
                        </div>
                        <div class="info-value">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-calendar"></i>
                            Member Since
                        </div>
                        <div class="info-value">{{ Auth::user()->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-circle-check"></i>
                            Account Status
                        </div>
                        <div class="info-value" style="color: #4f46e5;">{{ ucfirst(Auth::user()->status) }}</div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Timeline -->
            @php
                $recentOrders = App\Models\Order::where('user_id', Auth::id())->latest()->take(8)->get();
            @endphp

            @if($recentOrders->count() > 0)
            <div class="timeline-card">
                <h3 class="card-title">
                    <i class="fas fa-history"></i>
                    Recent Orders
                </h3>
                <div class="timeline">
                    @foreach($recentOrders as $order)
                    <div class="timeline-item">
                        <h5>Order #{{ $order->id }}</h5>
                        <p>
                            {{ $order->created_at->diffForHumans() }}
                            <span class="timeline-badge">{{ number_format($order->totalAmount, 2) }} DZD</span>
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
