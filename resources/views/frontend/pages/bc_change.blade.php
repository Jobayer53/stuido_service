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
        <div class="col-lg-6 m-auto ">
            @if ($bc_change->available == 1)
                <div class="card">
                    <h5 class="card-header text-center">জন্ম নিবন্ধন নাম্বার চেঞ্জ</h5>
                    <div class="card-body">
                        <form action="{{ route('order_bc_change') }}" method="POST" id="bc_change_form">
                            @csrf
                            <div class="mb-3 text-center">
                                <label for="" class="form-label">BC*</label>
                                <input type="text" class="form-control" name="bc" id="bc"
                                    placeholder="১৭ সংখ্যার জন্ম নিবন্ধন নাম্বার" autofocus required
                                    value="{{ old('nid') }}">
                            </div>
                            <div class="mb-3 text-center">
                                <label for="" class="form-label">Date Of Birth (YYYY-MM-DD)</label>
                                <input type="text" class="form-control" name="dob" id=""
                                    placeholder="2000-12-21" autofocus required>
                            </div>
                            <div class="mb-3 text-center">
                                <label for="" class="form-label">New Phone Number</label>
                                <input type="number" class="form-control" name="number" id=""
                                    placeholder="01XXXXXXXXX" autofocus required>
                            </div>
                            <div class="mb-1 text-center">
                                <small class="">আপনার একাউন্ট থেকে <span
                                        class="text-danger">{{ number_format($bc_change->cost, 0) }} টাকা</span> কেটে নেয়া
                                    হবে !</small>

                            </div>
                            <div class=" text-center">
                                <button class="btn btn-primary btn-sm " type="submit" id="orderBtn">ওর্ডার করুন</button>
                            </div>

                        </form>
                    </div>
                </div>
            @else
                <div class="card">
                    <h5 class="card-header text-center mb-4">জন্ম নিবন্ধন নাম্বার চেঞ্জ</h5>
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
                                            <span>BC: <strong>{{ $order->type_number }}</strong></span>
                                            <span>DOB: <strong>{{ $order->dob }}</strong></span>
                                            <span>Phone: <strong>{{ $order->description }}</strong></span>
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
                                        @if ($order->status == 'completed')
                                            <button class="btn ml-2  btn-rounded btn-info data showBtn " data-toggle="modal"
                                                data-target="#showModal" data-data="{{ $order }}">
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
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#bc_change_form').on('submit', function(e) {
                const $btn = $('#orderBtn');

                $btn.text('অপেক্ষা করুন...');
                $btn.prop('disabled', true);
            });
              $('.showBtn').on('click', function() {
                var data = $(this).data('data');
                $('#showData').val(data.downloaded_info);

            });

        });
    </script>
@endsection
