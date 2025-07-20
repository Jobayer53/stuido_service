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
    @include('frontend.layout.floating_text')
    <div class="row mt-3 ">
        <div class="col-lg-8 m-auto ">
            @if ($available)
                <div class="card">
                    <h5 class="card-header text-center">বায়োমেট্রিক</h5>
                    <div class="card-body">
                        <form action="{{ route('order_biometric') }}" method="POST" id="biometric_form">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Select Option:</label>
                                <div class="mb-3 row d-flex justify-content-around">
                                    @if ($robi_airtel->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer robi_airtel"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="robi_airtel" class="cursor-pointer robi_airtel"> রবি/এয়ারটেল বায়োমেট্রিক (<span
                                                    class="text-danger">{{ number_format($robi_airtel->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($banglalink->available == 1)
                                        <div class="col-5 border mb-3">
                                            <label class="radio-inline mb-0 cursor-pointer blnlk"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="banglalink" class="cursor-pointer blnlk"> বাংলালিংক বায়োমেট্রিক (<span
                                                    class="text-danger">{{ number_format($banglalink->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($teletalk->available == 1)
                                        <div class="col-5 border mb-3">
                                            <label class="radio-inline mb-0 cursor-pointer tltlk"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="teletalk" class="cursor-pointer tltlk"> টেলিটক বায়োমেট্রিক (<span
                                                    class="text-danger">{{ number_format($teletalk->cost, 0) }}</span>TK)</label>
                                        </div>
                                    @endif
                                    @if ($grameenphone->available == 1)
                                        <div class="col-5 border mb-3">
                                            <label class="radio-inline mb-0 cursor-pointer grmphn"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="grameenphone" class="cursor-pointer grmphn"> গ্রামিণফোন বায়োমেট্রিক (<span
                                                    class="text-danger">{{ number_format($grameenphone->cost, 0) }}</span>TK)</label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">

                                    <input type="text" name="type_number" id="number" class="form-control form-control-sm" placeholder="অপশন সিলেক্ট করুন" required>
                            </div>


                            <div class=" text-center">
                                <button class="btn btn-primary btn-sm " type="submit" id="orderBtn">ওর্ডার করুন</button>
                            </div>

                        </form>
                    </div>
                </div>
            @else
                <div class="card">
                    <h5 class="card-header text-center mb-4">বায়োমেট্রিক </h5>
                    <div class="card-body ">
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
    <div class="row mt-3 p-2">
        <div class="col-lg-12">
            <div class="card">
                <h5 class="card-header">ওর্ডার সমূহ</h5>
                <div class="table-responsive ">
                    <table class="table table-hover">
                        <thead>
                            <th>#</th>
                            <th>স্লাগ আইডি</th>
                            <th>তথ্য</th>
                            <th>চার্জ</th>
                            <th>সময়</th>
                            <th>স্ট্যাটাস</th>
                            <th>ডাউনলোড</th>
                            {{-- <th>একশন</th> --}}
                            </tr>
                        </thead>
                        <tbody class="">
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->slug }}</td>
                                    <td class="d-flex flex-column">
                                        <span>Type: <strong>{{ $order->type }}</strong></span>
                                        <span>Number: <strong>{{ $order->type_number }}</strong></span>
                                    </td>
                                    <td>
                                        @if ($order->status == 'cancelled')
                                            <del>
                                                {{ $order->cost }}
                                            </del>
                                        @else
                                            {{ $order->cost }}
                                        @endif

                                    </td>
                                    <td title="{{ $order->created_at->format('F j, g:i a') }}">
                                        {{ $order->created_at->diffForHumans() }}
                                    </td>
                                    <td title="Pending->Received->Completed">
                                        <span class="label rounded gradient-1 me-1">
                                            {{ $order->status }}
                                        </span>

                                    </td>
                                    <td>
                                        @if ($order->status == 'completed' )
                                             <button class="btn ml-2  btn-rounded btn-info data editBtn " data-toggle="modal"
                                                data-target="#editModal" data-data="{{ $order }}">
                                                <i class="fa fa-download color-light"></i>
                                                তথ্য দেখুন
                                            </button>
                                        @endif
                                    </td>



                                    {{-- <td>
                                       <div class="dropdown custom-dropdown">
                                            <button class="btn btn-sm btn-light " data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <p class="dropdown-item m-0 " >স্লাগঃ {{ $order->slug }}</p>
                                                @if ($order->status !== 'cancelled' && $order->status !== 'completed')
                                                <a class="dropdown-item border-top" href="{{route('order_cancel', $order->id)}}" onclick="return confirm('আপনি কি নিশ্চিত যে আপনি এই অর্ডারটি বাতিল করতে চান?')">অর্ডার বাতিল</a>
                                                @endif
                                                 <a class="dropdown-item" href="#">Option 3</a>
                                            </div>
                                        </div>
                                    </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center py-3" colspan="6">কোনো ডাটা পাওয়া যায়নি</td>

                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                 {{ $orders->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
     <!-- Modal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                    <button type="button" class="close" data-dismiss="modal" ><i class="fa fa-close"></i></button>
                </div>
                <div class="modal-body">
                    <textarea name="" id="data" cols="30" rows="5" class="form-control" readonly></textarea>
                </div>
                  <div class="modal-footer  ">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        {{-- <button type="submit" class="btn btn-primary">Update</button> --}}
      </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#biometric_form').on('submit', function(e) {
                const $btn = $('#orderBtn');

                $btn.text('অপেক্ষা করুন...');
                $btn.prop('disabled', true);
            });
            $('.robi_airtel').on('click', function(e) {
                var text = $('#number').attr('placeholder', '018XXXXXXXX');
            });
            $('.blnlk').on('click', function(e) {
                var text = $('#number').attr('placeholder', '019XXXXXXXX');
            });
            $('.tltlk').on('click', function(e) {
                var text = $('#number').attr('placeholder', '015XXXXXXXX');
            });
            $('.grmphn').on('click', function(e) {
                var text = $('#number').attr('placeholder', '017XXXXXXXX');
            });
              $('.editBtn').on('click', function() {
                var data = $(this).data('data');
                $('#data').val(data.downloaded_info);

            });
        });
    </script>
@endsection
