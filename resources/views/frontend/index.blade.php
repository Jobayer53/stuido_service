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
            animation: moveText 12s linear infinite;
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
    <div class="row mb-3 p-2">
        <div class="col-lg-12">
            <div class="card mt-3 mb-1">
                <div class="card-header">
                    <h3 class="text-center">Smart Service Zone এ আপনাকে স্বাগতম</h3>
                </div>
            </div>
        </div>
    </div>
    @if ($services_status)
        <div class="row mb-3 p-2">
            <div class="col-lg-12">
                <div class="bg-white p-3 rounded text-container shadow-sm">
                    <p class="mb-0 animated-text">আমাদের সার্ভিস কিছুক্ষণের জন্য বন্ধ আছে। শীঘ্রই আবার চালু হবে। </p>
                </div>
            </div>
        </div>
    @endif
    <div class="row mb-5 p-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Recent 10 Orders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class=" bg-info text-white">
                                <tr>
                                    <th>#</th>
                                    <th>সার্ভিস</th>
                                    <th>স্ট্যাটাস</th>
                                    <th>টাকা</th>
                                    <th>সময়</th>
                                </tr>
                            </thead>
                            <tbody class="text-dark">
                                @forelse ($recent_orders as $order )
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="d-flex flex-column">
                                            <span>{{ $order->service->name }}</span>
                                            <span class="text-light">{{ $order->slug }}</span>
                                        </td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ $order->cost }}</td>
                                        <td>{{ $order->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                        <tr>
                                    <td class="text-center py-3" colspan="7">কোনো ডাটা পাওয়া যায়নি</td>

                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
