<!DOCTYPE html>
<html lang="en">
  <head>
    @include('layouts.ecommerce.partials.head')
  </head>


  <body>
    <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
	  <!-- partial:partials/_navbar -->
        @include('layouts.ecommerce.partials.navbar')
        <!-- partial -->
      <!-- partial:partials/_sidebar -->
      @include('layouts.ecommerce.partials.sidebar')
      <!-- partial -->
      <!-- Main Content -->
      <div class="main-content">
                @yield('content')
        </div>   
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer -->
          @include('layouts.ecommerce.partials.footer')
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
     </div>
  </div>
    

    @include('layouts.ecommerce.partials.scripts')





  </body>
</html>