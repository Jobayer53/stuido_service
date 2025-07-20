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
            @if ($nid_pdf->available == 1 || $smrt_nidPdf->available == 1)
                <div class="card">
                    <h5 class="card-header text-center">এনাআইডি পিডএফ</h5>
                    <div class="card-body">
                        <form action="{{ route('order_nid_pdf') }}" method="POST" id="nid_pdf_form">
                            @csrf
                            <label for="" class="form-label">Select Option:</label>
                             <div class="mb-3 row d-flex justify-content-around">
                                @if($nid_pdf->available == 1)
                                <div class="col-5 border ">
                                    <label class="radio-inline mb-0 cursor-pointer " style="padding: 10px 0px;"> <input type="radio" name="type_name" value="nid_pdf" class="cursor-pointer"> NID PDF (<span class="text-danger">{{ number_format($nid_pdf->cost, 0)}}</span>TK) </label>
                                </div>
                                @endif
                                @if ($smrt_nidPdf->available == 1)


                                <div class="col-5 border">
                                      <label class="radio-inline mb-0 cursor-pointer" style="padding: 10px 0px;"> <input type="radio" name="type_name" value="smrt_nid_pdf" class="cursor-pointer" > Smart NID PDF (<span class="text-danger">{{ number_format($smrt_nidPdf->cost, 0)}}</span>TK)</label>
                                </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Select Type:</label>
                                <div class="form-group">
                                    <label class="radio-inline mr-3"> <input type="radio" name="type" value="form_no"> Form NO</label>
                                    <label class="radio-inline mr-3"> <input type="radio" name="type" value="nid_no"> NID NO</label>
                                    <label class="radio-inline mr-3"> <input type="radio" name="type" value="voter_no"> Voter NO</label>
                                    <label class="radio-inline mr-3"><input type="radio" name="type" value="birth_no"> Birth NO</label>
                                    {{-- <label class="radio-inline mr-3"><input type="radio" name="optradio">Smart Card Pdf </label> --}}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id=""
                                    placeholder="Name" autofocus required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Form/NID/Voter/Birth NO</label>
                                <input type="text" class="form-control" name="type_no" id=""
                                    placeholder="1234567890" autofocus required>
                            </div>
                            <div class=" text-center">
                                <button class="btn btn-primary btn-sm " type="submit" id="orderBtn">ওর্ডার করুন</button>
                            </div>

                        </form>
                    </div>
                </div>
            @else
                <div class="card">
                    <h5 class="card-header text-center mb-4">এনাআইডি পিডএফ</h5>
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
                            {{-- <th>একশন</th> --}}
                            </tr>
                        </thead>
                        <tbody class="">
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->slug }}</td>
                                    <td class="d-flex flex-column">
                                        <span> Option: <strong>{{ $order->type_name == 'smrt_nid_pdf'? 'Smart NID PDF' : 'NID PDF'  }}</strong></span>
                                         <span>Type: <strong>{{ $order->type == 'nid_no'? 'NID NO' : ($order->type == 'voter_no'? 'Voter NO' :($order->type == 'form_no'? 'Form NO' : 'Birth NO'))  }}</strong></span>
                                        <span>NO: <strong>{{ $order->type_number }}</strong></span>
                                    </td>
                                        <td>
                                       @if($order->status == 'cancelled')
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
                                    <td >
                                          @if($order->status == 'completed' && $order->downloaded_file !== null)
                                                <a  href="{{ route('order_download', $order->id) }}"class="btn ml-2  btn-rounded btn-info"><i class="fa fa-download color-light"></i> ডাউনলোড</a>

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
@endsection

@section('script')
   <script>
     $(document).ready(function () {
       $('#nid_pdf_form').on('submit', function (e) {
    const $btn = $('#orderBtn');

    $btn.text('অপেক্ষা করুন...');
    $btn.prop('disabled', true);
});

    });
   </script>
@endsection
