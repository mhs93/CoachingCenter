@extends('layouts.dashboard.app')

@section('title', 'Batch List')

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
            <a href="{{route('admin.batches.create')}}">Create Batches</a>
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
            <p class="m-0">Batch lists</p>
            @can('batches_create')
            <a href="{{ route('admin.batches.create') }}" title="create" class="btn btn-sm btn-info">Create Batch</a>
            @endcan
        </div>
        <div class="card-body">

            <form action="{{ route('admin.import-batches') }}" method="post" enctype="multipart/form-data" style="text-align: center">
                @csrf
                <a class="btn btn-outline-dark" href="{{route('admin.batches.print')}}" title="print" style="text-align: center">PDF</a>
                <a class="btn btn-outline-dark" href="{{ route('admin.export-batches') }}">Export</a>
                <input class="btn btn-outline-dark" type="file" name="file" required>
                <input class="btn btn-outline-dark" type="submit" value="import">
            </form>

            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead style="text-align: center">
                    <tr>
                        <th>Id</th>
                        <th>Batch Name</th>
                        <th>Subjects</th>
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
                            <div class="">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Batch name</th>
                                            <td id="subjectName"></td>
                                        </tr>
                                        <tr>
                                            <th>Subject List</th>
                                            <td id="subjectList"></td>
                                        </tr>
                                        <tr>
                                            <th>Start Date</th>
                                            <td id="startDate"></td>
                                        </tr>
                                        <tr>
                                            <th>End Date</th>
                                            <td id="endDate"></td>
                                        </tr>
                                        <tr>
                                            <th class="initialFee">Initial Fee</th>
                                            <td id="initialFee"></td>
                                        </tr>
                                        <tr>
                                            <th class="adjustmentType">Adjustment Type</th>
                                            <td id="adjustmentType"></td>
                                        </tr>
                                        <tr>
                                            <th class="adjustmentBalance">Adjustment Balance</th>
                                            <td id="adjustmentBalance"></td>
                                        </tr>
                                        <tr>
                                            <th>Batch Fee</th>
                                            <td id="batchFee"></td>
                                        </tr>
                                        <tr>
                                            <th>Batch Details</th>
                                            <td id="batchDetails"></td>
                                        </tr>
                                    </tbody>
                                </table>
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
                    ajax: "{{ route('admin.batches.list') }}",
                    'pageLength': 10,
                    'aLengthMenu': [[10, 25, 50, -1],[10, 25, 50, 'All']],
                    columns: [
                        // {data:'id',name:'id'},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'name',name: 'name',orderable: true,searchable: true},
                        {data: 'subject_id',name: 'subject_id',orderable: true,searchable: true},
                        {data: 'status',name: 'status',orderable: false,searchable: false},
                        {data: 'action',name: 'action',orderable: false,searchable: false},
                    ]
                });
            });

            $('.initialFee').hide();
            $('.adjustmentType').hide();
            $('.adjustmentBalance').hide();

            $('#initialFee').hide();
            $('#adjustmentType').hide();
            $('#adjustmentBalance').hide();

            // show
            function show(id) {
                $('#getDataFrom').trigger("reset");
                $('#modalTitle').html("Batch Details");
                $('#showModel').modal('show');

                var url = '{{ route("admin.batches.show", ":id") }}';
                $.ajax({
                    url: url.replace(':id', id ),
                    type: 'get',
                    success: function(response) {
                        console.log(response.batch);
                        // console.log(response.data.batch.name);
                        if (response.success === true) {
                            // $('#subjectName').html(response.batch.name);
                            $('#subjectName').html(response.data.batch.name);
                            $('#subjectList').html(response.data.batchSubs);
                            $('#startDate').html(response.data.batch.start_date);

                            $('#endDate').html(response.data.batch.end_date);

                            if(response.data.balance){
                                $('.initialFee').show();
                                $('.adjustmentType').show();
                                $('.adjustmentBalance').show();

                                $('#initialFee').show();
                                $('#adjustmentType').show();
                                $('#adjustmentBalance').show();

                                $('#initialFee').html(response.data.batch.initial_amount);
                                $('#adjustmentType').html(response.data.batch.adjustment_balance);
                                if(response.data.batch.adjustment_type == 1){
                                    $('#adjustmentBalance').html('Addition');
                                }else{
                                    $('#adjustmentBalance').html('Subtraction');
                                }
                            }
                            $('#batchFee').html(response.data.batch.total_amount);
                            if(response.data.batch.note){
                                $('#batchDetails').html(response.data.batch.note);
                            }else{
                                $('#batchDetails').html('---');
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
                    text: 'You want to change batch status ?',
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
                var url = '{{ route("admin.batches.change-status", ":id") }}';

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

            // Delete Button
            function deleteItem(id)
            {
                var url = '{{ route("admin.batches.destroy",":id") }}';
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
