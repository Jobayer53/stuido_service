@extends('frontend.layout.frontend_app')
@section('content')
    {{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> অ্যাকাউন্ট সেটিংস </h4> --}}

    <div class="row p-2 mb-5">
        <div class="col-lg-12 mb-5 ">
            {{-- <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> অ্যাকাউন্ট </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="pages-account-settings-notifications.html"
                        ><i class="bx bx-bell me-1"></i> </a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="pages-account-settings-connections.html"
                        ><i class="bx bx-link-alt me-1"></i> Connections</a
                      >
                    </li>
                  </ul> --}}
            <div class="card mb-4">
                <h5 class="card-header">প্রোফাইলের বিবরণ</h5>
                <!-- Account -->
                {{-- <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img
                          src="../assets/img/avatars/1.png"
                          alt="user-avatar"
                          class="d-block rounded"
                          height="100"
                          width="100"
                          id="uploadedAvatar"
                        />
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input
                              type="file"
                              id="upload"
                              class="account-file-input"
                              hidden
                              accept="image/png, image/jpeg"
                            />
                          </label>
                          <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>

                          <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                        </div>
                      </div>
                    </div> --}}
                <hr class="my-0" />
                <div class="card-body">
                    <form id="formAccountSettings" method="POST" action="{{ route('user_update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3 ">
                                    <label for="firstName" class="form-label">নাম</label>
                                    <input class="form-control" type="text" id="firstName" name="name"
                                        value="{{ auth()->user()->name }}" autofocus />
                                </div>
                                <div class="mb-3 ">
                                    <label for="email" class="form-label">ইমেইল</label>
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="{{ auth()->user()->email }}" readonly />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="number" class="form-label">ফোন নম্বর</label>
                                    <input type="number" class="form-control" id="number" name="number"
                                        value="{{ auth()->user()->number }}" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 ">
                                    <label for="oldPassword" class="form-label">পুরাতন পাসওয়ার্ড</label>
                                    <input class="form-control" type="text" id="oldPassword" name="old_password"
                                        autofocus />
                                </div>
                                <div class="mb-3 ">
                                    <label for="newPassword" class="form-label">নতুন পাসওয়ার্ড</label>
                                    <input class="form-control" type="text" id="newPassword" name="new_password"
                                        autofocus />
                                </div>




                            </div>


                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2 float-right">সেভ করুন</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>

        </div>
    </div>
@endsection
