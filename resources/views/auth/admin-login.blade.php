@extends('layouts.website.main')
@section('additional_styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css_site/pay.css') }}">
    <style>
        .alert.alert-error {
            background: var(--danger);
            color: white;
        }

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

        .ftco-navbar-light .nav-item.cta>span {
            color: #fff !important;
            background: #c2b6ff;
            border: none !important;
        }

        .ftco-navbar-light .nav-item.cta>a {
            color: #fff !important;
            background: #c2b6ff;
            border: none !important;
        }

        .ftco-navbar-light .navbar-nav>.nav-item>.nav-link {
            color: white;
            height: 100%;
        }

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
            opacity: 1;
        }

        @-webkit-keyframes pulsate {
            0% {
                -webkit-transform: scale(0.1, 0.1);
                opacity: 0.0;
            }

            50% {
                opacity: 1.0;
            }

            100% {
                -webkit-transform: scale(1.2, 1.2);
                opacity: 0.0;
            }
        }
    </style>
    <style>
        label {
            color: #aeacad;
        }

        .row {
            --bs-gutter-x: 0 !important;
            --bs-gutter-y: 0;
        }

        .emptyspace {
            height: 10px !important;
        }

        .product_card h5 {
            font-size: 18px !important;
        }

        ::placeholder {
            color: #7e7c7da1 !important;
            opacity: 1;
            /* Firefox */
        }

        :-ms-input-placeholder {
            /* Internet Explorer 10-11 */
            color: #7e7c7da1 !important;
        }

        ::-ms-input-placeholder {
            /* Microsoft Edge */
            color: #7e7c7da1 !important;
        }
    </style>
@endsection

@section('content')
    <div class="checkout mb-5">

        <div class="row m-0" style="padding-top: 80px;width:100%">
            <div class="col-sm-4 p-0"></div>
            <div class="col-sm-4  p-sm-0 p-4">
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <div class="form-group">
                        <p style="  color: #676767;font-size: 23px !important;font-weight: bold !important;">Login</p>
                    </div>



                    <div class="form-group">
                        <label>Email</label>
                        <input id="email" type="email"
                            class=" form-control mt-1  contact-text @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" placeholder="E-mail" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input id="password" type="password"
                            class="form-control mt-1 @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 ">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-white"
                            style="    padding: 5px 24px;letter-spacing: 1px; width:100%">Login</button>
                    </div>

                    <p class="sign-up " style="    color: #676767;padding-top: 8px;">Already have an Account?<a
                            href="{{ route('register') }}"> Sign Up</a></p>





                </form>
            </div>

            <div class="col-sm-4"></div>

        </div>

    </div>
@endsection
