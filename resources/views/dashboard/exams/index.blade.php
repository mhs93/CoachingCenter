@extends('layouts.dashboard.app')

@section('title', 'Exam List')

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
        @can('exam_modify')
            {{-- <button class="btn btn-sm btn-info" id="showModal">Create batch</button> --}}
            <button class="btn btn-sm btn-info" id="showModal">
                <a href="{{route('admin.exams.create')}}" title="Create">Create Exam</a>
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
            <p class="m-0">Exam lists</p>
            @can('exam_create')
            <a href="{{ route('admin.exams.create') }}" class="btn btn-sm btn-info">Create Exam</a>
            @endcan
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        {{-- <th>Batch</th>
                        <th>Batch Name</th> --}}
                        <th>Start Date</th>
                        <th>End Date</th>
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
                    ajax: "{{ route('admin.exams.lists') }}",
                    'pageLength': 10,
                    'aLengthMenu': [[10, 25, 50, -1],[10, 25, 50, 'All']],
                    columns: [
                        // {data:'id',name:'id'},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'name', name: 'name', orderable: true,searchable: true},
                        // {data: 'examDetails.batch.name', name: 'batch', orderable: true,searchable: true},
                        // {data: 'batch_id', name: 'name', orderable: true,searchable: true},
                        {data: 'start_date', name: 'start_date', orderable: true, searchable: true},
                        {data: 'end_date', name: 'end_date', orderable: true, searchable: true},
                        {data: 'status', name: 'status', orderable: true, searchable: true},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
            });

            // Change status alert
            function statusConfirm(id) {
                event.preventDefault();
                swal({
                    title: `Are you sure?`,
                    text: 'You want to change exam status ?',
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
                var url = '{{ route("admin.exams.change-status", ":id") }}';

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
                    text: 'You want to delete this exam ?',
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
                var url = '{{ route("admin.exams.destroy",":id") }}';
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
