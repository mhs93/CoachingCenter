@extends('layouts.dashboard.app')

@section('title', 'teacher payment create')

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
            <p class="m-0">Create teacher payment</p>
            <a href="{{route('admin.teacher.payment',$teacher->id)}}" class="btn btn-sm btn-info">Back</a>
        </div>
        <div class="card-body">
            <div>
                <form action="{{route('admin.tch-payment.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="tch_id" value="{{ $teacher->id }}">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="month">Month and Year<span class="text-red-600 @error('month') is-invalid @enderror">*</span></label>
                            <input type="month" class="form-control" name="month" required value="{{ old('month') }}">
                            @error('month')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group" >
                            <label for="monthly_fee">Monthly Fee</label>
                            <input type="number" id="monthly_amount" class="m_fee form-control " value="{{ $teacher->monthly_salary }}" readonly>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="additional_amount">Extra Amount</label>
                            <input name="additional_amount" oninput="extraAmount()" id="extra_amount" type="number" value="{{ old('additional_amount') }}" class="e_amount form-control @error('additional_amount') is-invalid @enderror">
                            @error('additional_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="discount_amount">Discount</label>
                            <input name="discount_amount" oninput="discountAmount()" id="discount_amount" type="number" value="{{ old('discount_amount') }}" class="form-control @error('discount_amount') is-invalid @enderror">
                            @error('discount_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 form-group" id="paymentType">
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

                        <div class="col-md-4 form-group" id="accountId">
                            <label for="account">Account</label>
                            <select name="account_id" id="account"
                                    class="form-select @error('account_id') is-invalid @enderror" onchange="getAccountBalance()">
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

                        <div class="col-md-4 form-group" id="chequeNumber">
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


                        <div class="col-md-4 form-group">
                            <lavel for="amount">Total Amount</lavel>
                            <input type="text" id="total_amount" class="t_amount form-control @error('total_amount') is-invalid @enderror" name="total_amount" value="{{old('total_amount')}}">
                            @error('total_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="note"> Note</label>
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
                }
            });
        })
    </script>

    <script>
        var monthly_fee = $('#monthly_amount').val();
        $('#total_amount').val(monthly_fee);

        function extraAmount(){
            var extra_amount = $('#extra_amount').val() || 0;
            var monthly_fee = $('#monthly_amount').val();
            var discount_amount = $('#discount_amount').val() || 0;
            var subTotal= monthly_fee-discount_amount;

            var total = subTotal + parseFloat(extra_amount) ;
            $('#total_amount').val(total);
        }

        function discountAmount(){
            var extra_amount = $('#extra_amount').val() || 0;
            var monthly_fee = $('#monthly_amount').val();

            var subTotal = parseFloat(monthly_fee) + parseFloat(extra_amount) ;

            var total_amount = $('#total_amount').val();
            var discount_amount = $('#discount_amount').val();

            if(!discount_amount){
                discount_amount=0;
            }

            var total = subTotal - parseFloat(discount_amount) ;
            $('#total_amount').val(total);
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
