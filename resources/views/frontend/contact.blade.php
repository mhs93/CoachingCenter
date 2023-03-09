@extends('layouts.dashboard.app')

@section('title', 'Message List')

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
            <p class="m-0">Messages</p>
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead style="text-align: center">
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody style="text-align: center">

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
                    ajax: "{{ route('contact.messages.list') }}",
                    'pageLength': 10,
                    'aLengthMenu': [[10, 25, 50, -1],[10, 25, 50, 'All']],
                    columns: [
                        // {data:'id',name:'id'},
                        {data: 'DT_RowIndex',name: 'DT_RowIndex'},
                        {data: 'name',name: 'name',orderable: true,searchable: true},
                        {data: 'phone',name: 'phone',orderable: true,searchable: true},
                        {data: 'email',name: 'email',orderable: true,searchable: true},
                        {data: 'subject',name: 'subject',orderable: false,searchable: false},
                        {data: 'message',name: 'message',orderable: false,searchable: false},
                        {data: 'action',name: 'action',orderable: false,searchable: false},
                    ]
                });
            });
            function showDeleteConfirm(id)
            {
                event.preventDefault();
                swal({
                    title: `Are you sure?`,
                    text: 'You want to delete this message ?',
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
                var url = '{{ route("contact.messages.delete",":id") }}';
                $.ajax({
                    type: "DELETE",
                    url: url.replace(':id', id ),
                    success: function (resp) {
                        console.log('resp');
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