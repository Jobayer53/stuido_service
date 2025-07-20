
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- theme meta -->
    {{-- <meta name="theme-name" content="quixlab" /> --}}

    <title>ড্যাশবোর্ড</title>

       @include('frontend.layout.header')
    @yield('style')

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper" style="height:100vh; overflow: hidden;">


       @include('frontend.layout.navbar')

      @include('frontend.layout.sidebar')

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body" style="height: 88%; overflow-y: scroll; overflow-x: hidden;" >

                @yield('content')

            <!-- #/ container -->
                <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer" style="padding-left: 0px !important;">
            <div class="copyright">
                <p>Copyright &copy; {{ date('Y')}} All Rights Reserved</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->



    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
        @include('frontend.layout.footer')
        @yield('script')
</body>

</html>
