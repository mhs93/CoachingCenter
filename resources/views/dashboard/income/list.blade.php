@extends('layouts.dashboard.app')

@section('title', 'income list')

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
        <div class="card-header d-flex justify-content-between">
            <p class="m-0">Income list</p>
            <a href="{{ route('admin.income.create') }}" class="btn btn-sm btn-info">Create Income</a>
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Date</th>
                    <th scope="col">Income Source</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Account</th>
                    <th scope="col">Payment Type</th>
                    <th scope="col">Cheque Number</th>
                    <th scope="col">Action</th>
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
            ajax:"{{ route('admin.income.list') }}",
            'pageLength': 10,
            'aLengthMenu': [[10,25,50,-1],[10,25,50,'All']],
            columns: [
                {data:'id',name:'id'},
                // {data:'DT_RowIndex',name:'DT_RowIndex'},
                {data: 'created_at', name: 'created_at',orderable: true, searchable: true},
                {data: 'income_source', name: 'income_source',orderable: true, searchable: true},
                {data: 'amount', name: 'amount',orderable: true, searchable: true},
                {data: 'account', name: 'account',orderable: true, searchable: true},
                {data: 'payment_type', name: 'payment_type',orderable: true, searchable: true},
                {data: 'cheque_number', name: 'cheque_number',orderable: true, searchable: true},
                {data: 'action', name: 'action'},
            ]
        });


        function showDeleteConfirm(id)
        {
            event.preventDefault();
            swal({
                title: `Are you sure?`,
                text: 'You want to delete this income ?',
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
            var url = '{{ route("admin.income.destroy",":id") }}';
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
