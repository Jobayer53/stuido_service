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
    <div class="row">
        @php
            $today = today();
            // $biometricGroupIds = [7, 8, 9, 10];
            // $passportGroupIds = [12,13,14];


            $biometric = Illuminate\Support\Facades\DB::selectOne(
                " SELECT COUNT(*) as total, SUM(CASE WHEN status IN ('completed', 'cancelled') THEN 1 ELSE 0 END) as completed,  SUM(CASE WHEN notified = 0 THEN 1 ELSE 0 END) as new FROM orders WHERE service_id IN (7,8,9,10) AND DATE(created_at) = CURDATE()",
            );

            $passport = Illuminate\Support\Facades\DB::selectOne(
                " SELECT COUNT(*) as total, SUM(CASE WHEN status IN ('completed', 'cancelled') THEN 1 ELSE 0 END) as completed,  SUM(CASE WHEN notified = 0 THEN 1 ELSE 0 END) as new FROM orders WHERE service_id IN (12,13,14) AND DATE(created_at) = CURDATE()",
            );
            $sms = Illuminate\Support\Facades\DB::selectOne(
                " SELECT COUNT(*) as total, SUM(CASE WHEN status IN ('completed', 'cancelled') THEN 1 ELSE 0 END) as completed,  SUM(CASE WHEN notified = 0 THEN 1 ELSE 0 END) as new FROM orders WHERE service_id IN (16,17,18) AND DATE(created_at) = CURDATE()",
            );
            $imei = Illuminate\Support\Facades\DB::selectOne(
                " SELECT COUNT(*) as total, SUM(CASE WHEN status IN ('completed', 'cancelled') THEN 1 ELSE 0 END) as completed,  SUM(CASE WHEN notified = 0 THEN 1 ELSE 0 END) as new FROM orders WHERE service_id IN (19,20,21,22,23,24) AND DATE(created_at) = CURDATE()",
            );
            $nagad = Illuminate\Support\Facades\DB::selectOne(
                " SELECT COUNT(*) as total, SUM(CASE WHEN status IN ('completed', 'cancelled') THEN 1 ELSE 0 END) as completed,  SUM(CASE WHEN notified = 0 THEN 1 ELSE 0 END) as new FROM orders WHERE service_id IN (25,26,27,28,29,30) AND DATE(created_at) = CURDATE()",
            );
            $register = Illuminate\Support\Facades\DB::selectOne(
                " SELECT COUNT(*) as total, SUM(CASE WHEN status IN ('completed', 'cancelled') THEN 1 ELSE 0 END) as completed,  SUM(CASE WHEN notified = 0 THEN 1 ELSE 0 END) as new FROM orders WHERE service_id IN (35,36,37,38) AND DATE(created_at) = CURDATE()",
            );
            $statement = Illuminate\Support\Facades\DB::selectOne(
                " SELECT COUNT(*) as total, SUM(CASE WHEN status IN ('completed', 'cancelled') THEN 1 ELSE 0 END) as completed,  SUM(CASE WHEN notified = 0 THEN 1 ELSE 0 END) as new FROM orders WHERE service_id IN (39,40) AND DATE(created_at) = CURDATE()",
            );

            $otherServices = $services->whereNotIn('id', [7, 8, 9, 10, 12, 13, 14,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,35,36,37,38,39,40]);
        @endphp
        @forelse ($otherServices as $service)
            <div class="col-lg-2 position-relative">
                <a href="{{ route('admin_order_details', $service->id) }}" class="text-dark">
                    <div class="card shadow position-relative">
                        @if ($service->orders()->where('notified', 0)->count() > 0)
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

    </div>
@endsection
