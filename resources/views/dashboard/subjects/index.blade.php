@extends('layouts.dashboard.app')

@section('title', 'Subject List')

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
            <p class="m-0">Subject lists</p>
            @can('subject_create')
                <a class="btn btn-sm btn-info" href="{{route('admin.subjects.create')}}">Create subject</a>
            @endcan
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Subject Name</th>
                        <th>Subject Code</th>
                        <th>Subject Fee</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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

            // Get all data from database (Server Site).
            $(document).ready(function() {
                $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    info: true,
                    ajax: "{{ route('admin.subjects.list') }}",
                    'pageLength': 10,
                    'aLengthMenu': [[10, 25, 50, -1],[10, 25, 50, 'All']],
                    columns: [
                        // {data:'id',name:'id'},
                        {data: 'DT_RowIndex',name: 'DT_RowIndex'},
                        {data: 'name',name: 'name',orderable: true,searchable: true},
                        {data: 'code',name: 'code',orderable: true,searchable: true},
                        // {data: 'note',name: 'note',orderable: false,searchable: true},
                        {data: 'fee',name: 'fee',orderable: true,searchable: true},
                        {data: 'status',name: 'status',orderable: false,searchable: false},
                        {data: 'action',name: 'action',orderable: false,searchable: false},
                    ]

                });
            });

            function statusConfirm(id) {
                event.preventDefault();
                swal({
                    title: `Are you sure?`,
                    text: 'You want to change subject status ?',
                    buttons: true,
                    dangerMode: true,
                }).then((willChangeStatus) => {
                    if (willChangeStatus) {
                        changeStatus(id);
                    }
                });
            }

            function changeStatus(id) {
                var url = '{{ route("admin.subjects.change-status", ":id") }}';

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

            function showDeleteConfirm(id)
            {
                event.preventDefault();
                swal({
                    title: `Are you sure?`,
                    text: 'You want to delete this announcements ?',
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
                var url = '{{ route("admin.subjects.destroy",":id") }}';
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
