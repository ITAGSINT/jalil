@extends('layouts.website.main')
@section('additional_styles')
<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;800&display=swap" rel="stylesheet"> 
     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCSt4ABayMg8O3n9Hvxb_vrs_1oUfWXuA&libraries=places&language=ar-SA"></script>
<style>
    .contact-text {
    color: #8E8E8E;
    font-size: 14px !important;
}
    
    .contact  input,textarea{
        
        border-radius: 17px!important;

    }
    
    .contact input::placeholder ,.contact textarea::placeholder{
        opacity: 1;
        color:#B4B4B4;

    }
  
    .cont-info div{
        display:flex;
    }
    .icon_span{
        width: 35px;
    margin-top: 4px;
    margin-left: 0;
    height: 34px;
    background-color: #ffffff82;
    border-radius: 50%;
    border: 1.4px solid #9B9B9B;
    display: flex;
    align-items: center;
    justify-content: center;
    }
    
</style>
@endsection
@section('content')



    <div class="hero-wrap hero-bread" style="background-image: url({{asset('/assets/images_site/image_2.jpg')}});">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>About</span></p>
            <h1 class="mb-0 bread">About Us</h1>
          </div>
        </div>
      </div>
    </div>


   <section class="ftco-section ftco-no-pb ftco-no-pt  m-5">
			<div class="container">
				<div class="row">
					<div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url({{asset('/assets/images_site/about.jpg')}});height: 95vh;border-radius: 15px;">
						<a href="https://vimeo.com/45830194" class="icon popup-vimeo d-flex justify-content-center align-items-center">
							<span class="icon-play"></span>
						</a>
					</div>
					<div class="col-md-7 py-5 wrap-about pb-md-5 ftco-animate">
	          <div class="heading-section-bold mb-4 mt-md-5">
	          	<div class="ml-md-0">
		            <h2 class="mb-4">Better Way to Ship Your Products</h2>
	            </div>
	          </div>
	          <div class="pb-md-5">
							<p>But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
							<div class="row ftco-services">
			          <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
			            <div class="media block-6 services">
			                <img class="icon d-flex justify-content-center align-items-center mb-4" style="width:60%" src="{{asset('/assets/images_site/icon_home1.png')}}">
			              <div class="media-body">
			                <h3 class="heading">Refund Policy</h3>
			              </div>
			            </div>      
			          </div>
			          <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
			            <div class="media block-6 services">
			              <img class="icon d-flex justify-content-center align-items-center mb-4" style="width:60%" src="{{asset('/assets/images_site/icon_home2.png')}}">
			              <div class="media-body">
			                <h3 class="heading">Premium Packaging</h3>
			              </div>
			            </div>    
			          </div>
			          <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
			            <div class="media block-6 services">
			              <img class="icon d-flex justify-content-center align-items-center mb-4" style="width:60%" src="{{asset('/assets/images_site/icon_home3.png')}}">
			              <div class="media-body">
			                <h3 class="heading">Superior Quality</h3>
			              </div>
			            </div>      
			          </div>
			        </div>
						</div>
					</div>
				</div>
			</div>
		</section>

 
    
  

@endsection
@section('additional_scripts')
<script src="{{asset('assets/js/google_map.js')}}"></script>
@endsection