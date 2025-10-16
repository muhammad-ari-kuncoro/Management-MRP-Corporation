<div id="sidebar">
    <div id="sidebar">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="logo">
                        <a href="{{ route('dashboard') }}"><img src="./assets/compiled/svg/logo.svg" alt="Logo"></a>
                    </div>
                    <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                        <!-- mode toggle -->
                        <div class="form-check form-switch fs-6">
                            <input class="form-check-input me-0" type="checkbox" id="toggle-dark"
                                style="cursor: pointer">
                            <label class="form-check-label"></label>
                        </div>
                    </div>
                    <div class="sidebar-toggler x">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>

            <div class="sidebar-menu">
                <ul class="menu">
                    <li class="sidebar-title">Menu</li>

                    {{-- Dashboard --}}
                    <li class="sidebar-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    {{-- Master --}}
                    <li class="sidebar-item has-sub {{ Request::is('items*') ? 'active' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-stack"></i>
                            <span>Master</span>
                        </a>
                        <ul class="submenu">

                            <li class="submenu-item {{ Request::routeIs('branch-company.index') ? 'active' : '' }}">
                                <a href="{{ route('branch-company.index') }}" class="submenu-link">Master Data Branch
                                    Company</a>
                            </li>


                            <li class="submenu-item {{ Request::routeIs('supplier-company.index') ? 'active' : '' }}">
                                <a href="{{ route('supplier-company.index') }}" class="submenu-link">Master Data
                                    Supplier Company</a>
                            </li>


                            <li class="submenu-item {{ Request::routeIs('items.index') ? 'active' : '' }}">
                                <a href="{{ route('items.index') }}" class="submenu-link">Master Data Barang</a>
                            </li>

                        </ul>
                    </li>

                    {{-- Permintaan / Purchase Order --}}
                    <li class="sidebar-item has-sub {{ Request::is('purchase*') ? 'active' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-receipt"></i>
                            <span>Permintaan</span>
                        </a>
                        <ul class="submenu">
                            <li class="submenu-item ">
                                <a href="{{ route('purchase-order.index') }}" class="submenu-link">Purchase Orders</a>
                            </li>
                            <li class="submenu-item">
                                <a href="component-alert.html" class="submenu-link">Alert</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
