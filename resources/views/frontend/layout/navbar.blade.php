<!-- / Navbar -->
<!--**********************************
            Nav header start
        ***********************************-->
<div class="nav-header">
    <div class="brand-logo">
        <a href="index.html">
            <b class="logo-abbr"><img src="images/logo.png" alt=""> </b>
            <span class="logo-compact"><img src="./images/logo-compact.png" alt=""></span>
            <span class="brand-title">
                <img src="images/logo-text.png" alt="">
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
                    <a href="javascript:void(0)" class="mb-1">
                        <span class="btn btn-outline-primary">{{ number_format(auth()->user()->amount, 0) }}৳</span>
                        {{-- <span class="badge badge-pill gradient-2">3</span> --}}
                    </a>

                </li>
                <li class="icons dropdown">
                    <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                        <span class="activity active"></span>
                        <img src="{{asset('frontend/images/user/1.png')}}" height="40" width="40" alt="">
                    </div>
                    <div class="drop-down dropdown-profile   dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li><a href="{{ route('user_setting') }}"><i class="icon-key"></i>
                                        <span>সেটিংস</span></a></li>
                                <li><a href="{{ route('user_payment') }}"><i class="icon-key"></i>
                                        <span></span>রিচার্জ</a></li>
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
