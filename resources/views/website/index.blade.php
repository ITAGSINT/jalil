@extends('layouts.website.main')

@section('additional_styles')
<style>



</style>
@endsection
@section('content')







  <div class="container pt-5">
        <div class="row w-100">
            <div class="col-md-6 col-sm-12 pt-3">
                <div class="ride position-relative">
                    <img class="img-fluid im" src="{{ asset('image/Blog Image.png') }}" alt="">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-start"
                        style="background: linear-gradient(270deg, rgba(22, 51, 0, 0.48) 2.74%, rgba(22, 51, 0, 0.12) 95.94%); border-radius: 24px;box-shadow: 0px 12px 16px -4px #1018281A;
            ">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">

                                    <p class="texttop text-white  ">Your Ride, Your Pride.</p>
                                    <p class="text  mb-4 pb-2">“JALIL delivers excellence always!”
                                    </p>
                                    <a href="https://api.whatsapp.com/send?phone=1234567890" target="_blank"
                                        class="whatsapp-icon">
                                        <img src="{{ asset('image/WhatsApp_icon.png') }}">
                                    </a>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 pt-3">
                <div class="track position-relative">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-start"
                        style="background:#ffffff; border-radius: 24px;box-shadow: 0px 12px 16px -4px #1018281A;
            ">
                        <div class="container">
                            <div class="row w-100">
                                <div class="col-6 ">

                                    <p class="texttrack">Tracking your orders is now more easy!</p>
                                    <a class="btn btntrack " href="#" role="button">Check status now</a>
                                </div>
                                <div class="col-6  pt-5">
                                    <img src="{{ asset('image/Frame.png') }}" class="imtrack">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="container pt-3 ">
        <div class="row w-100">
            <div class="col-lg-4 col-md-6 col-12 pt-3">
                <a href="{{ route('website.two') }}">
                    <div class="battery position-relative">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-start"
                            style="background:#ffffff; border-radius: 24px;box-shadow: 0px 12px 16px -4px #1018281A;
          ">
                            <div class="container">

                                <div class="row w-100 pt-3">
                                    <div class="col-12 col-md-6 ">

                                        <p class="textbattery ">Change my battery</p>
                                    </div>
                                    <div class="col-4 col-md-6">
                                        <div class="state">
                                            <p class="batterystate ">Arrives in 20 mins</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="row w-100 pt-3">
                                    <div class="col-md-12 col-8">
                                        
                                        <img src="{{ asset('image/Image.png') }}" class="batteryimg">
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-lg-4 col-md-6 col-12 pt-3">
                <a  href="{{ route('website.carWash') }}">
                    <div class="battery position-relative">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-start"
                            style="background:#ffffff; border-radius: 24px;box-shadow: 0px 12px 16px -4px #1018281A;
          ">
                            <div class="container h-100">
                                <div class="row w-100 pt-3">
                                    <div class="col-12 d-grid">

                                        <p class="textwash ">Wash my car</p>

                                        <p class="letwash ">Let our car spa specialists<br> bring the shine to your ride!
                                        </p>

                                    </div>

                                </div>
                                <div class="row w-100 pt-2 h-50">
                                    <div class="col-4">
                                        <div class="stateone">
                                            <p class="washstate ">Arrives in 20 mins</p>
                                        </div>
                                    </div>
                                    <div class="col-8">

                                        <img src="{{ asset('image/Image__1_-removebg-preview.png') }}" class="washimg">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>



            <div class="col-lg-4 col-md-6 col-12 pt-3">
                <a href="{{ route('website.tyre') }}">
                    <div class="battery position-relative">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-start"
                            style="background:#ffffff; border-radius: 24px;box-shadow: 0px 12px 16px -4px #1018281A;
          ">
                            <div class="container h-100">
                                <div class="row w-100 pt-3">
                                    <div class="col-12 d-grid">

                                        <p class="textwash ">Change my tyres</p>

                                        <p class="letwash ">Upgrade all your tread at<br> your doorstep!</p>

                                    </div>

                                </div>
                                <div class="row w-100 pt-2 h-50">
                                    <div class="col-4">
                                        <div class="stateone">
                                            <p class="washstate ">Arrives in 20 mins</p>
                                        </div>
                                    </div>
                                    <div class="col-8">

                                        <img src="{{ asset('image/1-removebg-preview.png') }}" class="washimg">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>




        </div>
    </div>

@endsection