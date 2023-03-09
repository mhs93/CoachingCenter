@extends('layouts.dashboard.app')

@section('title', 'Resource List')

@push('css')
    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        table {
            width: 100%;
        }
        .paging_simple_numbers,
        .dataTables_filter {
            float: right;
        }
    </style>
@endpush

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
        </ol>
        @can('batches_create')
        {{-- <button class="btn btn-sm btn-info" id="showModal">Create batch</button> --}}
        <button class="btn btn-sm btn-info" id="showModal">
            <a href="{{route('admin.resources.create')}}">Create Resource</a>
        </button>
        @endcan
    </nav>
@endsection

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="show-message mt-3" align="center">
            @if(Session::has('show'))<span class="alert alert-info">{{Session::get('show')}}</span>@endif
        </div>
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Resource lists</p>
            @can('resource_upload')
            <a href="{{ route('admin.resources.create') }}" class="btn btn-sm btn-info" title="Create">Create Resource</a>
            @endcan
        </div>

        <div class="card-body">
            <div style="text-align: center">
                <a class="btn btn-outline-dark" href="{{route('admin.resources.print')}}" title="print">PDF</a>
            </div>

            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead style="text-align: center">
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Batches</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody style="text-align: center">
                </tbody>
            </table>

            {{-- Show Modal --}}
            <div class="modal fade" id="showModel" aria-hidden="true" >
                <div class="modal-dialog" style="max-width: 800px">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalTitle"></h5>
                      <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <ul id="errors" class="mt-2"></ul>
                    <form id="getDataFrom">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Resource Title</th>
                                                <td id="resourceTitle"></td>
                                            </tr>
                                            <tr>
                                                <th>BatchList</th>
                                                <td id="batchList"></td>
                                            </tr>
                                            <tr>
                                                <th>Subject List</th>
                                                <td id="subjectList"></td>
                                            </tr>

                                            <tr>
                                                <th>Resource Details</th>
                                                <td id="details"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-3">
                                    <div id="document">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-secondary" type="button" data-coreui-dismiss="modal">Close</button>
                        </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5"></div>
    @push('js')
        <script src="{{ asset('jquery/jQuery.js') }}"></script>
        <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
        {{-- Select2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- sweetalert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            // Get all data from database (Server Site)
            $(document).ready(function() {
                $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    info: true,
                    ajax: "{{ route('admin.resources.list') }}",
                    'pageLength': 10,
                    'aLengthMenu': [[10, 25, 50, -1],[10, 25, 50, 'All']],
                    columns: [
                        // {data:'id',name:'id'},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'title',       name: 'title',    orderable: true,   searchable: true},
                        {data: 'batch_id',    name: 'batch_id', orderable: true,   searchable: true},
                        {data: 'status',      name: 'status',   orderable: false,  searchable: false},
                        {data: 'action',      name: 'action',   orderable: false,  searchable: false},
                    ]
                });
            });

             // show
             function show(id) {
                $('#getDataFrom').trigger("reset");
                $('#modalTitle').html("Resource Details");
                $('#showModel').modal('show');
                var url = '{{ route("admin.resources.show", ":id") }}';
                $.ajax({
                    url: url.replace(':id', id ),
                    type: 'get',
                    success: function(response) {
                        console.log(response);
                        if (response.success === true) {
                            var a = '<img src="{{asset('files/')}}/'+response.data.resource.file+' " alt="Image" class=" img-fluid" style="width: 300px;">';
                            console.log(a);
                            $('#resourceTitle').html(response.data.resource.title);
                            $('#batchList').html(response.data.batch_name);
                            $('#subjectList').html(response.data.subject_name);
                            $('#document').html(a);
                            if(response.note){
                                $('#details').html(response.data.resource.note);
                            }else{
                                $('#details').html('---');
                            }
                        }
                    }
                });
            }

            // Change status alert
            function statusConfirm(id) {
                event.preventDefault();
                swal({
                    title: `Are you sure?`,
                    text: 'You want to change resource status ?',
                    buttons: true,
                    dangerMode: true,
                }).then((willChangeStatus) => {
                    if (willChangeStatus) {
                        changeStatus(id);
                    }
                });
            }

            // Change status
            function changeStatus(id) {
                console.log(id);
                var url = '{{ route("admin.resources.change-status", ":id") }}';

                $.ajax({
                    url: url.replace(':id', id ),
                    method: "PUT",
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    success: function(response) {
                        if (response.success === true) {
                            $('.data-table').DataTable().ajax.reload();
                            toastr.success(response.message);
                        }
                    },
                    error: function(error) {
                        alert(error);
                    }
                });
            }

            // delete Confirm
            function showDeleteConfirm(id)
            {
                event.preventDefault();
                swal({
                    title: `Are you sure?`,
                    text: 'You want to delete this batch ?',
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        deleteItem(id);
                    }
                });
            }


            function deleteItem(id)
            {
                var url = '{{ route("admin.resources.destroy",":id") }}';
                $.ajax({
                    type: "DELETE",
                    url: url.replace(':id', id ),
                    success: function (resp) {
                        // Reloade DataTable
                        $('.data-table').DataTable().ajax.reload();
                        if (resp.success === true) {
                            // show toast message
                            toastr.success(resp.message);
                        }
                    }, // success end
                    error: function (error) {
                        alert(error);
                    }
                })
            }
        </script>
    @endpush
@endsection
