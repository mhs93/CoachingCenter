@extends('layouts.dashboard.app')
@section('title','Income details')


@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Income Information</p>
            <a href="{{ route('admin.income.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <table id="table" class="table table-bordered data-table" style="width: 100%">
                        <tbody>
                            <tr>
                                <td>Income Source</td>
                                <td>{{ $income->income_source }}</td>
                            </tr>
                            <tr>
                                <td>Account No.</td>
                                {{--<td>{{ $income->account->account_no }}</td>--}}
                                <td>
                                    @if($income-> account_id == 0)
                                        Cash
                                        @else
                                            Cheque
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Amount</td>
                                <td>{{ $income->amount }}</td>
                            </tr>
                            <tr>
                                <td>Payment Type</td>
                                <td>
                                    @if($income->payment_type == 1)
                                        Chaque
                                        @else
                                            Cash
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <td>Cheque Number</td>
                                <td>{{ $income->cheque_number }}</td>
                            </tr>
                            <tr>
                                <td>Note</td>
                                <td>{!! $income->note !!}</td>
                            </tr>

                        </tbody>
                    </table>
                    <div class="form-group mt-3">
                        <a href="{{route('admin.income.edit',$income->id)}}" class="btn btn-sm btn-primary">Edit</a>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
