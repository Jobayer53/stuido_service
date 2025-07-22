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
    <div class="row ">
        <div class="col-lg-12  ">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between ">
                        <h5 class="card-title fw-semibold mb-4">Users</h5>
                        <span>Total: {{$total}}</span>
                    {{-- <form method="POST" action="{{ route('services.toggle-status') }}" class="float-end">
                        @csrf
                        <input type="hidden" name="status" value="{{ $status }}">
                        <button type="submit" class="btn btn-outline-{{ $status == 'Activate' ? 'success' : 'danger'}}">
                            {{ ucfirst($status) }} All Services
                        </button>
                    </form> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="serviceTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Balance</th>
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
                                            {{ $user->amount}}
                                        </td>
                                        <td class="w-20">

dd
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
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form action="{{route('admin_service_update')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">

                </select>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Charge</label>
                <input type="number" name="cost" id="cost" class="form-control" >
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
