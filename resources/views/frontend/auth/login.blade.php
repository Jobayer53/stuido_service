





<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
       <title>লগইন </title>
    <!-- Favicon icon -->
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png"> --}}
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="{{asset('frontend/css/style.css')}}" rel="stylesheet">

</head>

<body class="h-100">

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





    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="javascript:void(0);"> <h4>লগইন</h4></a>


                                  <form id="formAuthentication" class="mb-3" action="{{route('user_login')}}" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="email" class="form-label">ইমেইল</label>
                  <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    placeholder="example@gmail.com"
                    autofocus
                    value="{{ old('email') }}"
                  />
                  @error('email')
                  <span class="text text-danger">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">পাসওয়ার্ড
                    </label>
                    {{-- <a href="auth-forgot-password-basic.html">
                      <small>Forgot Password?</small>
                    </a> --}}
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control @error('password') is-invalid @enderror "
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />

                  </div>
                    @error('password')
                  <span class="text text-danger">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                {{-- <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                </div> --}}
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">লগইন</button>
                </div>
              </form>

              <p class="text-center">
                <span>একাউন্ট নেই?</span>
                <a href="{{route('register')}}">
                  <span>নতুন একাউন্ট খুলুন</span>
                </a>
              </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('frontend/plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('frontend/js/custom.min.js') }}"></script>
    {{-- <script src="{{ asset('frontend/js/settings.js') }}"></script>
    <script src="{{ asset('frontend/js/gleek.js') }}"></script>
    <script src="{{ asset('frontend/js/styleSwitcher.js') }}"></script> --}}
</body>
</html>





