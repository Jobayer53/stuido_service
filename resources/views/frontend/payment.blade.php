@extends('frontend.layout.frontend_app')
@section('content')
    {{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> অ্যাকাউন্ট সেটিংস </h4> --}}

    <div class="row p-2 mb-4">
        <div class="col-lg-6 m-auto mt-3 ">

            <div class="card mb-4">
                <h5 class="card-header text-center">রিচার্জ করুন মাত্র এক ক্লিকে </h5>

                <hr class="my-0" />
                <div class="card-body ">
                    <form action="{{ route('payment_store') }}" method="POST">
                        @csrf
                        <div class="mb-3 text-center">
                            <label for="" class="form-label ">টাকার পরিমান লিখুন।</label>
                            {{-- <input type="number" class="form-control form-control-sm" name="amount"
                                id="amount" placeholder="কমপক্ষে ৫০৳ রিচার্জ করতে হবে"> --}}
                            <input type="number" min="50" class="form-control form-control-sm" name="amount"
                                id="amount" required="50" placeholder="কমপক্ষে ৫০৳ রিচার্জ করতে হবে">
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
    <div class="row mb-5 p-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title">পেমেন্ট হিস্টোরি</h5>
                    <h5>Total: {{ number_format($total,0) }}৳</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class=" bg-info text-white">
                                <tr>
                                    <th>#</th>
                                    <th>নাম্বার ও লেনদেন আইডি</th>
                                    <th>স্ট্যাটাস</th>
                                    <th>সময়</th>
                                    <th>টাকা</th>
                                    <th>তথ্য</th>
                                </tr>
                            </thead>
                            <tbody class="text-dark">
                                @forelse ($payments as $payment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="d-flex flex-column">
                                            <span class="font-weight-bold">{{ $payment->msisdn }}</span>
                                            <span class="text-light">{{ $payment->transaction_id }}</span>
                                        </td>
                                        <td>{{ $payment->status }}</td>
                                        <td>{{ $payment->created_at?->diffForHumans() }}</td>
                                        <td>{{ number_format($payment->amount, 0) }} ৳</td>
                                        <td>
                                            <div class="btn-group dropleft mb-1">
                                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fa fa-eye color-light"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <p class="dropdown-item mb-0 mt-0 text-light">PaymentID: <span class="text-dark">{{ $payment->payment_id}}</span> </p>
                                                    <p class="dropdown-item mb-0 mt-0 text-light">Invoice: <span class="text-dark">{{ $payment->invoice}}</span> </p>
                                                    <p class="dropdown-item mb-0 mt-0 text-light">StatusMessage: <span class="text-dark">{{ $payment->statusMessage}} | {{ $payment->status_code}} </span> </p>
                                                    <p class="dropdown-item mb-0 mt-0 text-light">Time: <span class="text-dark">{{ $payment->created_at}}</span> </p>

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
                    </div>
                    {{ $payments->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
