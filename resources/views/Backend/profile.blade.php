@extends('Backend.layout.backend_app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6  ">
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->

                <hr class="my-0" />
                <div class="card-body">
                    <form id="formAccountSettings" method="POST" action="{{ route('admin_update') }}">
                        @csrf

                        <div class="mb-3 ">
                            <label for="name" class="form-label">Name</label>
                            <input class="form-control" type="text" id="name" name="name"
                                value="{{ auth()->guard('admin')->user()->name }}"  />
                        </div>
                        <div class="mb-3 ">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control" type="text" id="email" name="email"
                                value="{{ auth()->guard('admin')->user()->email }}"  />
                        </div>



                        <div class="mb-3 ">
                            <label for="oldPassword" class="form-label">Old Password</label>
                            <input class="form-control" type="text" id="oldPassword" name="old_password" autofocus />
                        </div>
                        <div class="mb-3 ">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input class="form-control" type="text" id="newPassword" name="new_password" autofocus />
                        </div>




                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2 float-end">Update</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>

        </div>
    </div>
@endsection
