<!-- ========== Admin Sidebar ========== -->
<aside class="adm-sidebar" id="admSidebar">

    <!-- Header -->
    <div class="adm-sidebar-header">
        <a href="{{ route('frontend.index') }}" class="adm-brand">
            <i class="fas fa-store"></i>
            <span>{{ config('app.name', 'TiarShop') }}</span>
        </a>
        <button class="adm-sidebar-close" id="admSidebarClose" aria-label="Close menu">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Body -->
    <div class="adm-sidebar-body">
        <ul class="adm-menu">
            <li class="adm-menu-title">Navigation</li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="adm-menu-title">Management</li>

            <li class="has-sub">
                <a href="#">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                    <i class="fas fa-chevron-right adm-arrow"></i>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('admin.customers') }}">All Customers</a></li>
                    <li><a href="{{ route('admin.customers', ['type' => 'inactive']) }}">Inactive</a></li>
                    <li><a href="{{ route('admin.customers', ['type' => 'blocked']) }}">Blocked</a></li>
                </ul>
            </li>

            <li class="has-sub">
                <a href="#">
                    <i class="fas fa-store"></i>
                    <span>Vendors</span>
                    <i class="fas fa-chevron-right adm-arrow"></i>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('admin.vendors') }}">All Vendors</a></li>
                    @php $newVendorRequests = \App\Models\Magasin::where('status', 'firstOpening')->count(); @endphp
                    @if($newVendorRequests > 0)
                    <li>
                        <a href="{{ route('admin.vendors', ['type' => 'firstOpening']) }}" class="text-warning">
                            Pending Approval <span class="badge" style="background:#f59e0b;color:#fff;border-radius:999px;padding:2px 8px;font-size:11px;">{{ $newVendorRequests }}</span>
                        </a>
                    </li>
                    @endif
                    <li><a href="{{ route('admin.vendors', ['type' => 'blocked']) }}">Blocked</a></li>
                </ul>
            </li>

            <li class="has-sub">
                <a href="#">
                    <i class="fas fa-building"></i>
                    <span>Magasins</span>
                    <i class="fas fa-chevron-right adm-arrow"></i>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('admin.magasins') }}">All Magasins</a></li>
                    <li><a href="{{ route('admin.magasins', ['filtre' => 'demands']) }}">Demands</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.categories') }}" class="{{ Route::currentRouteName() == 'admin.categories' ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>Categories</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.products') }}" class="{{ Route::currentRouteName() == 'admin.products' ? 'active' : '' }}">
                    <i class="fas fa-box-open"></i>
                    <span>Products</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.variant_types') }}" class="{{ Route::currentRouteName() == 'admin.variant_types' || Route::currentRouteName() == 'admin.variant_type_create' || Route::currentRouteName() == 'admin.variant_type_edit' ? 'active' : '' }}">
                    <i class="fas fa-palette"></i>
                    <span>Variant Types</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.reviews') }}" class="{{ Route::currentRouteName() == 'admin.reviews' ? 'active' : '' }}">
                    <i class="fas fa-star-half-alt"></i>
                    <span>Reviews</span>
                </a>
            </li>

            <li class="has-sub">
                <a href="#">
                    <i class="fas fa-images"></i>
                    <span>Banners</span>
                    <i class="fas fa-chevron-right adm-arrow"></i>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('admin.banners') }}">All Banners</a></li>
                    <li><a href="{{ route('admin.add_banner') }}">Create Banner</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.orders') }}" class="{{ Route::currentRouteName() == 'admin.orders' ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.reports') }}" class="{{ Route::currentRouteName() == 'admin.reports' ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Reports</span>
                </a>
            </li>

            <li class="adm-menu-title">Settings</li>

            <li>
                <a href="{{ route('admin.admins') }}" class="{{ Route::currentRouteName() == 'admin.admins' ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i>
                    <span>Admins</span>
                </a>
            </li>

            <li class="has-sub">
                <a href="#">
                    <i class="fas fa-globe"></i>
                    <span>Site Content</span>
                    <i class="fas fa-chevron-right adm-arrow"></i>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('admin.site_info') }}" class="{{ in_array(Route::currentRouteName(), ['admin.site_info','admin.site_info.create','admin.site_info.edit']) ? 'active' : '' }}">Statistics</a></li>
                    <li><a href="{{ route('admin.team_members') }}" class="{{ in_array(Route::currentRouteName(), ['admin.team_members','admin.team_members.create','admin.team_members.edit']) ? 'active' : '' }}">Team Members</a></li>
                </ul>
            </li>

        </ul>
    </div>
</aside>
<!-- End Sidebar -->
