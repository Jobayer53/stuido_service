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
                        <h5 class="card-title fw-semibold mb-4">Users</h5>
                        <span>Total: {{ $total }}</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.toggle-status') }}" >
                        @csrf
                        <input type="hidden" name="status" value="{{ $status }}">
                        <button type="submit" class="btn btn-sm btn-{{ $status == 'Activate' ? 'primary' : 'danger'}}">
                            {{ ucfirst($status) }} All Users
                        </button>
                    </form>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="serviceTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>
                                                {{ $user->email }}
                                            </td>
                                            <td>{{ $user->number }}</td>
                                            <td>
                                                {{ $user->terminate == 1 ? 'Active' : 'Terminated' }}
                                            </td>
                                            <td class="d-flex gap-2">

                                                <a href="{{route('user_details', $user->uuid)}}" class="btn btn-info " title="View Details">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                        <path
                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                    </svg>
                                                </a>
                                                <a href="{{route('user_terminate', $user->uuid)}}" class="btn btn-{{ $user->terminate == 1 ? 'danger' : 'success'}} " title="Terminate User">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                                                        <path d="M7.5 1v7h1V1z" />
                                                        <path
                                                            d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812" />
                                                    </svg>
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links('pagination::bootstrap-5') }}
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
