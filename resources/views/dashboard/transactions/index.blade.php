@extends('layouts.dashboard.app')

@section('title', 'transaction')

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

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex  align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>

            </li>
        </ol>

        <a href="{{ route('admin.transaction.create') }}" class="btn btn-sm btn-info">Create Transaction</a>
    </nav>
@endsection

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header">
            <p class="m-0">Transaction lists</p>
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Date</th>
                    <th scope="col">Account No</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Transaction Type</th>
                    <th scope="col">Payment Type</th>
                    <th scope="col">Cheque Number</th>
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
            ajax:"{{ route('admin.transaction.list') }}",
            'pageLength': 10,
            'aLengthMenu': [[10,25,50,-1],[10,25,50,'All']],
            columns: [
                // {data:'id',name:'id'},
                {data:'DT_RowIndex',name:'DT_RowIndex'},
                {data: 'date', name: 'date',orderable: true, searchable: true},
                {data: 'account_id', name: 'account_id',orderable: true, searchable: true},
                {data: 'amount', name: 'amount',orderable: true, searchable: true},
                {data: 'transaction_type', name: 'transaction_type',orderable: true, searchable: true},
                {data: 'payment_type', name: 'payment_type',orderable: true, searchable: true},
                {data: 'cheque_number', name: 'cheque_number',orderable: true, searchable: true},
            ]
        });
    </script>
@endpush
