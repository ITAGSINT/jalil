@extends('layouts.website.main')
@section('additional_styles')
<style>
    .row {
    --bs-gutter-x: 0 !important;
    --bs-gutter-y: 0;}
    .emptyspace {
    height: 10px !important;
}
.select_size {
    border: 0;
    background: #9a9a9a;
    color: white;
    font-weight: lighter !important;
    padding: 5px 28px;
    letter-spacing: 3px;
    /* margin-top: -7px; */
    border-radius: 30px;
}
</style>
  <style>

  .beep {
    position: relative;
}
  .beep:after {
    content: '';
    position: absolute;
        top: 3px;
    right: -23px;
    width: 15px;
    height: 15px;
    background-color: #c2b6ff;
    border-radius: 50%;
    -webkit-animation: pulsate 1s ease-out;
    animation: pulsate 1s ease-out;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    opacity: 1;
}
  .ftco-navbar-light .nav-item.cta > span {
    color: #fff !important;
    background: #c2b6ff;
    border: none !important;
}
  .ftco-navbar-light .nav-item.cta > a {
    color: #fff !important;
    background: #c2b6ff;
    border: none !important;
}
  .ftco-navbar-light .navbar-nav > .nav-item > .nav-link{color:white;    height: 100%;}
  .ftco-navbar-light {
    background: #00000054 !important;
    z-index: 3;
    padding: 0;
}
      .ftco-section {
    padding: 7em 0 4em !important;
    position: relative;
}
/* 4.5 Animation */
.pulsate {
  -webkit-animation: pulsate 1s ease-out;
          animation: pulsate 1s ease-out;
  -webkit-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
  opacity: 1; }

@-webkit-keyframes pulsate {
  0% {
    -webkit-transform: scale(0.1, 0.1);
    opacity: 0.0; }
  50% {
    opacity: 1.0; }
  100% {
    -webkit-transform: scale(1.2, 1.2);
    opacity: 0.0; } }

  </style>
@endsection

@section('content')
<div class="bag pt-5 pb-5" style="    ">

    <div class="row" style="width:100%" >
        <div class="col-sm-1"></div>
       
            <div class="col-sm-1"></div>
        </div>
    <div class="row" style="width: 100%;padding: 60px 0;margin: 0;">
       <div class="col-sm-4"></div> 
        <div class="col-sm-4" style="    display: flex;flex-direction: column;align-items: center;">
            <img  src="{{asset('/assets/img/Group 210.png')}}" style="width: 130px;">
            <h5 style="color:#8E8E8E;font-size: 21px;margin: 0;padding: 15px 0;">Your bag is empty</h5>
            <button class="btn btn-white" onclick="location.href='/shop/all'" style="">Continue shopping</button>
        </div> 
         <div class="col-sm-4"></div> 
    </div>
           
    </div>
    @endsection
    