<div class="container navcontainer">
    <nav class="navbar ">
        <div class="container-fluid navtop">
            <a class="navbar-brand jalil" href="{{ route('website.index') }}"><img
                    src="{{ asset('image/Union.png') }}"></a>
            {{--  <a class="navbar-brand jalil" href="{{route('website.index')}}">JALIL</a> --}}
            <button class="navbar-toggler hamburger" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon hamburgericon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">JALIL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        @auth
                        @else
                            <li class="nav-item">
                                <a class="nav-link active login" aria-current="page" href="{{ route('login') }}"><i
                                        class="fa-regular fa-circle-user "></i>Login / Register<i
                                        class="fa-solid fa-chevron-right logright"></i></a>
                            </li>
                        @endauth

                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle login" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-circle-question"></i> Emergency Contact<i
                                    class="fa-solid fa-chevron-down contactright"></i>
                            </a>
                            <ul class="dropdown-menu" style="border:none;">
                                <div class="row w-100">
                                    <div class="col-5 mx-auto" style="background-color: #F8F9FA; border-radius: 12px;">


                                        <li class=" d-grid  "><a class="dropdown-item " href="#"><img
                                                    src="{{ asset('image/fluent_person-support-28-filled.png') }}"
                                                    class="mx-auto p-4 pt-0 pb-0">
                                                <p class="talknav p-2 pt-4"> Talk to our <span class="p-2">
                                                        experts</span></p>
                                            </a></li>
                                    </div>
                                    <div class="col-5 mx-auto" style="background-color: #F8F9FA; border-radius: 12px;">
                                        <li class=" d-grid "><a class="dropdown-item " href="#"><a
                                                    href="https://wa.me/phonenumber?text=Hi!%20I%20have%20a%20question%20about..."
                                                    class="float " target="_blank">
                                                    <img src="{{ asset('image/WhatsApp_icon.png') }}"
                                                        class="mx-2 p-4 pt-0 pb-0">
                                                </a>
                                                <p class="talknav chatnav p-2"> Chat with us<span>
                                                        on Whatsapp</span> </p>
                                            </a></li>
                                    </div>
                                </div>
                            </ul>
                        </li>
                        @auth


                            <li class="nav-item order">
                                <a class="nav-link active login" aria-current="page" href="#"><img
                                        src="{{ asset('image/clipboard.png') }}" class="imgclip">Order History<i
                                        class="fa-solid fa-chevron-right orderright"></i></a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link active login" aria-current="page" href="#"><img
                                        src="{{ asset('image/invoice.png') }}" class="imgclip">Statements<i
                                        class="fa-solid fa-chevron-right stateright"></i></a>
                            </li>
                        @endauth


                        <li class="nav-item">
                            <a class="nav-link active login" aria-current="page"href="{{ route('website.terms') }}"><img
                                    src="{{ asset('image/receipt-alt.png') }}" class="imgclip">Terms & Conditions<i
                                    class="fa-solid fa-chevron-right termright"></i></a>
                        </li>

                        @auth
                        <li class="nav-item">
                            <a class="nav-link active login" aria-current="page" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">


                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
  <img src="{{ asset('image/log-out.png') }}" class="imgclip">Sign out<i  class="fa-solid fa-chevron-right signright"></i></a>
{{--
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div> --}}
                        </li>     @endauth
                    </ul>

                </div>
            </div>
        </div>
    </nav>
</div>
