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
                    <h5 class="card-header text-center">IMEI  & NID TO ALL NUMBER</h5>
                    <div class="card-body">
                        <form action="{{ route('order_imei') }}" method="POST" id="imei_form">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Select Option:</label>
                                <div class="mb-3 row d-flex justify-content-around">
                                    @if ($imei->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer imei"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="imei_to_number" class="cursor-pointer imei"> IMEI টু এক্টিভ নাম্বার(<span
                                                    class="text-danger">{{ number_format($imei->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($nid_to_number->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer nid_to_number"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="nid_to_number" class="cursor-pointer nid_to_number"> এন আইডি টু অল নাম্বার (<span
                                                    class="text-danger">{{ number_format($nid_to_number->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($num_to_imei->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer num_to_imei"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="number_to_imei" class="cursor-pointer num_to_imei"> নাম্বার টু IMEI (<span
                                                    class="text-danger">{{ number_format($num_to_imei->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($nid_to_gp->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer nid_to_gp"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="nid_to_gp" class="cursor-pointer nid_to_gp"> এন আইডি টু অল জিপি নাম্বার  (<span
                                                    class="text-danger">{{ number_format($nid_to_gp->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($nid_to_banglalink->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer nid_to_banglalink"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="nid_to_banglalink" class="cursor-pointer nid_to_banglalink"> এন আইডি টু অল বাংলালিংক নাম্বার  (<span
                                                    class="text-danger">{{ number_format($nid_to_banglalink->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($all->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer all"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="imei_biometric_location" class="cursor-pointer all"> আই.এম.আই টু এক্টিভ নাম্বার+ বায়োমেট্রিক+ লোকেশন   (<span
                                                    class="text-danger">{{ number_format($all->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                  <label for="" class="form-label">নিম্মক্ত তথ্য প্রদান করুন</label>
                                <textarea name="data" id="data" cols="30" rows="4" class="form-control "
                                    placeholder="অপশন সিলেক্ট করুন"></textarea>
                            </div>


                            <div class=" text-center">
                                <button class="btn btn-primary btn-sm " type="submit" id="orderBtn" onclick=" return confirm('আপনি কি ওর্ডার করতে চান?')">ওর্ডার করুন</button>
                            </div>

                        </form>
                    </div>
                </div>
            @else
                <div class="card">
                    <h5 class="card-header text-center mb-4">IMEI  & NID TO ALL NUMBER </h5>
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
                            </tr>
                        </thead>
                        <tbody class="">
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->slug }}</td>
                                    <td>
                                        @if ($order->service_id == 19 || $order->service_id == 24)
                                            <button class="btn ml-2  btn-rounded btn-info data showBtn " data-toggle="modal"
                                            data-target="#showModal" data-data="{{ $order->description }}">
                                            <i class="fa fa-eye color-light"></i>
                                            দেখুন
                                        </button>
                                        @else
                                       <div class="d-flex flex-column">
                                         <span>Type: <strong>{{ $order->type }}</strong></span>
                                        <span>Data: <strong>{{ $order->description }}</strong></span>
                                       </div>

                                        @endif
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
                                             <button class="btn ml-2  btn-rounded btn-info data showBtn " data-toggle="modal"
                                                data-target="#showModal" data-data="{{ $order->downloaded_info }}">
                                                <i class="fa fa-download color-light"></i>
                                                তথ্য দেখুন
                                            </button>
                                        @endif
                                    </td>
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
    <div class="modal fade" id="showModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                </div>
                <div class="modal-body">
                    <textarea name="" id="showData" cols="30" rows="8" class="form-control" readonly></textarea>
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
            $('#imei_form').on('submit', function(e) {
                const $btn = $('#orderBtn');

                $btn.text('অপেক্ষা করুন...');
                $btn.prop('disabled', true);
            });
            $('.imei').on('click', function() {
                $('#data').val('IMEI1: '+'\n'+'IMEI2:'+'\n'+'Lasts Activation Number:'+'\n'+'ফোন হারানোর তারিখ: ')
            });
            $('.nid_to_number').on('click', function() {
                $('#data').val('')
                $('#data').attr('placeholder',' এনআইডি ১০ / ১৭ সংখ্যা বাধ্যতামূলক দিতে হবে')
            });
            $('.num_to_imei').on('click', function() {
                $('#data').val('')
                $('#data').attr('placeholder','ফোন নাম্বার লিখুন')
            });
            $('.nid_to_gp').on('click', function() {
                $('#data').val('')
                $('#data').attr('placeholder',' এনআইডি ১০ / ১৭ সংখ্যা বাধ্যতামূলক দিতে হবে')
            });
            $('.nid_to_banglalink').on('click', function() {
                $('#data').val('')
                $('#data').attr('placeholder',' এনআইডি ১০ / ১৭ সংখ্যা বাধ্যতামূলক দিতে হবে')
            });
            $('.all').on('click', function() {
                 $('#data').val('IMEI1: '+'\n'+'IMEI2:'+'\n'+'Lasts Activation Number:'+'\n'+'ফোন হারানোর তারিখ: ')
            });
            $('.showBtn').on('click', function() {
                var data = $(this).data('data');
                $('#showData').val(data);
            });

        });
    </script>
@endsection
