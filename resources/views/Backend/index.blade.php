@extends('Backend.layout.backend_app')
@section('style')
    <style>
        .chart-container {
            position: relative;
            display: inline-block;
        }

        .circle-chart {
            width: 125px;
            height: 130px;
            transform: rotate(-90deg);
            transition: all 0.3s ease;
            margin-left: -23px;
        }

        .circle-background {
            fill: none;
            stroke: #e9ecef;
            stroke-width: 30;
        }

        .circle-segment {
            fill: none;
            stroke-width: 30;
            stroke-linecap: round;
            transition: all 0.8s ease;
            cursor: pointer;
        }

        .circle-segment:hover {
            stroke-width: 35;
            filter: brightness(1.1);
        }

        .success {
            stroke: #13deb9;
        }

        .danger {
            stroke: #fa896b;
        }

        .primary {
            stroke: #5d87f1;
        }

        .tooltip {
            position: absolute;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            pointer-events: none;
            opacity: 0;
            transform: translateX(-50%) translateY(-100%);
            transition: opacity 0.3s ease;
            white-space: nowrap;
            z-index: 1000;
        }

        .tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-top-color: rgba(0, 0, 0, 0.8);
        }

        .tooltip.show {
            opacity: 1;
        }

        .center-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #495057;
            pointer-events: none;
        }

        .center-year {
            font-size: 16px;
            color: #6c757d;
            margin-top: 5px;
        }

        .legend {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #495057;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 50%;
        }

        .legend-color.success {
            background: #13deb9;
        }

        .legend-color.danger {
            background: #fa896b;
        }

        .legend-color.primary {
            background: #5d87f1;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow ">
                <div class="card-header ">
                    <h5 class="card-title mb-0 fw-semibold  text-center">TODAY</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <!-- Yearly Breakup -->
            <div class="card overflow-hidden shadow">
                <div class="card-body p-4">
                    <div class=" mb-0 d-flex justify-content-between">
                        <h5 class="card-title mb-0  fw-semibold">Recharge</h5>
                        <span class="fw-semibold mb-0 card-title">৳{{ number_format($todays_totalRecharge, 0) }}</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <h5 class="card-title  fw-semibold">Total Orders</h5>
                        <span class="fw-semibold card-title">{{ $todays_totalOrder }}</span>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="fw-semibold mb-3">৳{{ number_format($todays_amount) }}</h4>
                            <div class="d-flex align-items-center mb-3">
                                <span
                                    class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                    <i
                                        class="ti ti-arrow-{{ $status == 'decrease' ? 'down-right text-danger' : 'up-left text-success' }}"></i>
                                </span>
                                <p class="text-dark me-1 fs-3 mb-0">{{ number_format($percentage, 0) }}%</p>
                                <p class="fs-3 mb-0">Yesterday</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                    <span class="fs-2">Pending</span>

                                </div>
                                <div class="me-2">
                                    <span class="round-8 bg-success rounded-circle me-2 d-inline-block"></span>
                                    <span class="fs-2">Complete</span>
                                </div>
                                <div>
                                    <span class="round-8 bg-danger rounded-circle me-2 d-inline-block"></span>
                                    <span class="fs-2">Cancelled</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="chart-container">
                                <svg class="circle-chart" viewBox="0 0 200 200">
                                    <!-- Background circle -->
                                    <circle class="circle-background" cx="100" cy="100" r="85"></circle>

                                    <!-- Success segment -->
                                    <circle class="circle-segment success" cx="100" cy="100" r="85"
                                        data-label="Success" data-value="{{ $completed }}" data-year="2020">
                                    </circle>

                                    <!-- Danger segment -->
                                    <circle class="circle-segment danger" cx="100" cy="100" r="85"
                                        data-label="Danger" data-value="{{ $cancelled }}" data-year="2020">
                                    </circle>

                                    <!-- Primary segment -->
                                    <circle class="circle-segment primary" cx="100" cy="100" r="85"
                                        data-label="Primary" data-value="{{ $pending }}" data-year="2020">
                                    </circle>
                                </svg>
                                <div class="tooltip"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="mb-9 d-flex justify-content-between">
                        <h5 class="card-title  fw-semibold"> Most Ordered Customer</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($topCustomers as $customer)
                            <li class="list-group-item d-flex justify-content-between">
                                <a href="{{ route('user_details', $customer->uuid) }}"
                                    class="text-dark">{{ $customer->name }}</a>
                                <span>{{ $customer->orders_count }}</span>
                            </li>
                        @empty
                            <li class="list-group-item d-flex justify-content-between">
                                <p>No Data</p>
                            </li>
                        @endforelse

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="mb-9 d-flex justify-content-between">
                        <h5 class="card-title  fw-semibold"> Most Ordered Service</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($topService as $service)
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-dark">{{ $service->name }}</span>
                                <span>{{ $service->orders_count }}</span>
                            </li>
                        @empty
                            <li class="list-group-item d-flex justify-content-between">
                                <p>No Data</p>
                            </li>
                        @endforelse

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">

                <div class="card-body">
                    <div class="d-flex justify-content-between  ">
                        <h5 class="card-title mb-0 fw-semibold ">API Orders</h5>
                        <h5 class="card-title mb-0 fw-semibold ">Total: {{$apiTotal}}</h5>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-4 " style="border-right: 1px solid #ebf1f6;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-dark">Server Copy</span>
                                    <span>{{ $serverCopy }}</span>
                                </li>
                                   <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-dark">Auto Nid</span>
                                    <span>{{ $autoNid }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4 " style="border-right: 1px solid #ebf1f6;">
                            <ul class="list-group list-group-flush">
                                 <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-dark">Sign to Nid</span>
                                    <span>{{ $signToNid }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-dark">Tin Certificate</span>
                                    <span>{{$tin}}</span>
                                </li>

                            </ul>
                        </div>
                        <div class="col-lg-4" >
                            <ul class="list-group list-group-flush">
                                 <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-dark">Auto Birth Certificate</span>
                                    <span>{{ $autoBC }}</span>
                                </li>

                                {{-- <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-dark">Sign to Nid</span>
                                    <span>2</span>
                                </li> --}}
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- yesterday --}}
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card shadow ">
                <div class="card-header ">
                    <h5 class="card-title mb-0 fw-semibold  text-center">YESTERDAY</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <!-- Yearly Breakup -->
            <div class="card overflow-hidden shadow">
                <div class="card-body p-4">
                    <div class=" mb-0 d-flex justify-content-between">
                        <h5 class="card-title mb-0  fw-semibold">Recharge</h5>
                        <span class="fw-semibold mb-0 card-title">৳{{ number_format($yesterday_totalRecharge, 0) }}</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <h5 class="card-title  fw-semibold">Orders</h5>
                        <span class="fw-semibold card-title">{{ $yesterday_totalOrder }}</span>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-12 ">
                            <h4 class="fw-semibold mb-3">৳{{ number_format($yesterdays_amount) }}</h4>

                            <div class="d-flex flex-column ">
                                <div class="d-flex justify-content-between">
                                    <div class="me-2 mb-2 d-flex align-items-center ">
                                        <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                        <span class="fs-3">Pending</span>
                                    </div>
                                    <span class="fs-3">{{$yesterday->pending}}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="me-2 mb-2  d-flex align-items-center">
                                        <span class="round-8 bg-success rounded-circle me-2 d-inline-block"></span>
                                        <span class="fs-3">Complete</span>
                                    </div>
                                    <span class="fs-3">{{$yesterday->completed}}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class=" mb-2 d-flex align-items-center">
                                        <span class="round-8 bg-danger rounded-circle me-2 d-inline-block"></span>
                                        <span class="fs-3">Canceled</span>
                                    </div>
                                    <span class="fs-3">{{$yesterday->canceled}}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="mb-9 d-flex justify-content-between">
                        <h5 class="card-title  fw-semibold"> Most Ordered Customer</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($topCustomerYesterday as $customer)
                            <li class="list-group-item d-flex justify-content-between">
                                <a href="{{ route('user_details', $customer->uuid) }}"
                                    class="text-dark">{{ $customer->name }}</a>
                                <span>{{ $customer->orders_count }}</span>
                            </li>
                        @empty
                            <li class="list-group-item d-flex justify-content-between">
                                <p>No Data</p>
                            </li>
                        @endforelse

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="mb-9 d-flex justify-content-between">
                        <h5 class="card-title  fw-semibold"> Most Ordered Service</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($topServiceYesterday as $service)
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-dark">{{ $service->name }}</span>
                                <span>{{ $service->orders_count }}</span>
                            </li>
                        @empty
                            <li class="list-group-item d-flex justify-content-between">
                                <p>No Data</p>
                            </li>
                        @endforelse

                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- total --}}
    {{-- <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card shadow ">
                <div class="card-header ">
                    <h5 class="card-title mb-0 fw-semibold  text-center">TOTAL</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <div class="card overflow-hidden shadow">
                <div class="card-body p-4">
                    <div class=" mb-9 ">
                        <h5 class="card-title mb-0  fw-semibold text-center">Recharged</h5>
                    </div>
                    <div class="row text-center">
                        <div class="col-12 ">
                            <h4 class="fw-semibold mb-3">৳{{ number_format($yesterdays_amount) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="card overflow-hidden shadow">
                <div class="card-body p-4">
                    <div class=" mb-9 ">
                        <h5 class="card-title mb-0  fw-semibold text-center">Ordered</h5>
                    </div>
                    <div class="row text-center">
                        <div class="col-12 ">
                            <h4 class="fw-semibold mb-3">৳{{ number_format($yesterdays_amount) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> --}}
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Data for each segment
            let value1 = $('.success').data('value');
            let value2 = $('.danger').data('value');
            let value3 = $('.primary').data('value');
            console.log(value1, value2, value3);
            let total = value1 + value2 + value3;
            let percentage1 = (value1 / total) * 100;
            let percentage2 = (value2 / total) * 100;
            let percentage3 = (value3 / total) * 100;
            percentage1 = percentage1.toFixed(2);
            percentage2 = percentage2.toFixed(2);
            percentage3 = percentage3.toFixed(2);
            let data = {
                success: {
                    value: percentage1,
                    label: "Success",
                    color: "#28a745"
                },
                danger: {
                    value: percentage2,
                    label: "Danger",
                    color: "#dc3545"
                },
                primary: {
                    value: percentage3,
                    label: "Primary",
                    color: "#007bff"
                }
            };

            // Calculate circumference and stroke dash arrays
            const radius = 85;
            const circumference = 2 * Math.PI * radius;

            // Starting position for each segment
            let currentOffset = 0;

            // Set up each segment
            $('.circle-segment').each(function() {
                const segment = $(this);
                const segmentClass = segment.hasClass('success') ? 'success' :
                    segment.hasClass('danger') ? 'danger' : 'primary';
                const segmentData = data[segmentClass];

                // Calculate dash array for this segment
                const segmentLength = (segmentData.value / 100) * circumference;
                const dashArray = `${segmentLength} ${circumference}`;
                const dashOffset = -currentOffset;

                // Apply styling
                segment.css({
                    'stroke-dasharray': dashArray,
                    'stroke-dashoffset': dashOffset
                });

                // Update offset for next segment
                currentOffset += segmentLength;
            });

            // Hover functionality
            $('.circle-segment').on('mouseenter', function(e) {
                const segment = $(this);
                const label = segment.data('label');
                const value = segment.data('value');
                const year = segment.data('year');

                const tooltip = $('.tooltip');
                tooltip.html(`${value}`);
                tooltip.addClass('show');

                // Position tooltip
                const containerRect = $('.chart-container')[0].getBoundingClientRect();
                const mouseX = e.clientX - containerRect.left;
                const mouseY = e.clientY - containerRect.top;

                tooltip.css({
                    left: mouseX + 'px',
                    top: mouseY - 10 + 'px'
                });
            });

            $('.circle-segment').on('mousemove', function(e) {
                const containerRect = $('.chart-container')[0].getBoundingClientRect();
                const mouseX = e.clientX - containerRect.left;
                const mouseY = e.clientY - containerRect.top;

                $('.tooltip').css({
                    left: mouseX + 'px',
                    top: mouseY - 10 + 'px'
                });
            });

            $('.circle-segment').on('mouseleave', function() {
                $('.tooltip').removeClass('show');
            });

            // Optional: Add click functionality
            // $('.circle-segment').on('click', function() {
            //     const label = $(this).data('label');
            //     const value = $(this).data('value');
            //     alert(`Clicked on ${label}: ${value}%`);
            // });
        });
    </script>
@endsection
