@extends('Backend.layout.backend_app')
@section('content')
    <div class="row ">
        <div class="col-lg-12  ">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Services</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0 ">
                                            <h6 class="fw-semibold mb-0">Id</h6>
                                        </th>
                                        <th class="border-bottom-0 w-25">
                                            <h6 class="fw-semibold mb-0">Name</h6>
                                        </th>
                                        <th class="border-bottom-0 w-25">
                                            <h6 class="fw-semibold mb-0">Charge</h6>
                                        </th>
                                        <th class="border-bottom-0 w-25">
                                            <h6 class="fw-semibold mb-0">Status</h6>
                                        </th>
                                        <th class="border-bottom-0 w-25">
                                            <h6 class="fw-semibold mb-0">Action</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($services as $service)
                                        <tr>
                                            <td class="border-bottom-0  ">
                                                <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                            </td>
                                            <td class="border-bottom-0 w-25">
                                                <h6 class="fw-semibold mb-1">{{ $service->name }}</h6>
                                                {{-- <span class="fw-normal">Web Designer</span> --}}
                                            </td>
                                            <td class="border-bottom-0 w-25">
                                                <h6 class="fw-semibold mb-0 fs-4">{{ '৳ ' . $service->cost }}</h6>
                                            </td>

                                            <td class="border-bottom-0 w-25">
                                                <span
                                                    class="badge bg-{{ $service->available ? 'success' : 'danger' }} rounded-3 fw-semibold">{{ $service->available ? 'Available' : 'Unavailable' }}</span>
                                            </td>
                                            <td class="border-bottom-0 w-25">
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-outline-info btn-sm data editBtn" data-bs-toggle="modal" data-bs-target="#editModal" data-data="{{$service}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                            height="18" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path
                                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                    </button>
                                                    <a class="btn btn-outline-danger btn-sm disabled" >
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                            height="18" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 7l16 0" />
                                                            <path d="M10 11l0 6" />
                                                            <path d="M14 11l0 6" />
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0 fs-4">No Data Found!</h6>
                                        </td>
                                        </td>
                                    @endforelse


                                </tbody>
                            </table>
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
<script>
    $(document).ready(function (){
        $('.editBtn').on('click', function(){
            var data = $(this).data('data');
            $('#staticBackdropLabel').html('Update '+ data.name)
            // alert(data.available)
            if(data.available == 1){
                $('#status').html('<option value="1" selected>Available</option> <option value="0">Unavailable</option>');
            }else{
                $('#status').html('<option value="1" >Available</option> <option value="0" selected>Unavailable</option>');
            }
            $('#cost').val(data.cost);
            $('#id').val(data.id);

        })

    });
</script>
@endsection
