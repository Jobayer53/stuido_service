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
                    <h5 class="card-header text-center">কল/SMS লিষ্ট</h5>
                    <div class="card-body">
                        <form action="{{ route('order_sms') }}" method="POST" id="sms_form">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Select Option:</label>
                                <div class="mb-3 row d-flex justify-content-around">
                                    @if ($call_list->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer call_list"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="call_list" class="cursor-pointer call_list"> ৩ মাসের কল লিষ্ট (<span
                                                    class="text-danger">{{ number_format($call_list->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($call_list6->available == 1)
                                        <div class="col-5 border mb-3">
                                            <label class="radio-inline mb-0 cursor-pointer call_list6" style="padding: 10px 0px;">
                                                <input type="radio" name="type" value="call_list_6M"
                                                    class="cursor-pointer call_list6"> ৬ মাসের কল লিস্ট(<span
                                                    class="text-danger">{{ number_format($call_list6->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($sms_gp->available == 1)
                                        <div class="col-5 border mb-3">
                                            <label class="radio-inline mb-0 cursor-pointer sms_gp" style="padding: 10px 0px;">
                                                <input type="radio" name="type" value="sms_gp"
                                                    class="cursor-pointer sms_gp"> ১ মাসের জিপি SMS লিষ্ট  (<span
                                                    class="text-danger">{{ number_format($sms_gp->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($sms_banglalink->available == 1)
                                        <div class="col-5 border mb-3">
                                            <label class="radio-inline mb-0 cursor-pointer sms_banglalink"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="sms_banglalink" class="cursor-pointer sms_banglalink"> ১ মাসের বাংলালিংক SMS লিষ্ট (<span
                                                    class="text-danger">{{ number_format($sms_banglalink->cost, 0) }}</span>TK)</label>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">ফোন নাম্বারঃ</label>
                                <input type="number" class="form-control" name="number" id="number" placeholder="অপশন সিলেক্ট করুন!"
                                    autofocus required>
                            </div>


                            <div class=" text-center">
                                <button class="btn btn-primary btn-sm " type="submit" id="orderBtn"
                                  >ওর্ডার করুন</button>
                            </div>

                        </form>
                    </div>
                </div>
            @else
                <div class="card">
                    <h5 class="card-header text-center mb-4">কল/SMS লিষ্ট </h5>
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
                        <thead class=" bg-info text-white">
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
                        <tbody class="text-dark">
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->slug }}</td>
                                    <td class="d-flex flex-column">
                                        <span>Option: <strong>{{ $order->type }}</strong></span>
                                        <span>Number: <strong> {{ $order->type_number }}</strong></span>



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
                                          <span class="text-white btn btn-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'info')}} btn-sm  me-1">
                                            {{ $order->status }}
                                        </span>

                                    </td>
                                    <td>
                                        @if($order->status == 'completed' && $order->downloaded_file !== null)
                                                <a  href="{{ route('order_download', $order->id) }}"class="btn ml-2  btn-rounded btn-info"><i class="fa fa-download color-light"></i> ডাউনলোড</a>

                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center py-3" colspan="7">কোনো ডাটা পাওয়া যায়নি</td>

                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                 {{ $orders->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#sms_form').on('submit', function(e) {
                const $btn = $('#orderBtn');

                $btn.text('অপেক্ষা করুন...');
                $btn.prop('disabled', true);
            });
            $('.showBtn').on('click', function() {
                var data = $(this).data('data');
                $('#showData').val('Type: '+ data.type + '\n'+'Data: '+'\n' + data.description);
            })
            $('.call_list').on('click', function() {
                $('#number').attr('placeholder', '01XXXXXXXXX');
            })
            $('.call_list6').on('click', function() {
                $('#number').attr('placeholder', '01XXXXXXXXX');
            })
            $('.sms_gp').on('click', function() {
                $('#number').attr('placeholder', '017XXXXXXXX');
            })
            $('.sms_banglalink').on('click', function() {
                $('#number').attr('placeholder', '019XXXXXXXX');
            })

        });
    </script>
@endsection
