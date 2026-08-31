{{-- ============================================================
     VENDOR SIDEBAR
     Self-contained, zoom-safe (does not rely on nicescroll).
     Native overflow on the wrapper means content always shows
     no matter the browser zoom level.
============================================================ --}}
<div class="vendor-sidebar">
    <div class="vendor-sidebar-inner">

        {{-- Mobile close --}}
        <button type="button" onclick="closeMobileSidebar()"
                class="vendor-sidebar-close" aria-label="Close menu">
            <i class="fas fa-times"></i>
        </button>

        {{-- Brand --}}
        <div class="vendor-sidebar-brand">
            <a href="{{ Auth::user()->magasin
                        ? route('frontend.vendor_details', ['id' => Auth::user()->magasin->id])
                        : '#' }}">
                <i class="fas fa-store mr-2"></i>
                {{ Auth::user()->magasin ? Auth::user()->magasin->name : 'Magasin' }}
            </a>
        </div>

        {{-- Scrollable menu --}}
        <div class="vendor-sidebar-scroll">
            <ul class="vendor-sidebar-menu">
                <li class="vendor-menu-header">Dashboard</li>
                <li>
                    <a href="{{ route('vendor.dashboard') }}" class="vendor-nav-link">
                        <i class="fas fa-fire"></i><span>Dashboard</span>
                    </a>
                </li>

                <li class="vendor-menu-header">Stock</li>
                <li>
                    <a href="{{ route('vendor.products') }}" class="vendor-nav-link">
                        <i class="fas fa-columns"></i><span>Products</span>
                    </a>
                </li>

                <li class="vendor-menu-header">Sales</li>
                <li>
                    <a href="{{ route('vendor.orders') }}" class="vendor-nav-link">
                        <i class="fas fa-box"></i><span>Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('vendor.pending_payments') }}" class="vendor-nav-link">
                        <i class="fas fa-clock"></i><span>Pending Payments</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('vendor.reviews') }}" class="vendor-nav-link">
                        <i class="fas fa-quote-left"></i><span>Reviews</span>
                    </a>
                </li>

                <li class="vendor-menu-header">Purchase</li>
                <li>
                    <a href="{{ route('vendor.purchase_orders') }}" class="vendor-nav-link">
                        <i class="fas fa-shopping-cart"></i><span>Purchase Orders</span>
                    </a>
                </li>

                <li class="vendor-menu-header">Pages</li>
                <li>
                    <a href="{{ route('vendor.magasin') }}" class="vendor-nav-link">
                        <i class="fas fa-home"></i><span>Magasin Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('vendor.contact') }}" class="vendor-nav-link">
                        <i class="fas fa-envelope"></i><span>Support Contact</span>
                    </a>
                </li>
            </ul>
        </div>

        {{-- Footer --}}
        <div class="vendor-sidebar-foot">
            <small>v1.0 · Vendor Panel</small>
        </div>
    </div>
</div>
