@extends('layouts.dashboard.app')

@section('title', 'Class Room')

@push('css')
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

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Class room lists</p>
            @can('classRooms_create')
                <a type="button" href="{{route('admin.class-rooms.create')}}" class="btn btn-sm btn-info">
                    Create class room
                </a>
            @endcan
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Batch</th>
                        <th>Subjects</th>
                        <th>Class Type</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mb-5"></div>

    {{-- Show class room details modal --}}
    <div class="modal fade" id="modalCollapse" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTitle">Class Room Details</h5>
              <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="getDataFrom">
                <div class="modal-body">
                    <table id="table" class="table table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Batch</th>
                                <th id="batchName"></th>
                            </tr>
                            <tr>
                                <th>Subject</th>
                                <th id="subjectName"></th>
                            </tr>
                            <tr>
                                <th>Class Type</th>
                                <th id="classType"></th>
                            </tr>
                            <tr>
                                <th>Class Link</th>
                                <th id="classLink"></th>
                            </tr>
                            <tr>
                                <th>Access Key</th>
                                <th id="accessKey"></th>
                            </tr>
                            <tr>
                                <th>Duration</th>
                                <th id="duration"></th>
                            </tr>
                            <tr>
                                <th>Start Time</th>
                                <th id="startTime"></th>
                            </tr>
                            <tr>
                                <th>End Time</th>
                                <th id="endTime"></th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-secondary" type="button" data-coreui-dismiss="modal">Close</button>
                </div>
            </form>
          </div>
        </div>
    </div>

@push('js')
    <script src="{{ asset('jquery/jQuery.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>

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
                ajax: "{{ route('admin.class-rooms.list') }}",
                'pageLength': 10,
                'aLengthMenu': [[10, 25, 50, -1],[10, 25, 50, 'All']],
                columns: [
                    {data: 'DT_RowIndex',name: 'DT_RowIndex'},
                    {data: 'batch.name',name: 'name',orderable: true,searchable: true},
                    {data: 'subject.name',name: 'name',orderable: true,searchable: true},
                    {data: 'class_type',name: 'class_type',orderable: true,searchable: true},
                    {data: 'date',name: 'date',orderable: true,searchable: true},
                    {data: 'start_time',name: 'start_time',orderable: false,searchable: false},
                    {data: 'end_time',name: 'end_time',orderable: false,searchable: false},
                    {data: 'status',name: 'status',orderable: false,searchable: false},
                    {data: 'action',name: 'action',orderable: false,searchable: false},
                ]
            });
        });

        //Show Details
        function showDetailsModal(id) {
            $('#modalCollapse').modal('show');
            var url = '{{ route("admin.class-rooms.show", ":id") }}';

            $.ajax({
                url: url.replace(':id', id ),
                method: "GET",
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(response) {
                    if (response.success === true) {
                        $('#batchName').html(response.batch.name);
                        $('#classType').html(response.data.class_type);
                        if(response.data.class_type == 1) {
                            $('#classType').html("Physical");
                        }else {
                            $('#classType').html("online");
                        }
                        $('#classLink').html(response.data.class_link);
                        $('#accessKey').html(response.data.access_key);
                        $('#duration').html(response.data.duration);
                        $('#startTime').html(response.data.start_time);
                        $('#endTime').html(response.data.end_time);
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
                text: 'You want to delete this class room ?',
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    deleteItem(id);
                }
            });
        }

        // Change status alert
        function statusConfirm(id) {
            event.preventDefault();
            swal({
                title: `Are you sure?`,
                text: 'You want to change class room status ?',
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
                var url = '{{ route("admin.class-rooms.change-status", ":id") }}';

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

        // Delete Button
        function deleteItem(id)
        {
            var url = '{{ route("admin.class-rooms.destroy",":id") }}';
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

