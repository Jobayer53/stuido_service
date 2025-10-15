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
                        <h5 class="card-title fw-semibold mb-4">All Orders</h5>
                        {{-- <span>Total: {{ $total }}</span> --}}
                    </div>
                    <div class="card-body">
                        {{-- <form method="POST" action="{{ route('users.toggle-status') }}" >
                        @csrf
                        <input type="hidden" name="status" value="{{ $status }}">
                        <button type="submit" class="btn btn-sm btn-{{ $status == 'Activate' ? 'primary' : 'danger'}}">
                            {{ ucfirst($status) }} All Users
                        </button> --}}
                    </form>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="serviceTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Service</th>
                                        <th>User</th>
                                        <th>Status</th>
                                        <th>Cost</th>
                                        <th>Time</th>
                                       
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-dark fw-bold d-flex flex-column">
                                                <span>{{ $order->service->name }}</span>
                                                <span>{{ $order->slug }}</span>
                                            </td>
                                            <td>
                                                <a href="{{route('user_details', $order->user->uuid)}}" class="text-primary">
                                                    <div class="d-flex flex-column">
                                                        <span>{{ $order->user->name }}</span>
                                                        <span>{{$order->user->number}} </span>
                                                    </div>
                                                </a>

                                            </td>
                                            <td>{{ $order->status }}</td>
                                            <td>
                                                {{ number_format($order->cost,0)  }}
                                            </td>
                                            <td class="d-flex flex-column">
                                                <span>{{$order->created_at->format('d-m-Y')}}</span>
                                                <span>{{$order->created_at->diffForHumans()}}</span>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $order->links('pagination::bootstrap-5') }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin_service_update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Charge</label>
                            <input type="number" name="cost" id="cost" class="form-control">
                        </div>
                        <div class="text-center">
                            <input type="hidden" name="id" id="id">
                            <span class="text-danger text-center "> Update service when no active user.</span>
                        </div>
                        <div class="modal-footer  ">
                            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                </div>
                </form>
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
        });
    </script>
@endsection
