<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li class="menu-title">Navigation</li>
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Apps</li>

                <li>
                    <a data-bs-target="#sidebarcustomers" data-bs-toggle="collapse" class="cursor-pointer">
                        <i class="mdi mdi-account-multiple-outline"></i>
                        <span> Customers </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarcustomers">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.customers') }}">Customers</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.customers', ['type' => 'inactive']) }}">Inactive Customers</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.customers', ['type' => 'blocked']) }}">Blocked Customers</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a data-bs-target="#sidebarvendors" data-bs-toggle="collapse" class="cursor-pointer">
                        <i class="mdi mdi-account-multiple-outline"></i>
                        <span> Vendors </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarvendors">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.vendors') }}">Vendors</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.vendors', ['type' => 'blocked']) }}">Blocked Vendors</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a data-bs-target="#sidebarMagasins" data-bs-toggle="collapse" class="cursor-pointer">
                        <i class="mdi mdi-domain"></i>
                        <span> Magasins </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarMagasins">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.magasins') }}">List</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.magasins', ['filtre' => 'demands']) }}">Demands</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('admin.categories') }}">
                        <i class="mdi mdi-table"></i>
                        <span> Categories </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products') }}">
                        <i class="mdi mdi-package-variant"></i>
                        <span> Products </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.reviews') }}">
                        <i class="mdi mdi-comment"></i>
                        <span> Reviews </span>
                    </a>
                </li>
                <li>
                    <a data-bs-target="#sidebarProjects" data-bs-toggle="collapse" class="cursor-pointer">
                        <i class="mdi mdi-briefcase-check-outline"></i>
                        <span> Banners </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarProjects">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.banners') }}">List</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.add_banner') }}">Create Banner</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('admin.orders') }}">
                        <i class="mdi mdi-cart-outline"></i>
                        <span> Orders </span>
                    </a>
                </li>
                @if (false)
                    <li>
                        <a href="apps-file-manager.html">
                            <i class="mdi mdi-folder-star-outline"></i>
                            <span> File Manager </span>
                        </a>
                    </li>
                @endif
                <li class="menu-title mt-2">Admin Settings</li>

                <li>
                    <a href="{{ route('admin.admins') }}">
                        <i class="mdi mdi-account-circle-outline"></i>
                        <span> Admins </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->
