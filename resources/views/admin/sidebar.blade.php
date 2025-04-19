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
                    <a href="#sidebarusers" data-bs-toggle="collapse">
                        <i class="mdi mdi-account-multiple-outline"></i>
                        <span> Users </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarusers">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.users') }}">Customers</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.new_users') }}">New Customers</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.vendors') }}">Vendors</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.blocked_users') }}">Blocked Users</a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li>
                    <a href="#sidebarMagasins" data-bs-toggle="collapse">
                        <i class="mdi mdi-domain"></i>
                        <span> Magasins </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarMagasins">
                        <ul class="nav-second-level">
                            <li>
                                <a href="project-list.html">List</a>
                            </li>
                            <li>
                                <a href="project-detail.html">Demands</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="tables-basic.html">
                        <i class="mdi mdi-table"></i>
                        <span> Products </span>
                    </a>
                </li>
                <li>
                    <a href="#sidebarProjects" data-bs-toggle="collapse">
                        <i class="mdi mdi-briefcase-check-outline"></i>
                        <span> Banners </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarProjects">
                        <ul class="nav-second-level">
                            <li>
                                <a href="project-list.html">List</a>
                            </li>
                            <li>
                                <a href="project-detail.html">Detail</a>
                            </li>
                            <li>
                                <a href="project-create.html">Create Banner</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#sidebarOrders" data-bs-toggle="collapse">
                        <i class="mdi mdi-cart-outline"></i>
                        <span> Orders </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarOrders">
                        <ul class="nav-second-level">
                            <li>
                                <a href="ecommerce-dashboard.html">List</a>
                            </li>
                            <li>
                                <a href="ecommerce-products.html">Pending</a>
                            </li>
                            <li>
                                <a href="ecommerce-product-detail.html">Confirmed</a>
                            </li>
                            <li>
                                <a href="ecommerce-product-edit.html">Delivred</a>
                            </li>
                            <li>
                                <a href="ecommerce-customers.html">Canceled</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="apps-file-manager.html">
                        <i class="mdi mdi-folder-star-outline"></i>
                        <span> File Manager </span>
                    </a>
                </li>
                <li class="menu-title mt-2">Admin Settings</li>

                <li>
                    <a href="#sidebarAuth" data-bs-toggle="collapse">
                        <i class="mdi mdi-account-circle-outline"></i>
                        <span>Admin</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAuth">
                        <ul class="nav-second-level">
                            <li>
                                <a href="auth-login.html">List</a>
                            </li>
                            <li>
                                <a href="auth-login-2.html">Create Admin</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->
