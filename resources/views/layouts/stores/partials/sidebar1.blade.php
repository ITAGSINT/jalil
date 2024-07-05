<nav class="sidebar sidebar-offcanvas" id="sidebar" >
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a onclick="sidebar_fun()"><span class="nav-link" style="    text-align: left;font-size: 30px;"><span class="menu-icon"><i class="menue_icon mdi mdi-menu-open"></i></span></span></a>
      <a class="sidebar-brand brand-logo" href="/dashboard"> <img class="" src="{{asset('assets/images_d/logo.png')}}" alt=""></a>
      <a class="sidebar-brand brand-logo-mini" href="/dashboard"></a>
    </div>
    <ul class="nav" style="       padding-bottom: 30px;padding-left: 5px;">
     
     
      
     
      <li class="nav-item menu-items {{Request::is('*dashboard')?'active':''}}" >
        <a class="nav-link" href="{{ route('dashboard.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">{{ __('dashboard/sidebar.dashboard') }}  </span>
        </a>
      </li>
     
      <li class="nav-item menu-items {{Request::is('*/clients')?'active':''}}" style="display:none">
        <a class="nav-link" href="{{ route('dashboard.clients') }}">
          <span class="menu-icon">
            <i class="mdi mdi-account"></i>
          </span>
          <span class="menu-title"> {{ __('dashboard/sidebar.clients') }}   </span>
        </a>
      </li>
      <li class="nav-item menu-items  {{Request::is('*dashboard/orders*')?'active':''}}">
        <a class="nav-link" href="{{ route('dashboard.orders.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-cart"></i>
          </span>
          <span class="menu-title"> {{ __('dashboard/sidebar.orders') }}  </span>
        </a>
      </li>

      <li class="nav-item menu-items {{Request::is('*dashboard/categories*')?'active':''}}">
        <a class="nav-link" href="{{ route('dashboard.categories.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-file-document-box"></i>
          </span>
          <span class="menu-title">  {{ __('dashboard/sidebar.categories') }} </span>
        </a>
      </li>

      <li class="nav-item menu-items {{Request::is('*dashboard/products*')?'active':''}}">
        <a class="nav-link" href="{{ route('dashboard.products.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-tshirt-v"></i>
          </span>
          <span class="menu-title"> {{ __('dashboard/sidebar.products') }}  </span>
        </a>
      </li>
        <li class="nav-item menu-items {{Request::is('*dashboard/color_size*')?'active':''}}">
        <a class="nav-link" href="{{ route('dashboard.color_size.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-auto-fix"></i>
          </span>
          <span class="menu-title"> {{ __('dashboard/sidebar.colors') }}  </span>
        </a>
      </li>

     <!-- <li class="nav-item menu-items"    >
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-icon">
           
            <i class="mdi mdi-playlist-play"></i>
          </span>
          <span class="menu-title"> الصفحات الفرعية </span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="sub-page-main.html"> الرئيسية</a></li>
            <li class="nav-item"> <a class="nav-link" href="sub-page-main.html"> بطاقتي</a></li>
            <li class="nav-item"> <a class="nav-link" href="sub-page-main.html"> المتجر</a></li>
          </ul>
        </div>
      </li>

     
      <li class="nav-item menu-items">
        <a class="nav-link" href="synch.html">
          <span class="menu-icon">
            <i class="mdi mdi-monitor"></i>
          </span>
          <span class="menu-title"> التقييم </span>
        </a>
      </li>-->

      <li class="nav-item menu-items {{Request::is('*dashboard/users')?'active':''}}">
        <a class="nav-link" href="{{ route('dashboard.users.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-account-multiple"></i>
          </span>
          <span class="menu-title"> {{ __('dashboard/sidebar.admins') }} </span>
        </a>
      </li>
     
     
      <li class="nav-item menu-items {{Request::is('*/reports')?'active':''}}" style="display:none">
        <a class="nav-link" href="/reports">
          <span class="menu-icon">
            <i class="mdi mdi-chart-bar"></i>
          </span>
          <span class="menu-title">{{ __('dashboard/sidebar.reports') }} </span>
        </a>
      </li>
      
    <li class="nav-item menu-items {{Request::is('*/reviews/*')?'active':''}} ">
        <a class="nav-link" href="{{ route('dashboard.reviews') }}">
          <span class="menu-icon">
            <i class="mdi mdi-star"></i>
          </span>
          <span class="menu-title">{{ __('dashboard/sidebar.customer_reviews') }} </span>
        </a>
      </li>
      <li class="nav-item menu-items {{Request::is('*dashboard/point_of_sale')?'active':''}} ">
        <a class="nav-link" href="{{ route('dashboard.point_of_sale') }}">
          <span class="menu-icon">
            <i class="mdi mdi-point-of-sale"></i>
          </span>
          <span class="menu-title">{{ __('dashboard/sidebar.point_of_sale') }} </span>
        </a>
      </li>
      <li class="nav-item menu-items {{Request::is('*dashboard/stores')?'active':''}} ">
        <a class="nav-link" href="{{ route('dashboard.stores') }}">
          <span class="menu-icon">
            <i class="mdi mdi-store"></i>
          </span>
          <span class="menu-title">{{ __('dashboard/sidebar.stores') }} </span>
        </a>
        
        
      </li>
      <li class="nav-item menu-items {{Request::is('*dashboard/finance')?'active':''}} ">
        <a class="nav-link" href="{{ route('dashboard.finance.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-finance"></i>
          </span>
          <span class="menu-title">Finance </span>
        </a>
        
        
      </li>
      
      
     
    </ul>
  </nav>
  <script>
  function show_sun(){
      $('#stores_sun').show()
  }
      function sidebar_fun(){
          if( $('.sidebar').hasClass('active')){$('.sidebar').removeClass('active');
              $('.sidebar').css('width','244px');
         $('.menu-title').show();
         $('.sidebar .nav .nav-item .menu-icon').css('margin-right','0.8rem');
         $('.sidebar .nav .nav-item .nav-link').css('padding','0.8rem 10px 0.8rem 0.5rem');
         $('.page-body-wrapper').css('width','calc(100% - 244px)');
         $('.nav').css('padding-left','10px');
         $('.menue_icon').addClass('mdi-menu-open');
         $('.menue_icon').removeClass('mdi-menu');
          }
          else{
              $('.sidebar').addClass('active');
         $('.sidebar').css('width','60px');
         $('.menu-title').hide();
         $('.sidebar .nav .nav-item .menu-icon').css('margin-right','0px');
         $('.sidebar .nav .nav-item .nav-link').css('padding','0.8rem 10px 0.8rem');
         $('.page-body-wrapper').css('width','calc(100% - 60px)');
         $('.nav').css('padding-left','5px');
         $('.menue_icon').addClass('mdi-menu');
         $('.menue_icon').removeClass('mdi-menu-open');
          }
      }
  </script>