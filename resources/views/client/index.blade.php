@extends('client.master')

@section('title')
    My Dashboard
@endsection

@section('content')
<div class="row">
    <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
        <div class="dashboard_content" style="background: #f8f9fa;">
            
            <!-- Welcome Section with User Profile -->
            <div class="corporate-welcome" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); border-radius: 10px; padding: 40px; color: white; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 style="font-size: 28px; font-weight: 700; margin: 0 0 10px 0;">Welcome, {{ Auth::user()->name }} 👋</h1>
                        <p style="font-size: 14px; opacity: 0.9; margin: 0;">{{ date('l, F j, Y') }} - Here's your dashboard summary</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <img src="{{ Auth::user()->profilePicture ? asset('storage/profile_pictures/' . Auth::id() . '/' . Auth::user()->profilePicture) : asset('frontend/images/No_Image.png') }}" 
                            alt="Profile" style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid white; object-fit: cover;">
                    </div>
                </div>
            </div>

            <!-- Key Statistics Row -->
            <div class="stats-grid mb-4">
                <h2 style="font-size: 18px; font-weight: 700; color: #2c3e50; margin-bottom: 20px;">Your Statistics</h2>
                <div class="row">
                    <!-- Total Orders -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-box" style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #e74c3c;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p style="margin: 0; font-size: 12px; color: #7f8c8d; font-weight: 600; text-transform: uppercase;">Total Orders</p>
                                    <h3 style="margin: 10px 0 0 0; font-size: 36px; font-weight: 700; color: #2c3e50;">{{ App\Models\Order::where('user_id', Auth::id())->count() }}</h3>
                                </div>
                                <div style="font-size: 32px; color: #e74c3c; opacity: 0.2;"><i class="fas fa-shopping-cart"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Wishlist Items -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-box" style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #e91e63;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p style="margin: 0; font-size: 12px; color: #7f8c8d; font-weight: 600; text-transform: uppercase;">Wishlist</p>
                                    <h3 style="margin: 10px 0 0 0; font-size: 36px; font-weight: 700; color: #2c3e50;">{{ App\Models\Bag::where('user_id', Auth::id())->where('type', 'wishlist')->count() }}</h3>
                                </div>
                                <div style="font-size: 32px; color: #e91e63; opacity: 0.2;"><i class="fas fa-heart"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-box" style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #f39c12;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p style="margin: 0; font-size: 12px; color: #7f8c8d; font-weight: 600; text-transform: uppercase;">Reviews</p>
                                    <h3 style="margin: 10px 0 0 0; font-size: 36px; font-weight: 700; color: #2c3e50;">{{ App\Models\Review::where('user_id', Auth::id())->count() }}</h3>
                                </div>
                                <div style="font-size: 32px; color: #f39c12; opacity: 0.2;"><i class="fas fa-star"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Addresses -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-box" style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #16a085;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p style="margin: 0; font-size: 12px; color: #7f8c8d; font-weight: 600; text-transform: uppercase;">Addresses</p>
                                    <h3 style="margin: 10px 0 0 0; font-size: 36px; font-weight: 700; color: #2c3e50;">{{ App\Models\Address::where('user_id', Auth::id())->count() }}</h3>
                                </div>
                                <div style="font-size: 32px; color: #16a085; opacity: 0.2;"><i class="fas fa-map-marker-alt"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Navigation Section -->
            <div class="quick-nav-section mb-4">
                <h2 style="font-size: 18px; font-weight: 700; color: #2c3e50; margin-bottom: 20px;">Quick Navigation</h2>
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('client.orders') }}" class="nav-card" style="background: white; border-radius: 8px; padding: 30px; text-align: center; text-decoration: none; color: #2c3e50; display: block; transition: all 0.3s; border-top: 3px solid #3498db; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <div style="font-size: 40px; margin-bottom: 12px; color: #3498db;"><i class="fas fa-list-ul"></i></div>
                            <h5 style="margin: 0 0 8px 0; font-weight: 600; font-size: 16px;">View Orders</h5>
                            <p style="margin: 0; font-size: 12px; color: #7f8c8d;">Manage your orders</p>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('client.wishlist') }}" class="nav-card" style="background: white; border-radius: 8px; padding: 30px; text-align: center; text-decoration: none; color: #2c3e50; display: block; transition: all 0.3s; border-top: 3px solid #e91e63; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <div style="font-size: 40px; margin-bottom: 12px; color: #e91e63;"><i class="fas fa-heart"></i></div>
                            <h5 style="margin: 0 0 8px 0; font-weight: 600; font-size: 16px;">Wishlist</h5>
                            <p style="margin: 0; font-size: 12px; color: #7f8c8d;">Your saved items</p>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('client.reviews') }}" class="nav-card" style="background: white; border-radius: 8px; padding: 30px; text-align: center; text-decoration: none; color: #2c3e50; display: block; transition: all 0.3s; border-top: 3px solid #f39c12; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <div style="font-size: 40px; margin-bottom: 12px; color: #f39c12;"><i class="fas fa-pen-fancy"></i></div>
                            <h5 style="margin: 0 0 8px 0; font-weight: 600; font-size: 16px;">My Reviews</h5>
                            <p style="margin: 0; font-size: 12px; color: #7f8c8d;">Your reviews & ratings</p>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('client.address') }}" class="nav-card" style="background: white; border-radius: 8px; padding: 30px; text-align: center; text-decoration: none; color: #2c3e50; display: block; transition: all 0.3s; border-top: 3px solid #16a085; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <div style="font-size: 40px; margin-bottom: 12px; color: #16a085;"><i class="fas fa-location-dot"></i></div>
                            <h5 style="margin: 0 0 8px 0; font-weight: 600; font-size: 16px;">Addresses</h5>
                            <p style="margin: 0; font-size: 12px; color: #7f8c8d;">Manage addresses</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Card Section -->
            <div class="profile-info-section mb-4">
                <h2 style="font-size: 18px; font-weight: 700; color: #2c3e50; margin-bottom: 20px;">Account Information</h2>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="info-card" style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <h5 style="margin: 0 0 15px 0; font-weight: 600; color: #2c3e50; border-bottom: 2px solid #e74c3c; padding-bottom: 10px;">Personal Details</h5>
                            <div class="info-row mb-3">
                                <span style="color: #7f8c8d; font-size: 13px;">Name:</span>
                                <span style="color: #2c3e50; font-weight: 500;">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="info-row mb-3">
                                <span style="color: #7f8c8d; font-size: 13px;">Email:</span>
                                <span style="color: #2c3e50; font-weight: 500;">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="info-row">
                                <span style="color: #7f8c8d; font-size: 13px;">Member Since:</span>
                                <span style="color: #2c3e50; font-weight: 500;">{{ Auth::user()->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="info-card" style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <h5 style="margin: 0 0 15px 0; font-weight: 600; color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px;">Quick Actions</h5>
                            <a href="{{ route('client.profile') }}" class="action-btn" style="display: inline-block; background: #3498db; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-size: 13px; margin-bottom: 8px; margin-right: 8px; transition: all 0.3s;">
                                <i class="fas fa-user"></i> Edit Profile
                            </a>
                            <a href="{{ route('client.address') }}" class="action-btn" style="display: inline-block; background: #16a085; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-size: 13px; margin-bottom: 8px; margin-right: 8px; transition: all 0.3s;">
                                <i class="fas fa-map-marker"></i> Manage Addresses
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Activity Section -->
            <div class="activity-timeline">
                <h2 style="font-size: 18px; font-weight: 700; color: #2c3e50; margin-bottom: 20px;">Recent Activity</h2>
                <div style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    @php
                        $recentOrders = App\Models\Order::where('user_id', Auth::id())->latest()->take(5)->get();
                    @endphp
                    
                    @if($recentOrders->count() > 0)
                        <div class="timeline">
                            @foreach($recentOrders as $order)
                            <div class="timeline-item" style="padding: 15px 0; border-bottom: 1px solid #ecf0f1; display: flex; gap: 15px;">
                                <div style="width: 12px; height: 12px; background: #e74c3c; border-radius: 50%; margin-top: 3px; flex-shrink: 0;"></div>
                                <div>
                                    <p style="margin: 0; font-weight: 600; color: #2c3e50; font-size: 14px;">Order #{{ $order->id }}</p>
                                    <p style="margin: 5px 0 0 0; color: #7f8c8d; font-size: 12px;">Placed {{ $order->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p style="text-align: center; color: #7f8c8d; padding: 20px 0; margin: 0;">No orders yet. Start shopping to see your activity here!</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Professional Dashboard Styles */
    .dashboard_content {
        padding: 20px;
    }

    .stat-box {
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.12) !important;
    }

    .nav-card {
        transition: all 0.3s ease !important;
    }

    .nav-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    }

    .nav-card:hover > div:first-child {
        transform: scale(1.1);
    }

    .action-btn:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }

    .timeline-item:last-child {
        border-bottom: none !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .corporate-welcome {
            padding: 25px !important;
            text-align: center;
        }

        .corporate-welcome .text-end {
            text-align: center !important;
            margin-top: 15px;
        }

        .nav-card {
            padding: 20px !important;
        }
    }
</style>
@endsection
