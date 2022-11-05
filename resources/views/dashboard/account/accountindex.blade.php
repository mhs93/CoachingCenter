@extends('layouts.dashboard.app')

@section('title', 'Accounts')


@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <p class="m-0">Account</p>
            <a href="{{ route('admin.account.create') }}" class="btn btn-sm btn-info">Create account</a>
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                <tr>
                    <th scope="col">SL No</th>
                    <th scope="col">Account</th>
                    <th scope="col">Bank Name</th>
                    <th scope="col">Branch Name</th>
                    <th scope="col">Account Holder</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
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
                    ajax: "{{ route('admin.account.list') }}",
                    'pageLength': 10,
                    'aLengthMenu': [[10, 25, 50, -1],[10, 25, 50, 'All']],
                    columns: [
                        // {data:'id',name:'id'},
                        {data: 'DT_RowIndex',name: 'DT_RowIndex'},
                        {data: 'account_no',name: 'account_no',orderable: true,searchable: true},
                        {data: 'bank_name',name: 'bank_name',orderable: true,searchable: true},
                        {data: 'branch_name',name: 'branch_name',orderable: true,searchable: true},
                        {data: 'account_holder',name: 'account_holder',orderable: true,searchable: true},
                        {data: 'balance',name: 'balance',orderable: true,searchable: true},
                        {data: 'status',name: 'status',orderable: false,searchable: false},
                        {data: 'action',name: 'action',orderable: false,searchable: false},
                    ]
                });

            });

            // Change status alert
            function statusConfirm(id) {
                event.preventDefault();
                swal({
                    title: `Are you sure?`,
                    text: 'You want to change account status ?',
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
                var url = '{{ route("admin.account.change-status", ":id") }}';

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
                    text: 'You want to delete this account ?',
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
                var url = '{{ route("admin.account.destroy",":id") }}';
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





