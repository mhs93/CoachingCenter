@extends('layouts.dashboard.app')

@section('title', 'Create Student')

@push('css')
    {{-- Dropify CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
          integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
        .ck-editor__editable {
            min-height: 200px;
        }
    </style>
@endpush

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0"><b>Student Register</b></p>
            <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-info">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.students.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <p class="m-0">Default student Password: <b>student</b></p>
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

                                <div class="form-group">
                                    <label for="name"><b>Name</b><span style="color: red">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                        placeholder="Enter name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="reg_no"><b>Registration Number</b> <span style="color: red">*</span></label>
                                     <input type="text" name="reg_no" id="reg_no" readonly
                                        class="form-control @error('reg_no') is-invalid @enderror"
                                        value="{{$latestReg}}" placeholder="Enter registration number">
                                    @error('reg_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="email"><b>Email Address</b> <span style="color: red">*</span></label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Enter email address">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3 ">
                                    <label for="batch_id"><b>Batch</b> <span style="color: red">*</span></label>
                                    <select name="batch_id" id="batch_id"
                                        class="form-select @error('batch_id') is-invalid @enderror">
                                        <option value="">--Select batch--</option>
                                        @forelse ($batches as $batch)
                                            <option value="{{ $batch->id }}"
                                                @if (old('batch_id') == $batch->id) {{ 'selected' }} @endif>
                                                {{ $batch->name }}
                                            </option>
                                        @empty
                                            <option>--No batch--</option>
                                        @endforelse
                                    </select>
                                    @error('batch_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="initial_amount"><b>Initial Fee</b> <span style="color: red">*</span></label>
                                    <input type="text" name="initial_amount" id="initial_amount" value="{{old('initial_amount')}}"
                                        class="form-control @error('initial_amount') is-invalid @enderror" readonly>
                                    @error('initial_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                            <label><b>Adjustment Type <span style="color: red">*</span></b></label>
                                            <select class="form-control" id="adjustment_type" name="adjustment_type"
                                                    onchange="adjustmentBalanceCount()">
                                                <option value="" selected>--Select--</option>
                                                <option value="1"  @if (old('adjustment_type') == "1") {{ 'selected' }} @endif>Addition</option>
                                                <option value="2"  @if (old('adjustment_type') == "2") {{ 'selected' }} @endif>Subtraction</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group adjustment" style="display: none">
                                            <label><b>Adjustment Amount <span style="color: red">*</span></b></label>
                                            <input type="number" name="adjustment_balance" id="adjustment_balance"
                                                   class="form-control " value="{{old('adjustment_balance')}}" placeholder="0.00"
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
                                            <label><b>Final Amount <span style="color: red">*</span></b></label>
                                            <input type="hidden" value="" id="amount_balance">
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
                                        <textarea name="adjustment_cause" class="form-control" id="adjustment_cause" rows="4">
                                            {{ old('adjustment_cause') }}
                                        </textarea>
                                        @error('adjustment_cause')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="monthly_fee"><b>Monthly Fee</b> <span style="color: red">*</span></label>
                                    <input type="text" name="monthly_fee" id="monthly_fee" value="{{old('monthly_fee')}}"
                                               class="form-control @error('monthly_fee') is-invalid @enderror">
                                    @error('monthly_fee')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3 ">
                                    <label for="gender"><b>Gender</b> <span style="color: red">*</span></label>
                                    <select name="gender" id="gender" value="{{ old('gender') }}"
                                        class="form-select @error('gender') is-invalid @enderror">
                                        <option value="">--Select gender--</option>
                                        <option value="1" @if (old('gender') == "1") {{ 'selected' }} @endif>Male</option>
                                        <option value="2" @if (old('gender') == "2") {{ 'selected' }} @endif>Female</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{--<div class="form-group mt-3 ">--}}
                                    {{--<label for="dob"><b>Date Of Birth</b> <span style="color: red">*</span></label>--}}
                                    {{--<input type="date" name="dob">--}}
                                    {{--@error('dob')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@enderror--}}
                                {{--</div>--}}

                                <div class="form-group mt-3">
                                    <label for="contact_number"><b>Contact Number</b> <span style="color: red">*</span></label>
                                    <input type="text" name="contact_number" id="contact_number"
                                        class="form-control @error('contact_number') is-invalid @enderror"
                                        value="{{ old('contact_number') }}" placeholder="Enter contact number">
                                    @error('contact_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="parent_information"><b>Father/Mother Name</b> <span style="color: red">*</span></label>
                                    <input type="text" name="parent_information" id="parent_information"
                                           class="form-control @error('parent_information') is-invalid @enderror"
                                           value="{{ old('parent_information') }}" placeholder="Enter parent information">
                                    @error('parent_information')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="parent_contact"><b>Father/Mother Contact Number</b> <span style="color: red">*</span></label>
                                    <input type="text" name="parent_contact" id="parent_contact"
                                        class="form-control @error('parent_contact') is-invalid @enderror"
                                        value="{{ old('parent_contact') }}" placeholder="Enter parent contact number">
                                    @error('parent_contact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                        <label for="guardian_information"><b>Guardian Name</b> <span style="color: red">*</span></label>
                                        <input type="text" name="guardian_information" id="guardian_information"
                                               class="form-control @error('guardian_information') is-invalid @enderror"
                                               value="{{ old('guardian_information') }}" placeholder="Enter guardian information">
                                        @error('guardian_information')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                </div>

                                <div class="form-group mt-3">
                                        <label for="guardian_contact"><b>Guardian Contact Number</b> <span style="color: red">*</span></label>
                                        <input type="text" name="guardian_contact" id="guardian_contact"
                                               class="form-control @error('guardian_contact') is-invalid @enderror"
                                               value="{{ old('guardian_contact') }}" placeholder="Enter guardian contact number">
                                        @error('guardian_contact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="current_address"><b>Current Address</b> <span style="color: red">*</span></label>
                                    <textarea name="current_address" id="current_address" rows="3"
                                        class="form-control @error('current_address') is-invalid @enderror" placeholder="Current Address...">{{ old('current_address') }}</textarea>
                                    @error('current_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="permanent_address"><b>Permanent address</b> <span style="color: red">*</span></label>
                                    <textarea name="permanent_address" id="permanent_address" rows="3"
                                        class="form-control @error('permanent_address') is-invalid @enderror" placeholder="Permanent address...">{{ old('permanent_address') }}</textarea>
                                    @error('permanent_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="description"><b>Student Note</b></label>
                                    <textarea name="note" class="form-control" id="note" cols="40" rows="6"></textarea>
                                    @error('note')
                                        <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mt-3 ">
                                    <button type="submit" class="btn btn-sm btn-primary" style="float: right">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <b>Image upload</b>
                            </div>
                            <div class="card-body">
                                <div class="form-group mt-3">
                                    <input type="file" id="profile" name="profile"
                                        class="dropify form-control @error('profile') is-invalid @enderror">
                                    @error('profile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{--<div class="form-group mt-3 ">--}}
                                    {{--<button type="submit" class="btn btn-sm btn-primary">Save</button>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="mb-5"></div>
        </div>
    </div>
@endsection

@push('js')
    {{-- Dropify CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- Ck Editor CDN --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>

    <script>
        $(document).on("change", "#batch_id", function () {
            let batch_id = $(this).val();
            $.ajax({
                url: "{{ route('admin.student.getBatchFee') }}",
                type: 'get',
                data: { batchId: batch_id},
                success: function(response) {
                    let balance = 0;
                    console.log(response.status);
                    if(response.status == true){
                        let result = response.data;
                        balance = result.total_amount;
                    }
                    else{
                        balance = 0;
                    }
                    $("#initial_amount").val(balance);
                    $("#total_amount").val(balance);
                }
            });
        });

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
            var adjustmentType    =     document.getElementById('adjustment_type').value;
            var initialAmount     =     document.getElementById('initial_amount').value;
            var adjustmentBalance =     document.getElementById('adjustment_balance').value;
            $("#total_amount").val(initialAmount);
            var totalBalance = document.getElementById('total_amount').value;

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

    <script>
        ClassicEditor
            .create(document.querySelector('#note'), {
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
