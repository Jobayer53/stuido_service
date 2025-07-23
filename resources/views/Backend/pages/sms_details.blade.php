@extends('Backend.layout.backend_app')

@section('style')
    {{-- <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">
                    <div class="  d-flex justify-content-between">
                        <h5>Call/SMS</h5>
                        {{-- <h5 class="float-end">Cost:{{ $service->cost }}</h5> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="serviceTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Slug</th>
                                    <th>Data</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Upload</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>{{ $orders->firstItem() + $key }}</td>
                                         <td>
                                             <a  href="{{route('user_details',$order->user->uuid)}}">
                                                {{ $order->slug }}
                                            </a>
                                        </td>
                                        <td>
                                            @php

                                            @endphp
                                            <div class="d-flex flex-column">
                                                <span>Option:
                                                            <strong>{{ $order->type }}</strong>
                                                        </span>
                                                <span>Number:
                                                            <strong> {!!$order->type_number!!} </strong>
                                                        </span>

                                            </div>
                                        </td>
                                        <td title="{{ $order->created_at->format('F j, g:i a') }}">
                                            {{ $order->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            {{-- <span class="btn btn-sm btn-@if ($order->status == 'pending')primary @elseif($order->status == 'received')secondary   @elseif($order->status == 'completed')success  @elseif($order->status == 'cancelled')danger @endif me-1">
                                        {{ $order->status }}
                                        </span> --}}
                                            @if ($order->status == 'cancelled')
                                                <span class="btn btn-sm btn-danger me-1">Cancelled</span>
                                            @elseif($order->status == 'completed')
                                                <span class="btn btn-sm btn-success me-1">Completed</span>
                                            @else
                                                <select name="" id=""
                                                    class="form-control form-control-sm status"
                                                    data-order_id= "{{ $order->id }}">
                                                    <option value="pending"
                                                        {{ $order->status == 'pending' ? 'selected' : '' }} disabled>
                                                        Pending</option>
                                                    <option value="received"
                                                        {{ $order->status == 'received' ? 'selected' : '' }}> Received
                                                    </option>
                                                    <option value="completed"
                                                        {{ $order->status == 'completed' ? 'selected' : '' }}> Completed
                                                    </option>
                                                    <option value="cancelled"
                                                        {{ $order->status == 'cancelled' ? 'selected' : '' }}> Cancelled
                                                    </option>
                                                </select>
                                            @endif
                                        </td>
                                        <td class="w-20">
                                             @php
                                                $isCompleted = $order->status === 'completed';
                                                $isCancelled = $order->status === 'cancelled';
                                            @endphp
                                            @if (!$isCompleted && !$isCancelled)

                                                    <form action="{{ route('admin_file') }}" method="POST"
                                                        class="fileForm" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="file" class="form-control fileInput"
                                                            name="downloaded_file">
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    </form>

                                            @elseif ($isCompleted)

                                                    <a href="{{ route('order_download', $order->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        Download File
                                                    </a>

                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- status update form --}}
    <form id="statusForm" action="{{ route('admin_status_update') }}" method="POST">
        @csrf
        <input type="hidden" name="status" id="status">
        <input type="hidden" name="order_id" id="order_id">
    </form>

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
            // stuatus upload
            $('.status').on('change', function() {
                var status = $(this).val();
                var order_id = $(this).data('order_id');
                $('#status').val(status);
                $('#order_id').val(order_id);
                $('#statusForm').submit();
            });
            //file form submit
            $('.fileInput').on('change', function() {
                $(this).closest('form').submit(); // Submit only the related form
            });

            $('.editBtn').on('click', function() {
                var data = $(this).data('data');
                if (data.status == 'cancelled' || data.status == 'completed') {
                    $('#submitBtn').hide();
                    $('#data').attr('readonly', true);
                } else {
                    $('#data').attr('readonly', false);
                    $('#submitBtn').show();
                    $('#order_ID').val(data.id);
                }
                $('#data').val(data.downloaded_info);

            });


        });
    </script>
@endsection
