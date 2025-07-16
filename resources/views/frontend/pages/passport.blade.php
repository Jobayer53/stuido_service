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
                    <h5 class="card-header text-center">পাসপোর্ট</h5>
                    <div class="card-body">
                        <form action="{{ route('order_passport') }}" method="POST" id="passport_form">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Select Option:</label>
                                <div class="mb-3 row d-flex justify-content-around">
                                    @if ($ePass->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer ePass"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="nid_to_epass" class="cursor-pointer ePass"> এনআইডি টু ই-পাসপোর্ট
                                                ইনফরমেশন (<span
                                                    class="text-danger">{{ number_format($ePass->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($mrp->available == 1)
                                        <div class="col-5 border mb-3">
                                            <label class="radio-inline mb-0 cursor-pointer mrp" style="padding: 10px 0px;">
                                                <input type="radio" name="type" value="nid_to_mrp"
                                                    class="cursor-pointer mrp"> বাংলালিংক বায়োমেট্রিক (<span
                                                    class="text-danger">{{ number_format($mrp->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($server_copy->available == 1)
                                        <div class="col-5 border mb-3">
                                            <label class="radio-inline mb-0 cursor-pointer server_copy"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="mrp_to_serverCopy" class="cursor-pointer server_copy"> টেলিটক
                                                বায়োমেট্রিক (<span
                                                    class="text-danger">{{ number_format($server_copy->cost, 0) }}</span>TK)</label>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">নিম্মক্ত তথ্য প্রদান করুন</label>
                                <textarea name="data" id="" cols="30" rows="4" class="form-control "
                                    placeholder="
                                   ">
পাসপোর্ট নংঃ
জন্ম নিবন্ধন নংঃ
এনআইডি নংঃ
ফোন নংঃ</textarea>
                            </div>


                            <div class=" text-center">
                                <button class="btn btn-primary btn-sm " type="submit" id="orderBtn"
                                    onclick="return confirm('আপনি কি ওর্ডার করতে চান?')">ওর্ডার করুন</button>
                            </div>

                        </form>
                    </div>
                </div>
            @else
                <div class="card">
                    <h5 class="card-header text-center mb-4">পাসপোর্ট </h5>
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
                                    <td>
                                        <button class="btn ml-2  btn-rounded btn-info data showBtn " data-toggle="modal"
                                            data-target="#showModal" data-data="{{ $order }}">
                                            <i class="fa fa-eye color-light"></i>
                                            দেখুন
                                        </button>
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
                                        @if($order->status == 'completed' && $order->downloaded_file !== null)
                                                <a  href="{{ route('order_download', $order->id) }}"class="btn ml-2  btn-rounded btn-info"><i class="fa fa-download color-light"></i> ডাউনলোড</a>

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
            $('#passport_form').on('submit', function(e) {
                const $btn = $('#orderBtn');

                $btn.text('অপেক্ষা করুন...');
                $btn.prop('disabled', true);
            });
            $('.showBtn').on('click', function() {
                var data = $(this).data('data');
                $('#showData').val('Type: '+ data.type + '\n'+'Data: '+'\n' + data.description);
            })

        });
    </script>
@endsection
