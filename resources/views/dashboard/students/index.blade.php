@extends('layouts.dashboard.app')

@section('title', 'Student List')

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
            <p class="m-0">Student lists</p>
            @can('register_student')
                <a href="{{ route('admin.students.create') }}" class="btn btn-sm btn-info">Create Student</a>
            @endcan
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Registration no.</th>
                        <th scope="col">Email</th>
                        <th scope="col">Batch</th>
                        <th>Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('jquery/jQuery.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            info:true,
            ajax:"{{ route('admin.students.list') }}",
            'pageLength': 10,
            'aLengthMenu': [[10,25,50,-1],[10,25,50,'All']],
            columns: [
                // {data:'id',name:'id'},
                {data:'DT_RowIndex',name:'DT_RowIndex'},
                {data: 'name', name: 'name',orderable: true, searchable: true},
                {data: 'reg_no', name: 'reg_no',orderable: true, searchable: true},
                {data: 'email', name: 'email',orderable: true, searchable: true},
                {data: 'batch.name', name: 'batch',orderable: true, searchable: true},
                {data: 'status',name: 'status',orderable: false,searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // Change status alert
        function statusConfirm(id) {
            event.preventDefault();
            swal({
                title: `Are you sure?`,
                text: 'You want to change student status ?',
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
            var url = '{{ route("admin.students.change-status", ":id") }}';
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
                text: 'You want to delete this student ?',
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
            var url = '{{ route("admin.students.destroy",":id") }}';
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
                    location.reload();
                }
            })
        }

    </script>
@endpush
