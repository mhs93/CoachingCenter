@extends('layouts.dashboard.app')

@section('title', 'student payment')


@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Payment Information</p>
            <a href="{{ route('admin.student.payment',$details->std_id ) }}" class="btn btn-sm btn-info">Back</a>
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                <tr>
                    <th scope="col">Student Name</th>
                    <th scope="col">Month of The Payment</th>
                    <th scope="col">Payment Type</th>
                    <th scope="col">Check Number</th>
                    <th scope="col">Extra Amount</th>
                    <th scope="col">Discount Amount</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Account Number</th>
                    <th scope="col">Payment Date</th>
                </tr>
                </thead>
                <tbody>
                <td>{{$details->student->name}}</td>
                <td>{{$details-> month}}</td>
                <td> @if($details-> payment_type ==1)
                        {{ "Cheque" }}
                    @else
                        {{"Cash"}}
                    @endif
                </td>
                <td>{{$details->cheque_number}}</td>
                <td>{{$details->additional_amount}}</td>
                <td>{{$details->discount_amount}}</td>
                <td>{{$details->total_amount}}</td>
                <td>{{$details->account->account_no}}</td>
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
