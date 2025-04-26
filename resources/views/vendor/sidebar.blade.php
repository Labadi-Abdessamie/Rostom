<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a
                href="{{ route('frontend.index') }}">{{ Auth::user()->magasin()->exists() ? Auth::user()->magasin->name : 'Magasin' }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li>
                <a href="{{ route('vendor.dashboard') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Stock</li>
            <li>
                <a href="{{ route('vendor.products') }}" class="nav-link"><i
                        class="fas fa-columns"></i><span>Products</span></a>
            </li>

            <li class="menu-header">Sales</li>
            <li>
                <a href="{{ route('vendor.orders') }}" class="nav-link"><i
                        class="fas fa-box"></i><span>Orders</span></a>
            </li>
            @if (false)
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-box"></i>
                        <span>Orders</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="">Pending Orders</a></li>
                        <li><a class="nav-link" href="">Confirmed Orders</a></li>
                        <li><a class="nav-link" href="">Completed Orders</a></li>
                    </ul>
                </li>
            @endif
            <li>
                <a href="{{ route('vendor.reviews') }}" class="nav-link"><i
                        class="fas fa-quote-left"></i><span>Reviews</span></a>
            </li>
            <li class="menu-header">Purchase</li>

            <li>
                <a href="{{ route('vendor.purchase_orders') }}" class="nav-link"><i
                        class="fas fa-shopping-cart"></i><span>Purchase Orders</span></a>
            </li>
            @if (false)
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-shopping-cart"></i>
                        <span>Purchase Orders</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="">Invoices</a></li>
                    </ul>
                    <ul class="dropdown-menu">
                        <li><a href="">Orders</a></li>
                    </ul>
                    <ul class="dropdown-menu">
                        <li><a href="">Delivred</a></li>
                    </ul>
                </li>
            @endif
            <li class="menu-header">Pages</li>

            <li>
                <a href="{{ route('vendor.magasin') }}" class="nav-link"><i class="fas fa-home"></i><span>Magasin
                        Settings</span></a>
            </li>
            @if (false)
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-home"></i>
                        <span>Magasin Settings</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="features-activities.html">Informations</a></li>
                        <li><a class="nav-link" href="features-activities.html">Status</a></li>
                    </ul>
                </li>
            @endif
            <li>
                <a href="{{ route('vendor.contact') }}" class="nav-link"><i class="fas fa-envelope"></i><span>Support
                        Contact</span></a>
            </li>
        </ul>
    </aside>
</div>
