@extends('Backend.layout.backend_app')
@section('style')
    {{-- <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"> --}}
    <style>
        .w-20 {
            width: 20% !important;
        }

        .w-25 {
            width: 25% !important;
        }

        .w-30 {
            width: 30% !important;
        }
    </style>
@endsection
@section('content')
    <div class="row ">
        <div class="col-lg-12  ">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between ">
                        <h5 class="card-title fw-semibold mb-4">Payment History</h5>
                        <span>Total: {{ number_format($total, 0) }} ৳</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="serviceTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>নাম্বার ও লেনদেন আইডি</th>
                                    <th>স্ট্যাটাস</th>
                                    <th>সময়</th>
                                    <th>টাকা</th>
                                    <th>তথ্য</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="d-flex flex-column">
                                            <span class="font-weight-bold text-dark">{{ $payment->msisdn }}</span>
                                            <span class="">{{ $payment->transaction_id }}</span>
                                        </td>
                                        <td>{{ $payment->status }}</td>
                                        <td>{{ $payment->created_at?->diffForHumans() }}</td>
                                        <td>{{ number_format($payment->amount, 0) }} ৳</td>
                                        <td>
                                            <button class="btn btn-outline-primary btn-sm showModalBtn"  data-data='@json($payment)'>Show
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                    <path
                                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                </svg>
                                            </button>
                                            <div class="btn-group dropleft mb-1 d-none">
                                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fa fa-eye color-light"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item mb-0 mt-0">PaymentID: <span class="text-light">{{ $payment->payment_id}}</span> </a>
                                                    <a class="dropdown-item mb-0 mt-0">Invoice: <span class="text-light">{{ $payment->invoice}}</span> </a>
                                                    <a class="dropdown-item mb-0 mt-0">StatusMessage: <span class="text-light">{{ $payment->statusMessage}} | {{ $payment->status_code}} </span> </a>
                                                    <a class="dropdown-item mb-0 mt-0">Time: <span class="text-light">{{ $payment->created_at}}</span> </a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center py-3" colspan="7">কোনো ডাটা পাওয়া যায়নি</td>

                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $payments->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="showModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#serviceTable').DataTable({
                pageLength: 20,
                ordering: true,
                searching: true,
                lengthChange: true,
                paging: false,
                info: false,
            });

            $('.showModalBtn').on('click', function(e) {
                e.preventDefault();

                // Get data from button
                let paymentData = $(this).data('data');
                console.log("Payment data:", paymentData);
                let data = `<p class="dropdown-item mb-0 mt-0 ">PaymentID: <span class="text-dark font-weight-bold">`+paymentData.payment_id+`</span> </p>
                    <p class="dropdown-item mb-0 mt-0 ">Invoice: <span class="text-dark font-weight-bold">`+paymentData.invoice+`</span> </p>
                    <p class="dropdown-item mb-0 mt-0 ">StatusMessage: <span class="text-dark font-weight-bold">`+paymentData.statusMessage+` | `+paymentData.status_code+` </span> </p>
                    <p class="dropdown-item mb-0 mt-0 ">Time: <span class="text-dark font-weight-bold">`+paymentData.created_at+`</span> </p>`
                // Pass data to modal content (optional)
                $('#showModal .modal-body').html(data);

                // Show modal manually
                $('#showModal').modal('show');
            });
        });
    </script>
@endsection
