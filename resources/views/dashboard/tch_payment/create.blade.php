@extends('layouts.dashboard.app')

@section('title', 'Teacher Payment Create')

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
            <p class="m-0"><b>Create teacher payment</b></p>
            <a href="{{route('admin.teacher.payment',$teacher->id)}}" class="btn btn-sm btn-info">Back</a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <form action="{{route('admin.tch-payment.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="tch_id" value="{{ $teacher->id }}">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="month"><b>Month and Year</b><span class="text-danger @error('month') is-invalid @enderror">*</span></label>
                            <input type="month" class="form-control" name="month" required value="{{ old('month') }}">
                            @error('month')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group" >
                            <label for="monthly_salary"><b>Monthly Salary</b></label>
                            <input type="number" id="monthly_salary" class="m_fee form-control " value="{{ $teacher->monthly_salary }}" readonly>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label><b>Adjustment</b></label>
                                    <input class="form-check-input " type="checkbox" id="adjustment-btn" value="">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group adjustment" style="display: none">
                                    <label><b>Adjustment Type<span style="color: red">*</span></b></label>
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
                                    <label><b>Adjustment Amount<span style="color: red">*</span></b></label>
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
                                    <label><b>Final Amount </b><span class="text-danger">*</span></label>
                                    <input type="number" name="total_amount" id="total_amount" class="form-control "
                                           value="{{old('total_amount')}}" placeholder="0.00" readonly >
                                    @error('total_amount')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mt-2 adjustment" style="display: none">
                                <label for="description"><b>Adjustment Cause <span style="color: red">*</span></b></label>
                                <textarea name="adjustment_cause" class="form-control" id="adjustment_cause" rows="4"></textarea>
                                @error('adjustment_cause')
                                <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 form-group" id="paymentType">
                            <label for="paymentTypeSelect"><b>Payment Type</b><span class="text-danger">*</span></label>
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

                        <div class="col-md-4 form-group" id="accountId">
                            <label for="account"><b>Account <span style="color: red">*</span></b> <span id="showHide">( <b>Available :</b> <b id="balance"> </b>)</span> </label>
                            <input type="hidden" id="current_balance" name="current_balance">
                            <select name="account_id" id="account"
                                    class="form-select @error('account_id') is-invalid @enderror" onchange="getAccountBalance()">
                                <option value="null">--Select account--</option>
                                @forelse ($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->account_no }} || {{ $account->account_holder }}</option>
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
                            <label for="cheque_number"><b>Cheque Number <span style="color: red">*</span></b> </label>
                            <input type="text" name="cheque_number" id="cheque_number"
                                   class="form-control @error('cheque_number') is-invalid @enderror"
                                   value="{{ old('cheque_number') }}" placeholder="Enter cheque number">
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
                        <button type="submit" class="btn btn-info">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@push('js')
    <script src="{{ asset('jquery/jQuery.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function () {
            $('#chequeNumber').hide();
            $('#accountId').hide();

            $('#paymentTypeSelect').on('change', function(){
                if(this.value == 1) {
                    $('#accountId').show();
                    $('#chequeNumber').show();
                }
                if(this.value == 2) {
                    $('#chequeNumber').hide();
                    $('#accountId').hide();
                    $('#showHide').hide();
                    $('#balance').empty();
                    $('#current_balance').empty();
                }
            });
        })

        var monthly_salary = $('#monthly_salary').val();
        $('#total_amount').val(monthly_salary);

        $(document).on("click", "#adjustment-btn", function () {
            if ($('#adjustment-btn').is(":checked"))
                $(".adjustment").show();
            else
                $(".adjustment").hide();
            $('#adjustment_balance').val(0);
            adjustmentBalanceCount();
        });

        $('#showHide').hide();
        function getAccountBalance() {
            var accountId = $('#account').val();
            if(accountId !== null){
                var url = '{{ route("admin.account-balance",":id") }}';
                $.ajax({
                    type: "GET",
                    url: url.replace(':id', accountId ),
                    dataType: 'Json',
                    success: function(data) {
                        $('#showHide').show();
                        $("#balance").empty();
                        $("#balance").append(data);
                        $("#current_balance").val(data);
                    }
                })
            }
        }

        // Adjustment Balance Count
        function adjustmentBalanceCount() {
            var adjustmentType     =  document.getElementById('adjustment_type').value;
            var monthly_salary     =  document.getElementById('monthly_salary').value;
            var adjustmentBalance  =  document.getElementById('adjustment_balance').value;
            $("#total_amount").val(monthly_salary);
            var totalBalance       =  document.getElementById('total_amount').value;

            if (adjustmentType == 1) {
                if (adjustmentBalance) {
                    var finalBalance = parseFloat(totalBalance) + parseFloat(adjustmentBalance);
                    $("#total_amount").val(finalBalance);
                }
            } else if (adjustmentType == 2) {
                if (adjustmentBalance) {
                    var finalBalance = totalBalance - adjustmentBalance;
                    $("#total_amount").val(finalBalance);
                }
            }
        }
    </script>

    {{--<script>--}}
        {{--var monthly_fee = $('#monthly_amount').val();--}}
        {{--$('#total_amount').val(monthly_fee);--}}

        {{--function extraAmount(){--}}
            {{--var extra_amount = $('#extra_amount').val() || 0;--}}
            {{--var monthly_fee = $('#monthly_amount').val();--}}
            {{--var discount_amount = $('#discount_amount').val() || 0;--}}
            {{--var subTotal= monthly_fee-discount_amount;--}}

            {{--var total = subTotal + parseFloat(extra_amount) ;--}}
            {{--$('#total_amount').val(total);--}}
        {{--}--}}

        {{--function discountAmount(){--}}
            {{--var extra_amount = $('#extra_amount').val() || 0;--}}
            {{--var monthly_fee = $('#monthly_amount').val();--}}

            {{--var subTotal = parseFloat(monthly_fee) + parseFloat(extra_amount) ;--}}

            {{--var total_amount = $('#total_amount').val();--}}
            {{--var discount_amount = $('#discount_amount').val();--}}

            {{--if(!discount_amount){--}}
                {{--discount_amount=0;--}}
            {{--}--}}

            {{--var total = subTotal - parseFloat(discount_amount) ;--}}
            {{--$('#total_amount').val(total);--}}
        {{--}--}}
    {{--</script>--}}
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
    {{-- <script>
        document.querySelector("input[type=number]")
            .oninput = e => console.log(new Date(e.target.valueAsNumber, 0, 1))
    </script> --}}

@endpush
@endsection
