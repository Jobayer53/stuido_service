<!-- / Navbar -->
<!--**********************************
            Nav header start
        ***********************************-->
<div class="nav-header">
    <div class="brand-logo">
        <a href="{{ route('user_home') }}">
            <b class="logo-abbr"><img src="{{ asset('frontend/images/logo-white.png') }}" alt="" class="img-fluid"
                    style="margin: 0px 0px;"> </b>
            <span class="logo-compact"><img src="{{ asset('frontend/images/text-white.png') }}" alt=""></span>
            <span class="brand-title">
                <img src="{{ asset('frontend/images/text-white.png') }}" alt="" class="img-fluid"
                    style="margin: -11px -8px;">
            </span>
        </a>
    </div>
</div>
<!--**********************************
            Nav header end
        ***********************************-->

<!--**********************************
            Header start
        ***********************************-->
<div class="header">
    <div class="header-content clearfix">

        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="icon-menu"></i></span>
            </div>
        </div>

        <div class="header-right">
            <ul class="clearfix">
                <li class="icons dropdown">
                    <a href="{{ route('user_payment') }}" class="mb-1">
                        <span class="btn btn-outline-primary">{{ number_format(auth()->user()->amount, 0) }}৳</span>
                        {{-- <span class="badge badge-pill gradient-2">3</span> --}}
                    </a>

                </li>
                <li class="icons dropdown">
                    <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                        <span class="activity active"></span>
                        <img src="{{ asset('frontend/images/user/form-user.png') }}" height="40" width="40"
                            alt="">
                    </div>
                    <div class="drop-down dropdown-profile   dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li><a href="{{ route('user_setting') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                                            <path
                                                d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                                            <path
                                                d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
                                        </svg>
                                        <span>সেটিংস</span></a></li>
                                <li><a href="{{ route('user_payment') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-lightning-charge" viewBox="0 0 16 16">
                                            <path
                                                d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09zM4.157 8.5H7a.5.5 0 0 1 .478.647L6.11 13.59l5.732-6.09H9a.5.5 0 0 1-.478-.647L9.89 2.41z" />
                                        </svg>
                                        <span>রিচার্জ</span></a></li>
                                <hr class="my-2">
                                <li><a href="javascript:void()"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                            class="icon-key"></i> <span>লগ আউট</span></a></li>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</div>




{{-- <ul class="clearfix">

    <li class="icons dropdown">
        <a href="javascript:void(0)" class="mb-1">
            <span class="btn btn-outline-primary     ">{{ number_format(auth()->user()->amount, 0) }}৳</span>
        </a>

    </li>


    <li class="icons dropdown">
        <div class="user-img c-pointer position-relative" data-toggle="dropdown">
            <span class="activity active"></span>
            <img src="{{ asset('frontend/images/user/1.png') }}" height="40" width="40" alt="">
        </div>
        <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
            <div class="dropdown-content-body">
                <ul>
                    <li><a href="{{ route('user_setting') }}"><i class="icon-key"></i> <span>সেটিংস</span></a></li>
                    <li><a href="{{ route('user_payment') }}"><i class="icon-key"></i> <span></span>পেমেন্ট</a></li>
                    <hr class="my-2">
                    <li><a href="javascript:void()"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="icon-key"></i> <span>লগ আউট</span></a></li>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>


                </ul>
            </div>
        </div>
    </li>
</ul> --}}
