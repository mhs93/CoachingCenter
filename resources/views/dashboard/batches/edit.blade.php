@extends('layouts.dashboard.app')

@section('title', 'Edit Batch')


@push('css')
    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- Dropify CDN --}}
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


@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.batches.index') }}">Batch List</a>

            </li>
        </ol>
        <a href="{{ route('admin.batches.index') }}" class="btn btn-sm btn-dark">Back to list</a>
    </nav>
@endsection

@section('content')

    @include('layouts.dashboard.partials.alert')
    <form action="{{ route('admin.batches.update', $batch->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="m-0">Edit Batch</p>
                        <a href="{{ route('admin.batches.index') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <input type="hidden" name="batch_id" id="batchId" value={{$batch->id}}>
                                <div class="form-group">
                                    <label for="batchname"><b>Batch name<span style="color: red">*</span></b> </label>
                                    <input type="text" class="form-control my-1" id="batchName" name="name" placeholder="Enter Batch Name" value="{{ $batch->name }}">
                                    <div id="validName" class="text-danger"></div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            @php
                                $subjectIds = json_decode($batch->subject_id);
                            @endphp
                            <div class="form-group col-md-6">
                                <label for="subject_id"><b>Select Subjects<span style="color: red">*</span></b></label>
                                @php
                                    $subjectIds = json_decode($batch->subject_id);
                                @endphp
                                <select name="subject_id[]" class="multi-subject form-control @error('subjects') is-invalid @enderror" multiple="multiple" id="subject_id">
                                    <option value="0"
                                            @if (in_array("0", $subjectIds))
                                                selected
                                            @endif
                                    >
                                        All Subject
                                    </option>
                                    @forelse ($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            @if(in_array($subject->id, $subjectIds))
                                                {{ "selected" }}
                                            @endif
                                        >
                                            {{ $subject->name }}
                                        </option>
                                    @empty
                                        <option>--No subject--</option>
                                    @endforelse
                                </select>
                                @error('subject_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="initial_amount"><b>Initial Batch Fee<span style="color: red">*</span></b></label>
                                <input type="number" readonly class="form-control my-1" id="initial_balance" value="{{ $batch->initial_amount }}"  name="initial_amount">
                                @error('initial_amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if($balance)
                            <div class="row mt-2">
                                <div class="col-4">
                                    <div class="form-group adjustment">
                                        <label><b>Adjustment Type<span style="color: red">*</span></b></label>
                                        <select class="form-control" id="adjustment_type" name="adjustment_type"
                                                onchange="adjustmentBalanceCount()">
                                            <option value="" selected>--Select--</option>
                                            <option value="1" {{ $batch->adjustment_type== 1 ? 'selected': '' }}>Addition</option>
                                            <option value="2" {{ $batch->adjustment_type== 2 ? 'selected': '' }}>Subtraction</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group adjustment">
                                        <label><b>Adjustment Balance<span style="color: red">*</span></b></label>
                                        <input type="number" name="adjustment_balance" id="adjustment_balance"
                                            class="form-control " value="{{ $batch->adjustment_balance }}" placeholder="0.00"
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
                                        <label><b>Final Balance<span style="color: red">*</span></b></label>
                                        <input type="hidden" value="" id="amount_balance">
                                        <input type="number" name="total_amount" id="total_amount" class="form-control "
                                            value="{{ $batch->total_amount }}" placeholder="0.00" readonly >
                                        @error('total_amount')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mt-2 adjustment">
                                    <label for="description"><b>Adjustment Cuase<span style="color: red">*</span></b></label>
                                    <textarea name="adjustment_cause" class="form-control" id="adjustment_cause" rows="4">{{ $batch->adjustment_cause }}</textarea>
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
                                        <label><b>Adjustment Balance<span style="color: red">*</span></b></label>
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
                                        <label><b>Final Balance<span style="color: red">*</span></b></label>
                                        <input type="hidden" value="" id="amount_balance">
                                        <input type="number" name="total_amount" id="total_amount" class="form-control "
                                            value="{{ $batch->total_amount }}" placeholder="0.00" readonly >
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

                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="start_time"><b>Start Date<span style="color: red">*</span></b></label>
                                <input type="date" name="start_date" class="form-control" value="{{ $batch->start_date }}">
                                @error('start_time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="end_time"><b>End Date<span style="color: red">*</span></b></label>
                                <input type="date" name="end_date" class="form-control" value="{{ $batch->end_date }}">
                                @error('end_time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="note"><b>Batch Note</b></label>
                                    <textarea name="note" class="form-control" id="note" cols="30" rows="10">{{ $batch->note }}</textarea>
                                    @error('note')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="image"><b>Batch Image<span style="color: red">*</span></b></label>
                                    <input type="file" id="image" name="image" data-default-file="{{asset('images/batches/'.$batch->image)}}"
                                           class="dropify form-control @error('image') is-invalid @enderror">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
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
        {{-- Select2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
                integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
                crossorigin="anonymous" referrerpolicy="no-referrer">
        </script>
        <script>
            $(document).ready(function() {
                $('.dropify').dropify();
            });
        </script>

        <script>
            $('.multi-subject').select2();
            $(document).on("change", "#subject_id", function () {
                let value = $(this).val();
                console.log(value.includes("0"))
                if(value.includes("0")){
                    $(this).empty();
                    $(this).append('<option selected value="0">All Subject</option>');
                }
                if(value == ''){
                    $("#subject_id").empty();
                    $.ajax({
                        url: "{{ route('admin.batch.getAllSubject') }}",
                        type: 'get',
                        success: function(response) {
                            $("#subject_id").append('<option value="0">All Subject</option>');
                            $.each(response, function(key, value) {
                                console.log(value.id)
                                $("#subject_id").append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        }
                    });
                }

                // Batch Fee
                let subject_id = $(this).val();

                $.ajax({
                    url: "{{ route('admin.batch.getSubjectFee') }}",
                    type: 'get',
                    data: { subjectId: subject_id},
                    success: function(response) {
                        console.log(response);
                        let balance = 0;
                        console.log(response.status);
                        if(response.status == true){

                            let result = response.data;
                            for(let i=0; i<result.length; i++){
                                balance+= parseFloat(result[i].fee)
                            }
                        }
                        else if(response.status == 'fee'){
                            balance = response.data;
                        }
                        else{
                            balance = 0;
                        }
                        $("#initial_balance").val(balance);
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
