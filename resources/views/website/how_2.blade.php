@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/no.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/register.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/how.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">

 
@endsection
@section('content')
<div class="container pt-5 pb-5">
    <div class="row w-100">

      <div class="col-12 pt-3">
        <div class="track position-relative">
          <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-start" style="background:#ffffff; border-radius: 24px;box-shadow: 0px 12px 16px -4px #1018281A;
              ">
            <div class="container">
              <div class="row">
                <div class="col-lg-4 col-md-12 pt-3">
                  <p class="texttrack pb-0 px-3">How Jalil works ?</p>
                  <p class="get px-3">Jalil Does<span style="color: #FF00007A;font-size: 1.5rem; font-weight: 600;">
                      NOT</span> deduct any money, Until the service is done, Money will be in holding only</p>
                  <p class="because  px-3">Because we care<br> <q>JALIL delivers excellence always!</q></p>
                </div>
                <div class="col-lg-4 col-md-12 d-flex align-items-center justify-content-center">
                  <img src="{{asset('image/addressespic.png')}}" class="imtrack ">
                </div>
                <div class="col-lg-4 col-md-12 ">
                  <div class="container text-center">
                    <p class="three">2</p>
                    <div class="row w-100 ">
                      <div class="col-4 ">
                        <hr class="hrone">
                      </div>
                      <div class="col-4 ">
                        <hr class="hrone">
                      </div>
                      <div class="col-4 ">
                        <hr class="hrthree">
                      </div>
                    </div>
                    <a class="btn how-btn" href="{{route('website.how3')}}">I understand no money will be deducted</a>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('additional_scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>

  <!-- Template Javascript -->
  <script src="{{URL::asset('js/script.js') }}"></script>
  <script src="{{URL::asset('js/changetwo.js') }}"></script>
@endsection