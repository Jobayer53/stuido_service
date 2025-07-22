@extends('Backend.layout.backend_app')

@section('style')
    <style>
        .blinking-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background-color: #5c9bf7;
            border-radius: 50%;
            animation: blink 2s infinite;
            box-shadow: 0 0 5px rgb(0 104 255 / 50%);
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.2;
            }
        }
    </style>
@endsection
@section('content')
<div class="row mb-3">
    <div class="col-lg-12">
        <form action="{{route('order.slug')}}" class="float-end" method="POST">
            @csrf
            <div class="d-flex">

                <input type="text" class="form-control" name="slug" placeholder="Search by Slug" required>
                <button class="btn btn-primary ms-2 ">Search</button>
            </div>
        </form>
    </div>
</div>
    <div class="row">
        @forelse ($otherServices as $service)
            <div class="col-lg-2 position-relative">
                <a href="{{ route('admin_order_details', $service->id) }}" class="text-dark">
                    <div class="card shadow position-relative">
                        @if ($service->new > 0)
                            {{-- Blinking dot --}}
                            <span class="blinking-dot"></span>
                        @endif
                        <div class="card-header text-center">
                            <p>{{ $service->name }}</p>
                            <strong>{{ $service->completed }}/{{ $service->total }}</strong>
                        </div>
                    </div>
                </a>
            </div>

        @empty
            <div class="col-lg-12">

                <div class="card shadow">
                    <div class="card-header text-center">
                        <p>No Data Found</p>
                        {{-- <strong class="">12/15</strong> --}}
                    </div>
                </div>


            </div>
        @endforelse




        <div class="col-lg-2 position-relative">
            <a href="{{ route('biometric_order_details') }}" class="text-dark">
                <div class="card shadow position-relative">
                    @if ($biometric->new > 0)
                        <span class="blinking-dot"></span>
                    @endif
                    <div class="card-header text-center">
                        <p>Biometric</p>
                        <strong>{{ $biometric->completed == null ? 0 : $biometric->completed }}/{{ $biometric->total }}</strong>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 position-relative">
            <a href="{{ route('passport_order_details') }}" class="text-dark">
                <div class="card shadow position-relative">
                    @if ($passport->new > 0)
                        <span class="blinking-dot"></span>
                    @endif
                    <div class="card-header text-center">
                        <p>Passport</p>
                        <strong>{{ $passport->completed == null ? 0 : $passport->completed }}/{{ $passport->total }}</strong>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 position-relative">
            <a href="{{ route('sms_order_details') }}" class="text-dark">
                <div class="card shadow position-relative">
                    @if ($sms->new > 0)
                        <span class="blinking-dot"></span>
                    @endif
                    <div class="card-header text-center">
                        <p>Call/SMS</p>
                        <strong>{{ $sms->completed == null ? 0 : $sms->completed }}/{{ $sms->total }}</strong>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 position-relative">
            <a href="{{ route('imei_order_details') }}" class="text-dark">
                <div class="card shadow position-relative">
                    @if ($imei->new > 0)
                        <span class="blinking-dot"></span>
                    @endif
                    <div class="card-header text-center">
                        <p>IMEI & NID</p>
                        <strong>{{ $imei->completed == null ? 0 : $imei->completed }}/{{ $imei->total }}</strong>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 position-relative">
            <a href="{{ route('nagad_order_details') }}" class="text-dark">
                <div class="card shadow position-relative">
                    @if ($nagad->new > 0)
                        <span class="blinking-dot"></span>
                    @endif
                    <div class="card-header text-center">
                        <p>Nagad/Bikash</p>
                        <strong>{{ $nagad->completed == null ? 0 : $nagad->completed }}/{{ $nagad->total }}</strong>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 position-relative">
            <a href="{{ route('register_order_details') }}" class="text-dark">
                <div class="card shadow position-relative">
                    @if ($register->new > 0)
                        <span class="blinking-dot"></span>
                    @endif
                    <div class="card-header text-center">
                        <p>Birth Register </p>
                        <strong>{{ $register->completed == null ? 0 : $register->completed }}/{{ $register->total }}</strong>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 position-relative">
            <a href="{{ route('statement_order_details') }}" class="text-dark">
                <div class="card shadow position-relative">
                    @if ($statement->new > 0)
                        <span class="blinking-dot"></span>
                    @endif
                    <div class="card-header text-center">
                        <p>Number Statement</p>
                        <strong>{{ $statement->completed == null ? 0 : $statement->completed }}/{{ $statement->total }}</strong>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 position-relative">
            <a href="{{ route('bmet_order_details') }}" class="text-dark">
                <div class="card shadow position-relative">
                    @if ($bmet->new > 0)
                        <span class="blinking-dot"></span>
                    @endif
                    <div class="card-header text-center">
                        <p>BMET </p>
                        <strong>{{ $bmet->completed == null ? 0 : $bmet->completed }}/{{ $bmet->total }}</strong>

                    </div>
                </div>
            </a>
        </div>

    </div>
@endsection
