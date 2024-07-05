<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">TAD Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">TAD</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('dashboard/sidebar.dashboard') }}</li>
            <li
                class="nav-item dropdown {{ Request::is('*dashboard') ? 'active' : '' }} {{ Request::is('*dashboard/finance') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i
                        class="fas fa-tachometer-alt"></i><span>{{ __('dashboard/sidebar.dashboard') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('*dashboard') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('dashboard.index') }}">{{ __('dashboard/sidebar.main_page') }}</a></li>

                </ul>
            </li>
            <li class="menu-header">{{ __('dashboard/sidebar.market') }}</li>

            <li
                class="nav-item dropdown {{ Request::is('*dashboard/categories*') ? 'active' : '' }} {{ Request::is('*/reviews/*') ? 'active' : '' }} {{ Request::is('*dashboard/products*') ? 'active' : '' }} {{ Request::is('*dashboard/option*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-gem"></i>
                    <span>{{ __('dashboard/sidebar.products') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('*dashboard/products*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('dashboard.products.index') }}">{{ __('dashboard/sidebar.all_products') }}</a>
                    </li>
                    <li class="{{ Request::is('*dashboard/categories*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('dashboard.categories.index') }}">{{ __('dashboard/sidebar.categories') }}</a>
                    </li>
                    <li class="{{ Request::is('*dashboard/products/product_company*') ? 'active' : '' }}"><a
                            class="nav-link" href="{{ route('dashboard.product_company.index') }}">Companies</a></li>
                    <li class="{{ Request::is('*dashboard/products/products_brand*') ? 'active' : '' }}"><a
                            class="nav-link" href="{{ route('dashboard.product_brand.index') }}">Brands</a></li>
                    <li class="{{ Request::is('*dashboard/products/product_manufacturers*') ? 'active' : '' }}"><a
                            class="nav-link"
                            href="{{ route('dashboard.product_manufacturers.index') }}">Manufacturers</a></li>

                    <li class="{{ Request::is('*dashboard/coupons*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('dashboard.coupons.index') }}">{{ __('dashboard/sidebar.coupons') }}</a></li>

                </ul>
            </li>
            @if (Auth::user()->role_id == 1)
                <li class="nav-item dropdown {{ Request::is('*dashboard/cars*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fa fa-car" aria-hidden="true"></i>

                        <span>Cars</span>
                    </a>
                    <ul class="dropdown-menu">


                        <li class="{{ Request::is('*dashboard/cars/model*') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ route('dashboard.model.index') }}">Models</a></li>
                        <li class="{{ Request::is('*dashboard/cars/manufacturer*') ? 'active' : '' }}"><a
                                class="nav-link" href="{{ route('dashboard.manufacturer.index') }}">Manufacturers</a>
                        </li>

                        <li class="{{ Request::is('*dashboard/cars/color*') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ route('dashboard.color.index') }}">Colors</a>
                        </li>

                        <li class="{{ Request::is('*dashboard/cars/city*') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ route('dashboard.city.index') }}">Cities</a>
                        </li>
                    </ul>
                </li>


                <li class="{{ Request::is('*dashboard/orders*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('dashboard.orders.index') }}"><i class="fas fa-box"></i>
                        <span>{{ __('dashboard/sidebar.orders') }}</span></a>
                </li>

                <li class="{{ Request::is('*dashboard/users/*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('dashboard.users.index') }}"><i class="fas fa-user"></i>
                        <span>{{ __('dashboard/sidebar.admins') }}</span></a>
                </li>

                <li class="{{ Request::is('*dashboard/sliders/*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('dashboard.slider.index') }}"><i class="fas fa-images"></i>
                        <span>Sliders</span></a>
                </li>

                {{-- <li class="{{ Request::is('*dashboard/point_of_sale') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('dashboard.point_of_sale') }}"><i class="fas fa-dot-circle"></i> <span>{{ __('dashboard/sidebar.point_of_sale') }}</span></a></li>
                <li class="{{ Request::is('*dashboard/stores') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('dashboard.allStores') }}"><i class="fas fa-warehouse"></i>
                        <span>{{ __('dashboard/sidebar.stores') }}</span></a></li>  --}}
            @endif
        </ul>


    </aside>
</div>
