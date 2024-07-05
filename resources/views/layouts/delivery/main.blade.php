<!DOCTYPE html>
<html lang="en">
  <head>
    @include('layouts.delivery.partials.head')
  </head>


  <body>
    <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
	  <!-- partial:partials/_navbar -->
        @include('layouts.delivery.partials.navbar')
        <!-- partial -->
      <!-- partial:partials/_sidebar -->
      @include('layouts.delivery.partials.sidebar')
      <!-- partial -->
      <!-- Main Content -->
      <div class="main-content">
                @yield('content')
        </div>   
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer -->
          @include('layouts.delivery.partials.footer')
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
     </div>
  </div>
    

    @include('layouts.delivery.partials.scripts')





  </body>
</html>