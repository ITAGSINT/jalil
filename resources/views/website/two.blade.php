@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/two.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container" >
        <p class="toptext"> Don’t worry this is going to be fast!</p>
    </div>
 <div class="container">
      <div class="row w-100 d-flex align-items-center justify-content-center">
        <div class="col-lg-6 col-md-12 d-grid align-items-center justify-content-center p-3" style="background-color: #ffffff; border-radius: 2.25rem;">
           <p class="text-center">Do you know the size of the battery you are looking for ?</p>  
           <div class="row w-100 pt-5">
            <div class="col-md-6 col-sm-12 pt-2">
              <a class="container btn yes" href="{{route('website.yes')}}"  role="button" >
                <p class="textyes">YES</p>
                <p class="textplease">Please let me choose the size to bring</p>
              </a>
            </div>
            <div class="col-md-6 col-sm-12 pt-2">
              <a class="container btn yes" href="{{route('website.no')}}"  role="button" >
                <p class="textyes">NO</p>
                <p class="textplease">Please bring the right battery for me</p>
              </a>
            </div>
           </div>
        </div>
      </div>
    </div>
@endsection