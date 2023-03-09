@extends('layouts.dashboard.app')

@section('title', 'Income List')

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
            <div style="text-align: center">
                <a class="btn btn-outline-dark" href="{{route('admin.income.all-print')}}" title="print">PDF</a>
            </div>

            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead style="text-align: center">
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
                                        <div class="col-md-12">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th>Income Source</th>
                                                        <td id="income_source"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Payment Type</th>
                                                        <td id="payment_type"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Account Id</th>
                                                        <td id="account_id"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Cheque Number</th>
                                                        <td id="cheque_number"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Amount</th>
                                                        <td id="amount"></td>
                                                    </tr>

                                                    <tr>
                                                        <th>Note</th>
                                                        <td id="note"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
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

        // show
        function show(id) {
            $('#getDataFrom').trigger("reset");
            $('#modalTitle').html("Income Information");
            $('#showModel').modal('show');
            var url = '{{ route("admin.income.show", ":id") }}';
            $.ajax({
                url: url.replace(':id', id ),
                type: 'get',
                success: function(response) {
                    console.log(response);
                    if (response.success === true) {
                        $('#income_source').html(response.data.income_source);
                        if(response.data.payment_type == 1){
                            $('#payment_type').html('Check');
                            $('#account_id').html(response.data.classroom.start_time);
                            $('#cheque_number').html(response.data.classroom.end_time);
                        }else{
                            $('#payment_type').html('Cash');
                            $('#account_id').html('---');
                            $('#cheque_number').html('---');
                        }
                        $('#amount').html(response.data.amount);

                        if(response.data.note){
                            $('#note').html(response.data.classroom.note);
                        }else{
                            $('#note').html('---');
                        }
                    }
                }
            });
        }


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
