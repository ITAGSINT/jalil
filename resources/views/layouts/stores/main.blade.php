<!DOCTYPE html>
<html lang="en">
  <head>
    @include('layouts.stores.partials.head')
  </head>


  <body>
    <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
	  <!-- partial:partials/_navbar -->
        @include('layouts.stores.partials.navbar')
        <!-- partial -->
      <!-- partial:partials/_sidebar -->
      @include('layouts.stores.partials.sidebar')
      <!-- partial -->
      <!-- Main Content -->
      <div class="main-content">
                @yield('content')
        </div>   
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer -->
          @include('layouts.stores.partials.footer')
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
     </div>
  </div>
    

    @include('layouts.stores.partials.scripts')





  </body>
</html>