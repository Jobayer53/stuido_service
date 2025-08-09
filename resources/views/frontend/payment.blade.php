@extends('frontend.layout.frontend_app')
@section('content')
    {{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> অ্যাকাউন্ট সেটিংস </h4> --}}

    <div class="row p-2 mb-5">
        <div class="col-lg-6 m-auto mt-3 ">

            <div class="card mb-4">
                <h5 class="card-header text-center">রিচার্জ করুন মাত্র এক ক্লিকে </h5>

                <hr class="my-0" />
                <div class="card-body ">
                    <form action="{{route('payment_store')}}" method="POST">
                        @csrf
                        <div class="mb-3 text-center">
                            <label for="" class="form-label ">টাকার পরিমান লিখুন।</label>
                            <input type="number" min="50" class="form-control form-control-sm" name="amount" id="amount" required="50" placeholder="50">
                        </div>
                        <div class="mb-3 text-center">
                           <button type="submit" class="btn btn-primary btn-sm ">পে করুন</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>

        </div>
    </div>
@endsection
