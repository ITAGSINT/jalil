<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <span>
                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    @if (LaravelLocalization::getCurrentLocale() != $localeCode)
                        @if ($localeCode == 'ar')
                            <a hreflang="en"
                                href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}"><span
                                    class="flag-icon flag-icon-gb activ_lang"></span></a>
                            <a hreflang="ar"
                                href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}"><span
                                    class="flag-icon flag-icon-sy not_activ_lang  "></span></a>
                        @endif
                        @if ($localeCode == 'en')
                            <a hreflang="en"
                                href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}"><span
                                    class="flag-icon flag-icon-gb not_activ_lang "></span></a>
                            <a hreflang="ar"
                                href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}"><span
                                    class="flag-icon flag-icon-sy  activ_lang"></span></a>
                        @endif
                    @endif
                @endforeach
            </span>
        </ul>

    </form>

    <ul class="navbar-nav navbar-right">


        <li class=" dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell"></i>
                <span class="notification"
                    id="notification_id2">{{ $notifications->where('read_at', null)->count() }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right shadow border" aria-labelledby="notifDropdown">
                <li>
                    <div class="dropdown-title">You Have
                        {{ $notifications->where('read_at', null)->count() }} New Notifications
                    </div>
                </li>
                <li>
                    <div class="notif-scroll scrollbar-outer">
                        <div class="" id='notif_center_id2'>
                            @foreach ($notifications as $m)
                                <a href=" @if ($m->read_at == null) {{ route('update-notufu', ['id' => $m->id]) }} @else {{ $m->action }} @endif " style="  ">
                                    {{-- <div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i>
                                    </div> --}}
                                    <div class=" px-3 border-top @if ($m->read_at == null) bg-light @endif">
                                        <p class=" m-0 text-title">
                                            @php
                                                $p = json_decode($m->data);
                                            @endphp
                                            {{ $p->title }}
                                        </p>
                                        <p class="m-0 text-info"> {{ $p->body }}</p>
                                        <small class=" text-time">{{ $m->date1 }}</small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </li>

            </ul>
        </li>

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('assets/images_d/avatar/avatar-1.png') }}"
                    class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{ __('dashboard/sidebar.hi') }}, {{ Auth::user()->name }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title"></div>
                <a href="{{ route('profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{ __('dashboard/sidebar.profile') }}
                </a>


                <div class="dropdown-divider"></div>
                <a onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                    class="dropdown-item has-icon text-danger">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <i class="fas fa-sign-out-alt"></i> {{ __('dashboard/sidebar.logout') }}
                </a>
            </div>
        </li>
    </ul>
</nav>
