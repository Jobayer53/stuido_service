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
                                @forelse ($recent_orders as $order)
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
    <a href="https://chat.whatsapp.com/LVkJ8LlqND7LJflKwEwVEM?mode=ac_t" class="whatsapp-button" target="_blank" rel="noopener noreferrer">
        <i style="margin-bottom: 5px">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-whatsapp"
                viewBox="0 0 16 16">
                <path
                    d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
            </svg>
        </i>
    </a>
@endsection
