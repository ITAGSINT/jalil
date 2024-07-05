<!-- Start Footer
<footer class="ftco-footer bg-light ftco-section">
      <div class="container">
      	<div class="row">
      		<div class="mouse">
						<a href="#" class="mouse-icon">
							<div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
						</a>
					</div>
      	</div>
        <div class="row mb-2">
          <div class="col-md-3">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Trading Market</h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-3">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Menu</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">Shop</a></li>
                <li><a href="#" class="py-2 d-block">About</a></li>
                <li><a href="#" class="py-2 d-block">Journal</a></li>
                <li><a href="#" class="py-2 d-block">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-3">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Help</h2>
              <div class="d-flex">
	              <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
	                <li><a href="#" class="py-2 d-block">Shipping Information</a></li>
	                <li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
	                <li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
	                <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
	              </ul>

	            </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+000 000 00 0 </span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@tadcenter.net</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center copy">

            <p>
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved |   by <a href="" target="_blank">TAD center</a>

						</p>
          </div>
        </div>
      </div>
    </footer>
End Footer -->
@php
    use Illuminate\Support\Str;
@endphp
 <div class="container footernav pt-5 pb-3">
    <nav class="navbar navbar-expand d-flex align-items-center justify-content-center bg-white pt-3 navbottom">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav listbottom">
                    <li class="nav-item">
                        <a class="nav-link containnav {{ request()->routeIs('website.index') ? 'active' : '' }}" aria-current="page" href="{{ route('website.index') }}">
                            <i class="bi bi-house mx-auto"></i>
                            <p>Home</p>
                        </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link containnav {{ Str::startsWith(request()->route()->getName(), 'website.orders') ? 'active' : '' }}" href="{{ route('website.orders.index') }}">
                    <i class="bi bi-clipboard-minus mx-auto"></i>
                            <p>My orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link containnav {{ Str::startsWith(request()->route()->getName(), 'website.myvehicles') ? 'active' : '' }}" href="{{ route('website.myvehicles') }}">
                            <i class="bi bi-car-front mx-auto"></i>
                            <p>My vehicles</p>
                        </a>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link containnav " >
                            <i class="bi bi-chat-right mx-auto"></i>
                            <p>Chats</p>
                        </a>
                    </li>-->
                    <li class="nav-item">
                        <a class="nav-link containnav  {{ Str::startsWith(request()->route()->getName(), 'website.myAddress') ? 'active' : '' }}" href="{{ route('website.myAddress') }}">
                            <i class="bi bi-geo-alt mx-auto"></i>
                            <p>My address</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
