@extends('layouts.dashboard.app')

@section('title', 'create bank transaction')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
          integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
    </style>
@endpush

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.transaction.index') }}">Transaction List</a>

            </li>
        </ol>

    </nav>
@endsection

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Create</p>
            <a href="{{route('admin.transaction.index')}}" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.transaction.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <p class="m-0">Create Transaction</p>
                            </div>
                            <div class="card-body">

                                <div class="col-md-4 form-group">
                                    <label for="date">Date<span class="text-red-600">*</span></label>
                                    <input id="date" class="form-control" placeholder="" required="required" name="date"
                                           type="date">
                                </div>

                                <div class="form-group mt-3 ">
                                    <label for="purpose">Purpose</label>
                                    <select name="purpose" id="purpose"
                                            class="form-select @error('purpose') is-invalid @enderror">
                                        <option value="0">--Select purpose--</option>
                                        <option value="1">Withdraw</option>
                                        <option value="2">Deposit</option>
                                        <option value="3">Received Payment</option>
                                        <option value="4">Given Payment</option>
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
                                            class="form-select @error('account') is-invalid @enderror" onchange="getAccountBalance()">
                                        <option value="">--Select account--</option>
                                        @forelse ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->account_no }}</option>
                                        @empty
                                            <option>--No account--</option>
                                        @endforelse
                                    </select>
                                    @error('account_id')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="amount">Amount <span class="text-info" id="balance" style="display: none"></span></label>
                                    <input type="text" name="amount" id="amount"
                                           class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}"
                                           placeholder="Enter amount">
                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3" id="paymentType">
                                    <label for="paymentTypeSelect">Payment Type</label>
                                    <select name="payment_type" id="paymentTypeSelect"
                                            class="form-select @error('payment_type') is-invalid @enderror">
                                        <option value="">--Select type--</option>
                                        <option value="1">Cheque</option>
                                        <option value="2">Cash</option>
                                    </select>
                                    @error('payment_type')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3" id="chequeNumber">
                                    <label for="cheque_number">Cheque Number</label>
                                    <input type="text" name="cheque_number" id="cheque_number"
                                           class="form-control @error('cheque_number') is-invalid @enderror"
                                           value="{{ old('cheque_number') }}" placeholder="Enter cheque number">
                                    @error('cheque_number')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3" id="cashDetails">
                                    <label for="cash_details">Cash Details</label>
                                    <input type="text" name="cash_details" id="cash_details"
                                           class="form-control @error('cash_details') is-invalid @enderror"
                                           value="{{ old('cash_details') }}" placeholder="Enter cash details">
                                    @error('cash_details')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" name="remarks" id="remarks"
                                           class="form-control @error('remarks') is-invalid @enderror"
                                           value="{{ old('remarks') }}" placeholder="Enter remarks">
                                    @error('remarks')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
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
        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
    @endpush

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
            integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor.create(document.querySelector('#cash_details'), {
            removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
        })
            .catch(error => {
                console.error(error);
            });
    </script>


    <script>
        $(document).ready(function() {
            // Hide field
            $('#paymentType').hide();
            $('#chequeNumber').hide();
            $('#cashDetails').hide();

            $('#purpose').on('change', function() {
                if(this.value == 1 || this.value == 2) {
                    $('#chequeNumber').show();
                    $('#paymentType').hide();
                    $('#cashDetails').hide();
                }
                if(this.value == 3 || this.value == 4) {
                    $('#paymentType').show();
                    $('#chequeNumber').hide();
                }
            });
            $('#paymentTypeSelect').on('change', function(){
                if(this.value == 1) {
                    $('#chequeNumber').show();
                    $('#cashDetails').hide();
                }
                if(this.value == 2) {
                    $('#cashDetails').show();
                    $('#chequeNumber').hide();
                }
            });
        });
    </script>

    <script>
        function getAccountBalance() {
            var transactionWay = $('#purpose').val();
            var accountId = $('#account').val();
            if(accountId !== null){
                if(transactionWay == 1 || transactionWay == 4){
                    var url = '{{ route("admin.account-balance",":id") }}';
                    $.ajax({
                        type: "GET",
                        url: url.replace(':id', accountId ),
                        success: function (resp) {
                            $('#balance').show();
                            document.getElementById('balance').innerHTML = '( '+resp+' )';
                            $('#amount_balance').val(resp);
                            document.getElementById('amount').max = resp;
                        }, // success end
                        error: function (error) {
                            // location.reload();
                        } // Error
                    })
                }else {
                    $('#balance').hide();
                }
            }
        }
    </script>
@endpush
