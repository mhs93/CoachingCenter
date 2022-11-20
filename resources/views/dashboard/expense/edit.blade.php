@extends('layouts.dashboard.app')

@section('title', 'Expense edit')

@push('css')
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 320px;
        }
    </style>
@endpush

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Edit Expense</p>
            <a href="{{route('admin.expense.index')}}" class="btn btn-sm btn-info">Back</a>
        </div>
        <div class="card-body">
            <div>
                <form action="{{route('admin.expense.update',$expense->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4 form-group mt-2">
                            <label for="expense_purpose"><b>Expense Purpose</b><span class="text-danger"> <b>*</b></span> </label>
                            <input type="text" class="form-control @error('expense_purpose') is-invalid @enderror" name="expense_purpose" value="{{ $expense->expense_purpose }}">
                            @error('expense_purpose')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group mt-2" id="paymentType">
                            <label for="paymentTypeSelect"><b>Payment Type</b><span class="text-danger"> <b>*</b></span></label>
                            <select name="payment_type" id="paymentTypeSelect"
                                    class="form-select @error('payment_type') is-invalid @enderror">
                                <option value="">--Select type--</option>
                                <option value="1" @if($expense->payment_type == 1) selected @endif>Cheque</option>
                                <option value="2" @if($expense->payment_type == 2) selected @endif>Cash</option>
                            </select>
                            @error('payment_type')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group mt-2" id="accountId">
                            <label for="account"><b>Select Account</b> <span class="text-danger"> <b>*</b></span></label>
                            <select name="account_id" id="account"
                                    class="form-select @error('account_id') is-invalid @enderror" onchange="getAccountBalance()">
                                <option value="null">--Select account--</option>
                                @forelse ($accounts as $account)
                                    <option value="{{ $account->id }}" @if($account->id == $expense->account_id) {{'selected'}} @endif>{{ $account->account_no }} || {{ $account->account_holder }}</option>
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

                        <div class="col-md-4 mt-2">
                            <div class="form-group">
                            <label for="amount"><b>Amount</b> <span id="showHide">( Available : <b id="balance"> </b> )</span> <span class="text-danger"><b>*</b></span></label>
                            <input type="hidden" id="current_balance" name="current_balance">
                            <input oninput="validationCheck()" name="amount" type="number" id="amount" value="{{ $expense->amount }}" class="form-control t_amount @error('amount') is-invalid @enderror" placeholder="Enter expense amount" required>

                            @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        </div>

                        <div class="col-md-4 form-group mt-2" id="chequeNumber">
                            <label for="cheque_number"><b>Cheque Number</b><span class="text-danger"> <b>*</b></span></label>
                            <input type="text" name="cheque_number" id="cheque_number"
                                   class="form-control @error('cheque_number') is-invalid @enderror"
                                   value="{{ $expense->cheque_number }}" placeholder="Enter cheque number">
                            @error('cheque_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label for="note"><b>Note</b> </label>
                        <textarea name="note" class="form-control" id="note"  cols="40" rows="6">{{ $expense->note }}</textarea>
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
    <script src="{{ asset('jquery/jQuery.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function () {
            if ($('#paymentTypeSelect').val() == 1){
                $('#accountId').show();
                $('#chequeNumber').show();
            }
            if ($('#paymentTypeSelect').val() == 2) {
                $('#chequeNumber').hide();
                    $('#accountId').hide();
                    $('#showHide').hide();
                    $('#balance').empty();
                    $('#current_balance').empty();
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


            var accountId = $('#account').val();
                if(accountId !== null){
                    var url = '{{ route("admin.account-balance",":id") }}';
                    $.ajax({
                        type: "GET",
                        url: url.replace(':id', accountId ),
                        dataType: 'Json',
                        success: function(data) {
                            $('#showHide').show();
                            $("#balance").append(data);
                            $("#current_balance").val(data);
                        }
                    })
                 }

       //get account current balance
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

            function validationCheck(){
                    var transaction_amount = $('#amount').val();
                    var balance = $('#current_balance').val();
                    var available_balance = parseFloat(balance);
                    var amount = parseFloat(transaction_amount);

                    if(available_balance < amount){
                        swal({
                        title: 'Error!!!',
                        text: "Whoops! Expense amount is more than available amount",
                        dangerMode: true,
                        });
                        $('#amount').val(null);
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
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
    {{-- <script>
        document.querySelector("input[type=number]")
            .oninput = e => console.log(new Date(e.target.valueAsNumber, 0, 1))
    </script> --}}

@endpush
@endsection
