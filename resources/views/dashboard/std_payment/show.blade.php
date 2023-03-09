@extends('layouts.dashboard.app')

@section('title', 'Student Payment Details')


@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Payment Information</p>
            @can('payment_manage')
                <a href="{{ route('admin.student.payment',$details->std_id ) }}" class="btn btn-sm btn-info">Back</a>
            @endcan
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead style="text-align: center">
                <tr>
                    <th scope="col">Student Name</th>
                    <th scope="col">Month of The Payment</th>
                    <th scope="col">Payment Type</th>
                    <th scope="col">Check Number</th>
                    <th scope="col">Adjustment Type</th>
                    <th scope="col">Adjustment Balance</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Account Number</th>
                    <th scope="col">Payment Date</th>
                </tr>
                </thead>
                <tbody style="text-align: center">
                <td>{{$details->student->name}}</td>
                <td>{{$details-> month}}</td>
                <td> @if($details-> payment_type ==1)
                        {{ "Cheque" }}
                    @else
                        {{"Cash"}}
                    @endif
                </td>
                <td>
                    @if($details->cheque_number == Null)
                        {{"--"}}
                    @else
                        {{$details->cheque_number}}
                    @endif
                </td>
                <td>
                    @if($details->adjustment_type == Null)
                        {{"--"}}
                    @elseif($details->adjustment_type == 1)
                        {{"Addition"}}
                    @elseif($details->adjustment_type == 2)
                        {{"Subtraction"}}
                    @endif
                </td>
                <td>
                    @if($details->adjustment_balance == Null)
                        {{"--"}}
                    @else
                        {{$details->adjustment_balance}}
                    @endif
                </td>
                <td>{{$details->total_amount}}</td>
                <td>
                    @if($details->account_id == 0)
                        {{"Cash"}}
                        @else
                        {{$details->account->account_no}}
                    @endif
                </td>
                <td>{{$details->created_at}}</td>
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

@endpush
