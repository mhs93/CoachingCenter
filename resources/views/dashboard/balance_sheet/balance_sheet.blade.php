@extends('layouts.dashboard.app')

@section('title', 'Balance sheet')

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
            <p class="m-0">Balance sheet</p>
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Account</th>
                    <th width="15%">Debit</th>
                    <th width="15%">Credit</th>
                    <th width="20%">Balance</th>
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
            ajax:"{{ route('admin.balance-sheet') }}",
            'pageLength': 10,
            'aLengthMenu': [[10,25,50,-1],[10,25,50,'All']],
            columns: [
                // {data:'id',name:'id'},
                {data:'DT_RowIndex',name:'DT_RowIndex'},
                {data: 'bankinfo', name: 'bankinfo',orderable: true, searchable: true},
                {data: 'debit', name: 'debit',orderable: true, searchable: true},
                {data: 'credit', name: 'credit',orderable: true, searchable: true},
                {data: 'balance', name: 'balance',orderable: true, searchable: true},
            ]
        });

    </script>
@endpush
