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
                    <h5 class="card-header text-center">নগদ/বিকাশ ইনফো</h5>
                    <div class="card-body">
                        <form action="{{ route('order_nagad') }}" method="POST" id="nagad_form">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Select Option:</label>
                                <div class="mb-3 row d-flex justify-content-around">
                                    @if ($nagad_info->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer nagad_info"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="nagad_info" class="cursor-pointer nagad_info"> নগদ ইনফরমেশন(<span
                                                    class="text-danger">{{ number_format($nagad_info->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($b_personal->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer b_personal"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="bikash_personal" class="cursor-pointer b_personal"> বিকাশ পারসোনাল ইনর্ফরমেশন(<span
                                                    class="text-danger">{{ number_format($b_personal->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($rocket_info->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer rocket_info"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="rocket_info" class="cursor-pointer rocket_info"> রকেট ইনফরমেশন(<span
                                                    class="text-danger">{{ number_format($rocket_info->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($nagadP_3mnth->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer nagadP_3mnth"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="nagadPersonal_3Month" class="cursor-pointer nagadP_3mnth"> ৩ মাস এর নগদ পারসোনাল স্টেটমেন্ট  (<span
                                                    class="text-danger">{{ number_format($nagadP_3mnth->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($b_merchant->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer b_merchant"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="bikash_merchant" class="cursor-pointer b_merchant"> বিকাশ মার্চেন্ট ইনফরমেশন  (<span
                                                    class="text-danger">{{ number_format($b_merchant->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($b_agent->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer b_agent"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="bikash_agent" class="cursor-pointer b_agent"> বিকাশ এজেন্ট ইনফরমেশন  (<span
                                                    class="text-danger">{{ number_format($b_agent->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                  <label for="" class="form-label">নিম্মক্ত তথ্য প্রদান করুন</label>
                                <input type="number" name="type_number" id="data" class="form-control "
                                    placeholder="অপশন সিলেক্ট করুন" required>
                            </div>


                            <div class=" text-center">
                                <button class="btn btn-primary btn-sm " type="submit" id="orderBtn" onclick=" return confirm('আপনি কি ওর্ডার করতে চান?')">ওর্ডার করুন</button>
                            </div>

                        </form>
                    </div>
                </div>
            @else
                <div class="card">
                    <h5 class="card-header text-center mb-4">>নগদ/বিকাশ ইনফো </h5>
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
                                       <div class="d-flex flex-column">
                                         <span>Option: <strong>{{ $order->type }}</strong></span>
                                        <span>Number: <strong>{{ $order->type_number }}</strong></span>
                                       </div>
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
            $('#nagad_form').on('submit', function(e) {
                const $btn = $('#orderBtn');

                $btn.text('অপেক্ষা করুন...');
                $btn.prop('disabled', true);
            });

            $('.nagad_info').on('click', function() {
                $('#data').attr('placeholder',' ইনফরমেশন এর জন্য সঠিক নগদ নাম্বার টি দিয়ে সহায়তার করুন')
            });
            $('.b_personal').on('click', function() {
                $('#data').attr('placeholder',' ইনফরমেশন এর জন্য সঠিক বিকাশ নাম্বার টি দিয়ে সহায়তার করুন')
            });
            $('.rocket_info').on('click', function() {
                $('#data').attr('placeholder',' ইনফরমেশন এর জন্য সঠিক রকেট নাম্বার টি দিয়ে সহায়তার করুন')
            });
            $('.rocket_info').on('click', function() {
                $('#data').attr('placeholder',' ইনফরমেশন এর জন্য সঠিক রকেট নাম্বার টি দিয়ে সহায়তার করুন')
            });
            $('.nagadP_3mnth').on('click', function() {
                $('#data').attr('placeholder',' ইনফরমেশন এর জন্য নগদের পার্সনাল নাম্বার টি দিয়ে সহায়তার করুন')
            });
            $('.b_merchant').on('click', function() {
                $('#data').attr('placeholder',' ইনফরমেশন এর জন্য বিকাশের মার্চেন্ট নাম্বার টি দিয়ে সহায়তার করুন')
            });
            $('.b_agent').on('click', function() {
                $('#data').attr('placeholder',' ইনফরমেশন এর জন্য বিকাশের এজেন্ট নাম্বার টি দিয়ে সহায়তার করুন')
            });
              $('.showBtn').on('click', function() {
                var data = $(this).data('data');
                $('#showData').val(data);
            });


        });
    </script>
@endsection
