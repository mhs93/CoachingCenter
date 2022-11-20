@extends('layouts.dashboard.app')

@section('title', 'Student Payment List')


@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Payment Information</p>
            <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-info">Back</a>
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                <tr>
                    <th scope="col">Reg. No</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Monthly Fee</th>
                    <th scope="col">Batch Fee</th>
                </tr>
                </thead>
                <tbody>
                    <td>{{$student-> reg_no}}</td>
                    <td>{{$student-> name}}</td>
                    <td>{{$student-> monthly_fee}}</td>
                    <td>{{$student->batch->batch_fee}}</td>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Payment History</p>
            @can('student_payment')
                <a href="{{ route('admin.student.payment.create', $student->id) }}" class="btn btn-sm btn-info">Create Payment</a>
            @endcan
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="table">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Account Number</th>
                        <th>Payment Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stdpayments as $stdpayment)
                        <tr>
                            <th>{{$stdpayment->month}}</th>
                            <th>{{$stdpayment->total_amount}}</th>
                            <th>
                                @if($stdpayment->account_id == 0)
                                    Cash
                                    @else
                                       {{ $stdpayment->account->account_no}}
                                    @endif
                            </th>
                            <th>{{$stdpayment->created_at}}</th>
                            <th>
                                <a href="{{ route('admin.student.payment.show',$stdpayment->id) }}" class="btn btn-sm btn-info" title="details"><i class='bx bxs-show'></i></a>
                                <a href="{{route('admin.student.payment.edit', $stdpayment->id)}}" title="edit" class="btn btn-sm btn-warning"><i class='bx bxs-edit-alt'></i></a>
                                <a href="{{route('admin.student.payment.stdprint', $stdpayment->id)}}" title="print" class="btn btn-sm btn-warning"><i class='bx bxs-printer'></i></a>
                                <a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm( {{ $stdpayment->id }})" title="Delete"><i class="bx bxs-trash"></i></a>
                            </th>
                        </tr>
                    @endforeach
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
        function showDeleteConfirm(id)
        {
            console.log(id);
            event.preventDefault();
            swal({
                title: `Are you sure?`,
                text: 'You want to delete this payment ?',
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
            var url = '{{ route("admin.student.payment.delete",":id") }}';
            $.ajax({
                type: "GET",
                url: url.replace(':id', id ),
                success: function (resp) {
                    location.reload();
                    if (resp.success === true) {
                        toastr.success(resp.message);
                    }
                },
                error: function (error) {
                    location.reload();
                }
                // success: function (resp) {
                //     // Reloade DataTable
                //     $('.data-table').DataTable().ajax.reload();
                //     if (resp.success === true) {
                //         // show toast message
                //         toastr.success(resp.message);
                //     }
                // }, // success end
                // error: function (error) {
                //     location.reload();
                // }
            })
        }
    </script>
@endpush
