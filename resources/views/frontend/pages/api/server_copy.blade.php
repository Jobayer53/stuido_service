@extends('frontend.layout.frontend_app')

@section('style')
<style>
    .text-container {
    overflow: hidden;
    position: relative;
    width: 100%;
}

.animated-text {
    /* display: inline-block; */
    /* white-space: nowrap; */
    animation: moveText 8s linear infinite;
}

@keyframes moveText {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-45%);
    }
}
</style>
@endsection

@section('content')
    {{-- @include('frontend.layout.floating_text') --}}
    <div class="row mt-3 ">
        <div class="col-lg-6 m-auto ">
            @if($server_copy->available == 1)
                <div class="card">
                    <h5 class="card-header text-center">এক ক্লিকে সার্ভার কপি ডাউনলোড</h5>
                    <div class="card-body">
                        <form action="{{route('order_api_serverCopy')}}"  method="POST" id="server_copy_form">
                            @csrf

                            <div class="mb-3">
                                <label for="" class="form-label">NID NO (10/13/17 Digit)</label>
                                <input type="text" class="form-control" name="nid" id="nid"
                                    placeholder="123567890" autofocus required value="{{ old('nid') }}">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Date Of Birth (YYYY-MM-DD)</label>
                                <input type="text" class="form-control" name="dob" id="" placeholder="2000-12-21"
                                     autofocus required>
                            </div>

                            <div class=" text-center">
                                <button class="btn btn-primary btn-sm " type="submit" id="orderBtn">ডাউনলোড</button>
                            </div>

                        </form>
                    </div>
                </div>
                  @else
                <div class="card">
                    <h5 class="card-header text-center mb-4">সার্ভার কপি</h5>
                    <div class="card-body">
                        <i class=" text-danger d-flex  justify-content-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-clock-pause">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20.942 13.018a9 9 0 1 0 -7.909 7.922" />
                                <path d="M12 7v5l2 2" />
                                <path d="M17 17v5" />
                                <path d="M21 17v5" />
                            </svg>
                        </i>
                        <p class="text-center text-danger">কাজ বন্ধ আছে!</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('script')
   <script>
     $(document).ready(function () {
       $('#server_copy_form').on('submit', function (e) {
    const $btn = $('#orderBtn');

    $btn.text('অপেক্ষা করুন...');
    $btn.prop('disabled', true);
});

    });
   </script>
@endsection
