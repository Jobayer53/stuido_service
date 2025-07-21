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
                    <h5 class="card-header text-center">জন্ম নিবন্ধন সার্ভিস</h5>
                    <div class="card-body">
                        <form action="{{ route('order_register') }}" method="POST" id="register_form">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Select Option:</label>
                                <div class="mb-3 row d-flex justify-content-around">
                                    @if ($bc_before->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer bc_before"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="bc_before_2000" class="cursor-pointer bc_before"> নতুন জম্ম নিবন্ধন ২০০০ সাল এর আগে(<span
                                                    class="text-danger">{{ number_format($bc_before->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($bc_after->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer bc_after"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="bc_after_2000" class="cursor-pointer bc_after"> নতুন জম্ম নিবন্ধন ২০০০ এর পরে(<span
                                                    class="text-danger">{{ number_format($bc_after->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($bc_death->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer bc_death"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="bc_death_register" class="cursor-pointer bc_death"> জম্ম নিবন্ধন+ মৃত্যু নিবন্ধন প্যাকেজ(<span
                                                    class="text-danger">{{ number_format($bc_death->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif
                                    @if ($lost_bc->available == 1)
                                        <div class="col-5 border mb-3 ">
                                            <label class="radio-inline mb-0 cursor-pointer lost_bc"
                                                style="padding: 10px 0px;"> <input type="radio" name="type"
                                                    value="lost_bc" class="cursor-pointer lost_bc"> হারানো জম্ম নিবন্ধন উত্তলন  (<span
                                                    class="text-danger">{{ number_format($lost_bc->cost, 0) }}</span>TK)
                                            </label>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="mb-3">
                                  <label for="" class="form-label">নিম্মক্ত তথ্য প্রদান করুন</label>
                               <textarea name="data" id="data" cols="30" rows="7" class="form-control " placeholder="অপশন সিলেক্ট করুন"></textarea>
                            </div>


                            <div class=" text-center">
                                <button class="btn btn-primary btn-sm " type="submit" id="orderBtn" >ওর্ডার করুন</button>
                            </div>

                        </form>
                    </div>
                </div>
            @else
                <div class="card">
                    <h5 class="card-header text-center mb-4" >জন্ম নিবন্ধন সার্ভিস </h5>
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
                                       <button class="btn ml-2  btn-rounded btn-info data showBtn " data-toggle="modal"
                                            data-target="#showModal" data-data="{{ $order->description }}">
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
            $('#register_form').on('submit', function(e) {
                const $btn = $('#orderBtn');

                $btn.text('অপেক্ষা করুন...');
                $btn.prop('disabled', true);
            });

            $('.bc_before').on('click', function() {
                $('#data').val(' ♦নতুন নিবন্ধনের তথ্য♦ '+'\n\n'+' ★নাম'+'\n'+'  বাংলায়ঃ '+'\n'+'  ইংরেজী: '+'\n\n'+' ★জন্ম তারিখ:'+'\n'+' ★কত তম সন্তান :'+'\n'+' ★লিঙ্গঃ '+'\n\n'+' ♦পিতার তথ্য♦ '+'\n'+' নাম বাংলায়ঃ '+'\n'+' নাম ইংরেজিতেঃ'+'\n'+' আইডি নাম্বারঃ '+'\n'+' *জন্ম নিবন্ধন নম্বরঃ '+'\n'+' জম্ন তারিখঃ'+'\n'+' জাতীয়তাঃ'+'\n\n'+' ♦মাতার তথ্য♦ '+'\n'+' নাম বাংলায়ঃ '+'\n'+' নাম ইংরেজিতেঃ'+'\n'+' আইডি নাম্বারঃ '+'\n'+' *জন্ম নিবন্ধন নম্বরঃ'+'\n'+' জম্ন তারিখঃ '+'\n'+' জাতীয়তাঃ '+'\n\n'+' ♦♦♦ঠিকানা:♦♦♦'+'\n'+' গ্রামঃ '+'\n'+' Village: '+'\n'+' পৌরসভা/ ইউনিয়নঃ '+'\n'+' ডাকঘর : '+'\n'+' Post office :'+'\n'+' Post code'+'\n'+' উপজেলাঃ '+'\n'+' Upzala:'+'\n'+' জেলা:'+'\n'+' Districts '+'\n'+' বিভাগঃ '+'\n'+' Divition'+'\n'+' ওয়ার্ডঃ'+'\n'+' জন্মস্থানঃ  '+'\n'+'মোবাইল নাম্বারঃ'+'\n\n'+'অর্ডার দিয়ে অবশ্যই এডমিন এর সাথে যোগাযোগ করবেন')
            });
            $('.bc_after').on('click', function() {
           $('#data').val(' ♦নতুন নিবন্ধনের তথ্য♦ '+'\n\n'+' ★নাম'+'\n'+'  বাংলায়ঃ '+'\n'+'  ইংরেজী: '+'\n\n'+' ★জন্ম তারিখ:'+'\n'+' ★কত তম সন্তান :'+'\n'+' ★লিঙ্গঃ '+'\n\n'+' ♦পিতার তথ্য♦ '+'\n'+' নাম বাংলায়ঃ '+'\n'+' নাম ইংরেজিতেঃ'+'\n'+' আইডি নাম্বারঃ '+'\n'+' *জন্ম নিবন্ধন নম্বরঃ '+'\n'+' জম্ন তারিখঃ'+'\n'+' জাতীয়তাঃ'+'\n\n'+' ♦মাতার তথ্য♦ '+'\n'+' নাম বাংলায়ঃ '+'\n'+' নাম ইংরেজিতেঃ'+'\n'+' আইডি নাম্বারঃ '+'\n'+' *জন্ম নিবন্ধন নম্বরঃ'+'\n'+' জম্ন তারিখঃ '+'\n'+' জাতীয়তাঃ '+'\n\n'+' ♦♦♦ঠিকানা:♦♦♦'+'\n'+' গ্রামঃ '+'\n'+' Village: '+'\n'+' পৌরসভা/ ইউনিয়নঃ '+'\n'+' ডাকঘর : '+'\n'+' Post office :'+'\n'+' Post code'+'\n'+' উপজেলাঃ '+'\n'+' Upzala:'+'\n'+' জেলা:'+'\n'+' Districts '+'\n'+' বিভাগঃ '+'\n'+' Divition'+'\n'+' ওয়ার্ডঃ'+'\n'+' জন্মস্থানঃ  '+'\n'+'মোবাইল নাম্বারঃ'+'\n\n'+'অর্ডার দিয়ে অবশ্যই এডমিন এর সাথে যোগাযোগ করবেন')
            });
            $('.bc_death').on('click', function() {
                   $('#data').val(' ♦নতুন নিবন্ধনের তথ্য♦ '+'\n\n'+' ★নাম'+'\n'+'  বাংলায়ঃ '+'\n'+'  ইংরেজী: '+'\n\n'+' ★জন্ম তারিখ:'+'\n'+' ★কত তম সন্তান :'+'\n'+' ★লিঙ্গঃ '+'\n\n'+' ♦পিতার তথ্য♦ '+'\n'+' নাম বাংলায়ঃ '+'\n'+' নাম ইংরেজিতেঃ'+'\n'+' আইডি নাম্বারঃ '+'\n'+' *জন্ম নিবন্ধন নম্বরঃ '+'\n'+' জম্ন তারিখঃ'+'\n'+' জাতীয়তাঃ'+'\n\n'+' ♦মাতার তথ্য♦ '+'\n'+' নাম বাংলায়ঃ '+'\n'+' নাম ইংরেজিতেঃ'+'\n'+' আইডি নাম্বারঃ '+'\n'+' *জন্ম নিবন্ধন নম্বরঃ'+'\n'+' জম্ন তারিখঃ '+'\n'+' জাতীয়তাঃ '+'\n\n'+' ♦♦♦ঠিকানা:♦♦♦'+'\n'+' গ্রামঃ '+'\n'+' Village: '+'\n'+' পৌরসভা/ ইউনিয়নঃ '+'\n'+' ডাকঘর : '+'\n'+' Post office :'+'\n'+' Post code'+'\n'+' উপজেলাঃ '+'\n'+' Upzala:'+'\n'+' জেলা:'+'\n'+' Districts '+'\n'+' বিভাগঃ '+'\n'+' Divition'+'\n'+' ওয়ার্ডঃ'+'\n'+' জন্মস্থানঃ  '+'\n'+'মোবাইল নাম্বারঃ'+'\n\n'+'অর্ডার দিয়ে অবশ্যই এডমিন এর সাথে যোগাযোগ করবেন')
            });
            $('.lost_bc').on('click', function() {
               $('#data').val('**নাম ও ঠিকানা দ্বারা হারানো জন্মনিবন্ধন চালু**    যে সকল ব্যক্তির জন্মনিবন্ধন হারিয়ে গেছে, তারা নিম্নলিখিত তথ্য প্রদান করে পুনরায় চালু করতে পারবেন: '+'\n'+' ✅আপনার পুরো নাম: '+'\n'+' ✅পিতার নাম:'+'\n'+' ✅মাতার নাম: '+'\n'+' ✅জন্মতারিখ[DD-MM-YYYY]: '+'\n'+' ✅ঠিকানা:'+'\n'+' ✅গ্রাম:  '+'\n'+' ✅ইউনিয়ন:'+'\n'+' ✅ওয়ার্ড নম্বর:'+'\n'+' ✅পোস্ট অফিস:'+'\n'+' ✅উপজেলা:'+'\n'+' ✅জেলা:'+'\n'+'     ✨ দ্রুত এবং সহজে হারানো জন্মনিবন্ধন পুনরুদ্ধারের জন্য এখনই আবেদন করুন! ✅')
            });
              $('.showBtn').on('click', function() {
                var data = $(this).data('data');
                $('#showData').val(data);
            });


        });
    </script>
@endsection
