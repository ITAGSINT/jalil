<div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">TAD Ecommerce</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">TAD</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li class="nav-item dropdown {{Request::is('*dashboard')?'active':''}} {{Request::is('*dashboard/finance')?'active':''}}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                  <li class="{{Request::is('*dashboard')?'active':''}}"><a class="nav-link" href="{{ route('dashboard.index') }}">General Dashboard</a></li>
                  <li class="{{Request::is('*dashboard/finance')?'active':''}}"><a class="nav-link" href="{{ route('dashboard.finance.index') }}">Finance</a></li>
                </ul>
              </li>
              <li class="menu-header">market</li>
               
               <li class="nav-item dropdown {{Request::is('*dashboard/categories*')?'active':''}} {{Request::is('*/reviews/*')?'active':''}} {{Request::is('*dashboard/products*')?'active':''}} {{Request::is('*dashboard/color_size*')?'active':''}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-gem"></i> <span>Products</span></a>
                <ul class="dropdown-menu">
                  <li class="{{Request::is('*dashboard/products*')?'active':''}}"><a class="nav-link" href="{{ route('dashboard.products.index') }}">All Products</a></li>
                  <li class="{{Request::is('*dashboard/categories*')?'active':''}}"><a class="nav-link" href="{{ route('dashboard.categories.index') }}">Categories</a></li>
                  <li class="{{Request::is('*dashboard/color_size*')?'active':''}}"><a class="nav-link" href="{{ route('dashboard.color_size.index') }}">Settings</a></li>
                  <li class="{{Request::is('*/reviews/*')?'active':''}}"><a class="nav-link" href="{{ route('dashboard.reviews') }}">Reviews</a></li>
                </ul>
              </li>
              
               <li class="{{Request::is('*dashboard/orders*')?'active':''}}"><a class="nav-link" href="{{ route('dashboard.orders.index') }}"><i class="fas fa-box"></i> <span>Orders</span></a></li>
               
               <li class="{{Request::is('*dashboard/users/*')?'active':''}}"><a class="nav-link" href="{{ route('dashboard.users.index') }}"><i class="fas fa-user"></i> <span>Users</span></a></li>
               
              <li class="{{Request::is('*dashboard/point_of_sale')?'active':''}}"><a class="nav-link" href="{{ route('dashboard.point_of_sale') }}"><i class="fas fa-dot-circle"></i> <span>Point Of Sale</span></a></li>
              <li class="{{Request::is('*dashboard/stores')?'active':''}}"><a class="nav-link" href="{{ route('dashboard.stores') }}"><i class="fas fa-warehouse"></i> <span>Stores</span></a></li>
            </ul>

            
        </aside>
      </div>