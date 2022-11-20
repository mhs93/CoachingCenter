@extends('layouts.dashboard.app')

@section('title', 'Teacher Payment List')


@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Payment Information</p>
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-sm btn-info">Back</a>
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                <tr>
                    <th scope="col">Teacher Name</th>
                    <th scope="col">Monthly Salary</th>
                </tr>
                </thead>
                <tbody>
                <td>{{ $teacher-> name }}</td>
                <td>{{ $teacher-> monthly_salary }}</td>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Payment History</p>
            @can('teacher_payment')
                <a href="{{ route('admin.teacher.payment.create', $teacher->id) }}" class="btn btn-sm btn-info">Create Payment</a>
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
                @foreach($tchpayments as $tchpayment)
                    <tr>
                        <th>{{$tchpayment->month}}</th>
                        <th>{{$tchpayment->total_amount}}</th>
                        <th>
                            @if($tchpayment->account_id == 0)
                                Cash
                            @else
                                {{ $tchpayment->account->account_no}}
                            @endif

                        </th>
                        <th>{{$tchpayment->created_at}}</th>
                        <th>
                            <a href="{{ route('admin.teacher.payment.show',$tchpayment->id) }}" class="btn btn-sm btn-info" title="details"><i class='bx bxs-show'></i></a>
                            <a href="{{route('admin.teacher.payment.edit', $tchpayment->id)}}" title="edit" class="btn btn-sm btn-warning"><i class='bx bxs-edit-alt'></i></a>
                            <a href="{{route('admin.teacher.payment.tchprint', $tchpayment->id)}}" title="print" class="btn btn-sm btn-warning"><i class='bx bxs-printer'></i></a>
                            <a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm( {{ $tchpayment->id }})" title="Delete"><i class="bx bxs-trash"></i></a>
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
            // console.log(id);
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
            var url = '{{ route("admin.teacher.payment.delete",":id") }}';
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
            })
        }
    </script>
@endpush
