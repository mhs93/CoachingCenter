@extends('layouts.dashboard.app')

@section('title', 'payments')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>

            </li>
            <li class="breadcrumb-item">
                <span>Payments</span>
            </li>
        </ol>
        <a href="{{ route('admin.payments.create') }}" class="btn btn-sm btn-info">Create</a>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <p class="m-0">Payment lists</p>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">SL No</th>
                    <th scope="col">Reg No.</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Paid Amount</th>
                    <th scope="col">Due Amount</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $payment->reg_no }}</td>
                        <td>{{ $payment->std_name }}</td>
                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->paid_amount }}</td>
                        <td>{{ $payment->due_amount }}</td>
                        <td>{{ $payment->created_at }}</td>
                        <td >
                            <a href="" class="btn btn-info"><i class='bx bx-printer'></i></a>
                            <a href="{{route('admin.payments.edit',$payment->id)}}" class="btn btn-success btn-sm" ><i class='bx bx-edit-alt'></i></a>

                            <form class="col-6 d-inline" action="{{ route('admin.payments.destroy', $payment->id) }}"  onclick="return confirm('Are you sure Delete this payments?')" method="POST" >
                                @csrf
                                @method('delete')

                                <button type="submit" class="btn btn-danger btn-sm"><i class='bx bx-trash' ></i></button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <div class="alert alert-warning" role="alert">
                        No data here
                    </div>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection
