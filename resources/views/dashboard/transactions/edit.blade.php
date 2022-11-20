@extends('layouts.dashboard.app')

@section('title', 'Update bank transaction')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.transaction.index') }}">Transaction List</a>
            </li>
        </ol>
        <a href="{{route('admin.transaction.index')}}" class="btn btn-sm btn-dark">Back</a>
    </nav>
@endsection

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header">
            <p class="m-0">Update</p>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.transaction.update',$transaction->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <p class="m-0">Update Transaction</p>
                            </div>
                            <div class="card-body">

                                <div class="col-md-4 form-group">
                                    <label for="date">Date<span class="text-red-600">*</span></label>
                                    <input id="date" class="form-control" value="{{($transaction->date)}}" required="required" name="date"
                                           type="date">
                                </div>

                                <div class="form-group mt-3 ">
                                    <label for="purpose">Purpose</label>
                                    <input type="hidden" name="purpose" value="{{ $transaction->purpose }}">
                                    <select  id="purpose"
                                            class="form-select @error('purpose') is-invalid @enderror" disabled>
                                        <option value="1" {{ $transaction->purpose == 1 ? 'selected' : '' }}>Withdraw</option>
                                        <option value="2" {{ $transaction->purpose == 2 ? 'selected' : '' }}>Deposit</option>
                                        <option value="3" {{ $transaction->purpose == 3 ? 'selected' : '' }}>Received Payment</option>
                                        <option value="4" {{ $transaction->purpose == 4 ? 'selected' : '' }}>Given Payment</option>
                                    </select>
                                    @error('purpose')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3 ">
                                    <label for="account">Account</label>
                                    <select name="account_id" id="account"
                                            class="form-select @error('account') is-invalid @enderror">
                                        <option value="">--Select account--</option>
                                        @forelse ($accounts as $account)
                                            <option value="{{ $account->id }}" {{ $account->id == $transaction->account_id ? 'selected' : '' }}>{{ $account->account_no }}</option>
                                        @empty
                                            <option>{{$account->account_no}}</option>
                                        @endforelse
                                    </select>
                                    @error('account_id')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="amount">Amount @if($balance !== null ) <span class="text-info" id="balance" >( {{ $balance }} )</span> @endif </label>
                                    <input type="text" name="amount" id="amount"
                                           class="form-control @error('amount') is-invalid @enderror" value="{{ ($transaction->amount)}}">
                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                @if($transaction->purpose == 3 || $transaction->purpose == 4)
                                <div class="form-group mt-3" id="paymentTypeSelect">
                                    <label for="paymentTypeSelect">Payment Type</label>
                                    <input type="hidden" name="payment_type" value="{{($transaction->payment_type)}}">
                                    <select  id="paymentTypeSelect" disabled
                                            class="form-select @error('payment_type') is-invalid @enderror">
                                        <option value="">--Select type--</option>
                                        <option value="1" {{ $transaction->payment_type == 1 ? 'selected' : '' }}>Cheque</option>
                                        <option value="2" {{ $transaction->payment_type == 2 ? 'selected' : '' }}>Cash</option>
                                    </select>
                                    @error('payment_type')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @endif

                                @if($transaction->payment_type == 1)
                                <div class="form-group mt-3" id="chequeNumber" >
                                    <label for="cheque_number">Cheque Number</label>
                                    <input type="text" name="cheque_number" id="cheque_number"
                                           class="form-control @error('cheque_number') is-invalid @enderror"
                                           value="{{ ($transaction->cheque_number) }}">
                                    @error('cheque_number')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @endif



                                <div class="form-group mt-3">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" name="remarks" id="remarks"
                                           class="form-control @error('remarks') is-invalid @enderror"
                                           value="{{ ($transaction->remarks) }}">
                                    @error('remarks')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                @if($transaction->payment_type == 2)
                                <div class="form-group mt-3" id="cashDetails">
                                    <label for="cash_details">Cash Details</label>
                                    <textarea type="text" name="cash_details" id="cash_details"
                                              class="form-control @error('cash_details') is-invalid @enderror"
                                    >{!! $transaction->cash_details !!}</textarea>
                                    @error('cash_details')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                @endif


                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-sm btn-info text-white">Update</button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <div class="mb-5"></div>
        </div>
    </div>

    @push('js')

        {{--<script>--}}
            {{--$(document).ready(function () {--}}
                {{--// Hide field--}}
                {{--$('#paymentType').hide();--}}
                {{--$('#chequeNumber').hide();--}}
                {{--$('#cashDetails').hide();--}}

                {{--let paymentType = $('#paymentTypeSelect').val();--}}
                {{--let chequeNumber = $('#cheque_number').val();--}}
                {{--let cashDetails = $('#cashDetails').val();--}}

                {{--if(paymentType == 1 || paymentType == 2) {--}}
                    {{--$('#chequeNumber').show();--}}
                    {{--$('#paymentType').hide();--}}
                    {{--$('#cashDetails').hide();--}}
                {{--}--}}
                {{--if(paymentType == 3 || paymentType == 4) {--}}
                    {{--$('#paymentType').show();--}}
                    {{--$('#chequeNumber').hide();--}}
                {{--}--}}

                {{--if(paymentType == 1) {--}}
                    {{--$('#chequeNumber').show();--}}
                    {{--$('#cashDetails').hide();--}}
                {{--}--}}
                {{--if(paymentType == 2) {--}}
                    {{--$('#cashDetails').show();--}}
                    {{--$('#cashDetails').hide();--}}
                {{--}--}}

                {{--// On Change--}}
                {{--$('#purpose').on('change', function() {--}}
                    {{--if(this.value == 1 || this.value == 2) {--}}
                        {{--$('#chequeNumber').show();--}}
                        {{--$('#paymentType').hide();--}}
                        {{--$('#cashDetails').hide();--}}
                    {{--}--}}
                    {{--if(this.value == 3 || this.value == 4) {--}}
                        {{--$('#paymentType').show();--}}
                        {{--$('#chequeNumber').hide();--}}
                    {{--}--}}
                {{--});--}}
                {{--$('#paymentTypeSelect').on('change', function(){--}}
                    {{--if(this.value == 1) {--}}
                        {{--$('#chequeNumber').show();--}}
                        {{--$('#cashDetails').hide();--}}
                    {{--}--}}
                    {{--if(this.value == 2) {--}}
                        {{--$('#cashDetails').show();--}}
                        {{--$('#chequeNumber').hide();--}}
                    {{--}--}}
                {{--});--}}
            {{--});--}}

        {{--</script>--}}
    @endpush
@endsection
