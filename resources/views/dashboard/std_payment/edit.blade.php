@extends('layouts.dashboard.app')

@section('title', 'Student Payment Edit')

@push('css')
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 200px;
        }
    </style>
@endpush

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0"><b>Edit student payment</b></p>
            <a href="{{route('admin.student.payment',$stdpayment->std_id)}}" class="btn btn-sm btn-info">Back</a>
        </div>
        <div class="card-body">
            <div>
                <form action="{{route('admin.student.payment.update',$stdpayment->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="std_id" value="{{ $stdpayment->std_id }}">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="month"><b>Month and Year</b><span style="color: red">*</span></label>
                            <input type="month" class="form-control" name="month" required value="{{ $stdpayment->month }}">
                            @error('month')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group" >
                            <label for="monthly_fee"><b>Monthly Fee</b></label>
                            <input type="number" name="monthly_fee" id="monthly_fee" class="m_fee form-control " value="{{ $stdpayment->student->monthly_fee }}" readonly>
                        </div>

                        @if($balance)
                            <div class="row mt-2">
                                <div class="col-12 mb-2">
                                    <div class="form-group">
                                        <label><b>Adjustment</b></label>
                                        <input class="form-check-input " type="checkbox" id="adjustment-btn" value="" checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group adjustment">
                                        <label><b>Adjustment Type</b></label>
                                        <select class="form-control" id="adjustment_type" name="adjustment_type"
                                                onchange="adjustmentBalanceCount()">
                                            <option value="" selected>--Select--</option>
                                            <option value="1" {{ $stdpayment->adjustment_type== 1 ? 'selected': '' }}>Addition</option>
                                            <option value="2" {{ $stdpayment->adjustment_type== 2 ? 'selected': '' }}>Subtraction</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group adjustment">
                                        <label><b>Adjustment Balance</b></label>
                                        <input type="number" name="adjustment_balance" id="adjustment_balance"
                                               class="form-control " value="{{ $stdpayment->adjustment_balance }}" placeholder="0.00"
                                               onkeyup="adjustmentBalanceCount()">
                                        @error('adjustment_balance')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label><b>Final Balance </b><span class="text-danger">*</span></label>
                                        <input type="hidden" value="" id="amount_balance">
                                        <input type="number" name="total_amount" id="total_amount" class="form-control "
                                               value="{{ $stdpayment->total_amount }}" placeholder="0.00" readonly >
                                        @error('total_amount')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mt-2 adjustment">
                                    <label for="description"><b>Adjustment Cuase</b></label>
                                    <textarea name="adjustment_cause" class="form-control" id="adjustment_cause" rows="4">{{ $stdpayment->adjustment_cause }}</textarea>
                                    @error('adjustment_cause')
                                    <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <div class="row mt-2">
                                <div class="col-12 mb-2">
                                    <div class="form-group">
                                        <label><b>Adjustment</b></label>
                                        <input class="form-check-input " type="checkbox" id="adjustment-btn" value="">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group adjustment" style="display: none">
                                        <label><b>Adjustment Type</b></label>
                                        <select class="form-control" id="adjustment_type" name="adjustment_type"
                                                onchange="adjustmentBalanceCount()">
                                            <option value="" selected>--Select--</option>
                                            <option value="1">Addition</option>
                                            <option value="2">Subtraction</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group adjustment" style="display: none">
                                        <label><b>Adjustment Balance</b></label>
                                        <input type="number" name="adjustment_balance" id="adjustment_balance"
                                               class="form-control " value="" placeholder="0.00"
                                               onkeyup="adjustmentBalanceCount()">
                                        @error('adjustment_balance')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label><b>Final Balance </b><span class="text-danger">*</span></label>
                                        <input type="hidden" value="" id="amount_balance">
                                        <input type="number" name="total_amount" id="total_amount" class="form-control "
                                               value="{{ $stdpayment->total_amount }}" placeholder="0.00" readonly >
                                        @error('total_amount')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mt-2 adjustment" style="display: none">
                                    <label for="description"><b>Adjustment Cause</b></label>
                                    <textarea name="adjustment_cause" class="form-control" id="adjustment_cause" rows="4"></textarea>
                                    @error('adjustment_cause')
                                    <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 form-group" id="paymentType">
                            <label for="paymentTypeSelect"><b>Payment Type</b><span style="color: red">*</span></label>
                            <select name="payment_type" id="paymentTypeSelect"
                                    class="form-select @error('payment_type') is-invalid @enderror">
                                <option value="">--Select type--</option>
                                <option value="1" @if($stdpayment->payment_type == 1) selected @endif>Cheque</option>
                                <option value="2" @if($stdpayment->payment_type == 2) selected @endif>Cash</option>
                            </select>
                            @error('payment_type')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group" id="accountId">
                            <label for="account">Account</label>
                            <select name="account_id" id="account"
                                    class="form-select @error('account_id') is-invalid @enderror" onchange="getAccountBalance()">
                                <option value="">--Select account--</option>
                                @forelse ($accounts as $account)
                                    <option value="{{ $account->id }}" @if($account->id == $stdpayment->account_id) {{'selected'}} @endif>{{ $account->account_no }}</option>
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

                        <div class="col-md-4 form-group" id="chequeNumber">
                            <label for="cheque_number">Cheque Number</label>
                            <input type="text" name="cheque_number" id="cheque_number"
                                   class="form-control @error('cheque_number') is-invalid @enderror"
                                   value="{{ $stdpayment->cheque_number }}" placeholder="Enter cheque number">
                            @error('cheque_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label for="note"> <b>Note</b></label>
                        <textarea name="note" class="form-control" id="note" cols="40" rows="6"></textarea>
                        @error('note')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
    @endpush
@endsection

@push('js')
    <script src="{{ asset('jquery/jQuery.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function () {
            if ($('#paymentTypeSelect').val() == 1){
                $('#accountId').show();
                $('#chequeNumber').show();
            }
            if ($('#paymentTypeSelect').val() == 2) {
                $('#accountId').hide();
                $('#chequeNumber').hide();
            }

            $('#paymentTypeSelect').on('change', function(){
                if(this.value == 1) {
                    $('#accountId').show();
                    $('#chequeNumber').show();
                }
                if(this.value == 2) {
                    $('#accountId').hide();
                    $('#chequeNumber').hide();
                }
            });
        })
    </script>

    <script>
        // var monthly_fee = $('#monthly_fee').val();
        // $('#total_amount').val(monthly_fee);

        // $("#monthly_fee").val(balance);
        // $("#total_amount").val(balance);

        $(document).on("click", "#adjustment-btn", function () {
            if ($('#adjustment-btn').is(":checked"))
                $(".adjustment").show();
            else
                $(".adjustment").hide();
            $('#adjustment_balance').val(0);
            adjustmentBalanceCount();
        });

        // Adjustment Balance Count
        function adjustmentBalanceCount() {
            var adjustmentType      =     document.getElementById('adjustment_type').value;
            var monthly_fee         =     document.getElementById('monthly_fee').value;
            var adjustmentBalance   =     document.getElementById('adjustment_balance').value;
            $("#total_amount").val(monthly_fee);
            var totalBalance = document.getElementById('total_amount').value;

            console.log(adjustmentType);
            if (adjustmentType == 1) {
                if (adjustmentBalance) {
                    var finalBalance = parseFloat(totalBalance) + parseFloat(adjustmentBalance);
                    $("#total_amount").val(finalBalance);
                }
            } else{
                if (adjustmentBalance) {
                    var finalBalance = parseFloat(totalBalance) - parseFloat(adjustmentBalance);
                    $("#total_amount").val(finalBalance);
                }
            }
        }
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#note'), {
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle',
                    'ImageToolbar', 'ImageUpload', 'MediaEmbed'
                ],
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        document.querySelector("input[type=number]")
            .oninput = e => console.log(new Date(e.target.valueAsNumber, 0, 1))
    </script>

@endpush
