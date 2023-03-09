@extends('layouts.dashboard.app')

@section('title', 'Edit Student')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
          integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{route('admin.students.update',$student->id)}}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')
        <span id="reauth-email" class="reauth-email"></span>
        <input type="hidden" name="std_id" value="{{$student->id}}">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="m-0">Edit Student</p>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="name"><b>Name <span style="color: red">*</span></b> </label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ ($student->name) }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="reg_no"> <b>Registration Number <span style="color: red">*</span></b> </label>
                            <input type="text" name="reg_no" id="reg_no"
                                   class="form-control @error('reg_no') is-invalid @enderror"
                                   value="{{ ($student->reg_no) }}">
                            @error('reg_no')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="email"><b>Email Address <span style="color: red">*</span></b> </label>
                            <input type="email" name="email" id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ ($student->email) }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3 ">
                            <label for="batch_id"> <b>Batch <span style="color: red">*</span></b> </label>
                            <select name="batch_id" id="batch_id" class="form-select @error('batch') is-invalid @enderror">
                                <option>--Select batch--</option>

                                @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}"
                                    @if ($batch->id == $student->batch_id)
                                        {{ 'selected' }}
                                            @endif
                                    >
                                        {{ $batch->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('batch_id')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="initial_amount"><b>Initial Fee <span style="color: red">*</span></b></label>
                            <input type="text" name="initial_amount" id="initial_amount"
                                   class="form-control @error('initial_amount') is-invalid @enderror"
                                   value="{{ $student->initial_amount }}" readonly>
                            @error('initial_amount')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @if($balance)
                            <div class="row mt-2">
                                {{-- <div class="col-12 mb-2">
                                    <div class="form-group">
                                        <label><b>Adjustment</b></label>
                                        <input class="form-check-input " type="checkbox" id="adjustment-btn" value="">
                                    </div>
                                </div> --}}
                                <div class="col-4">
                                    <div class="form-group adjustment">
                                        <label><b>Adjustment Type <span style="color: red">*</span></b></label>
                                        <select class="form-control" id="adjustment_type" name="adjustment_type"
                                                onchange="adjustmentBalanceCount()">
                                            <option value="" selected>--Select--</option>
                                            <option value="1" {{ $student->adjustment_type== 1 ? 'selected': '' }}>Addition</option>
                                            <option value="2" {{ $student->adjustment_type== 2 ? 'selected': '' }}>Subtraction</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group adjustment">
                                        <label><b>Adjustment Balance</b></label>
                                        <input type="number" name="adjustment_balance" id="adjustment_balance"
                                               class="form-control " value="{{ $student->adjustment_balance }}" placeholder="0.00"
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
                                        <label><b>Final Balance <span style="color: red">*</span></b></label>
                                        <input type="hidden" value="" id="amount_balance">
                                        <input type="number" name="total_amount" id="total_amount" class="form-control "
                                               value="{{ $student->total_amount }}" placeholder="0.00" readonly >
                                        @error('total_amount')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mt-2 adjustment">
                                    <label for="description"><b>Adjustment Cuase<span style="color: red">*</span></b></label>
                                    <textarea name="adjustment_cause" class="form-control" id="adjustment_cause" rows="4">{{ $student->adjustment_cause }}</textarea>
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
                                        <label><b>Adjustment Type <span style="color: red">*</span></b></label>
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
                                        <label><b>Adjustment Balance <span style="color: red">*</span></b></label>
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
                                        <label><b>Final Balance <span style="color: red">*</span></b></label>
                                        <input type="hidden" value="" id="amount_balance">
                                        <input type="number" name="total_amount" id="total_amount" class="form-control "
                                               value="{{ $student->total_amount }}" placeholder="0.00" readonly >
                                        @error('total_amount')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mt-2 adjustment" style="display: none">
                                    <label for="description"><b>Adjustment Cuase<span style="color: red">*</span></b></label>
                                    <textarea name="adjustment_cause" class="form-control" id="adjustment_cause" rows="4"></textarea>
                                    @error('adjustment_cause')
                                    <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="form-group mt-3">
                            <label for="monthly_fee"><b>Monthly Fee<span style="color: red">*</span></b></label>
                            <input type="text" name="monthly_fee" id="monthly_fee" value="{{ ($student->monthly_fee) }}"
                                   class="form-control @error('monthly_fee') is-invalid @enderror">
                            @error('monthly_fee')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3 ">
                            <label for="gender"><b>Gender <span style="color: red">*</span></b> </label>
                            <select name="gender" id="gender" value="{{ ($student->gender) }}"
                                    class="form-select @error('gender') is-invalid @enderror">
                                <option value="1" @if($student->gender == 1) selected @endif>Male</option>
                                <option value="2" @if($student->gender == 2) selected @endif>Female</option>
                            </select>
                            @error('gender')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="contact_number"><b>Contact Number<span style="color: red">*</span></b> </label>
                            <input type="text" name="contact_number" id="contact_number"
                                   class="form-control @error('contact_number') is-invalid @enderror"
                                   value="{{ ($student->contact_number) }}">
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
                                   value="{{ ($student->parent_information) }}" placeholder="Enter parent information">
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
                                   value="{{ ($student->parent_contact) }}" placeholder="Enter parent contact number">
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
                                   value="{{ $student->guardian_information }}" placeholder="Enter guardian information">
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
                                   value="{{ ($student->guardian_contact) }}" placeholder="Enter guardian contact number">
                            @error('guardian_contact')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="current_address"> <b>Current Address</b> </label>
                            <textarea name="current_address" id="current_address" rows="3"
                                      class="form-control @error('current_address') is-invalid @enderror"
                                      placeholder="Current Address..."> {{ ($student->current_address)}}</textarea>
                            @error('current_address')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="permanent_address"> <b>Permanent address</b> </label>
                            <textarea name="permanent_address" id="permanent_address" rows="3"
                                      class="form-control @error('permanent_address') is-invalid @enderror"
                                      placeholder="Permanent address...">{{ ($student->permanent_address)}}</textarea>
                            @error('permanent_address')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="description"><b>Student Note</b> </label>
                            <textarea name="note" class="form-control" id="note" cols="30" rows="10">{{ $student->note }}</textarea>
                            @error('description')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><b>Image upload</b></div>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <input type="file" id="profile"
                                   data-default-file="{{asset('images/users/'.$student->profile)}}"
                                   class="dropify form-control @error('profile') is-invalid @enderror" name="profile">
                            @error('profile')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="mb-5"></div>

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
                integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function () {
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


        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
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
@endsection
