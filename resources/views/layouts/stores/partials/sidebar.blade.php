<div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">TAD stores</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">TAD</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li class="nav-item dropdown {{Request::is('*stores')?'active':''}}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                  <li class="{{Request::is('*stores')?'active':''}}"><a class="nav-link" href="{{ route('stores.statistics') }}">General Dashboard</a></li>
                  <!--<li class=""><a class="nav-link" href="">Finance</a></li>-->
                </ul>
              </li>
                <li class="menu-header">Store</li>
               <li class="{{Request::is('*stores/allStores*')?'active':''}}"><a class="nav-link" href="{{ route('stores.allStores') }}"><i class="fas fa-warehouse"></i> <span>All Stores</span></a></li>
                <li class=""><a class="nav-link" href=""><i class="fas fa-chart-line"></i> <span>Finance</span></a></li>
               <li class=""><a class="nav-link" href=""><i class="fas fa-box"></i> <span>transactions</span></a></li>
               
               <li class=""><a class="nav-link" href=""><i class="fas fa-user"></i> <span>Users</span></a></li>
              
            </ul>

            
        </aside>
      </div>