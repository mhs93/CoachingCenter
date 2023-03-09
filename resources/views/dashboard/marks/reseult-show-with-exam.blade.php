@extends('layouts.dashboard.app')

@section('title', 'Showing Result')

@push('css')

@endpush

@section('content')
    @include('layouts.dashboard.partials.alert')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="m-0">Result Show</p>
                        <a href="{{ route('admin.marks.index') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group mt-3">
                                <label for="batch"><b>Select Exam <span style="color:red;">*</span></b> </label>
                                <select name="exam_id" id="examIdEx"
                                    class="form-control @error('exam_id') is-invalid @enderror">
                                    <option value="">--Select Exam--</option>
                                    @forelse ($exams as $item)
                                        <option vname="{{$item->name}}" value="{{ $item->id }}">{{ $item->name }}</option>
                                    @empty
                                        <option>No Exam</option>
                                    @endforelse
                                </select>
                                @error('exam_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="batch"><b>Select Batch <span style="color:red;">*</span></b></label>
                                <select name="batch_id" id="batchIdEx"
                                    class="form-control @error('batch_id') is-invalid @enderror">
                                </select>
                                @error('batch_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mt-3 col-md-12" id="subForm" >
                        </div>

                        <div class="print">
                            <span id="printButton"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="mb-5"></div>

    @push('js')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var exam_id='';
            $('#examIdEx').on('change', function() {
                $('#subForm').hide();
                exam_id = $(this).val();
                $("#batchIdEx").empty();
                $.ajax({
                    url: "{{ route('admin.marks.getBatches') }}",
                    type: 'post',
                    data: { examId: exam_id},
                    success: function(response) {
                        $("#batchIdEx").append('<option value="">--Select Batch--</option>');
                        $.each(response, function(key, value) {
                            $("#batchIdEx").append(
                                '<option value="' + value.batch.id + '">' + value.batch.name + '</option>');
                        });
                    }
                });
            });

            var batch_id = '';
            $('#subForm').hide();
            $('.print').hide();
            $(document).ready(function() {
                $('#batchIdEx').on('change', function() {
                    $('#subForm').show();
                    $('.print').show();
                    batch_id = $(this).val();

                    $("#subForm").empty();
                    $.ajax({
                        url: "{{ route('admin.result.get-Results') }}",
                        type: 'post',
                        data: { batchId: batch_id, examId: exam_id},
                        success: function(response) {
                            var print_url = "marks/resultPDF" + "/" + exam_id + "/" + batch_id;
                            var pdf_url = "marks/pdf-generate-for-mark" + "/" + exam_id + "/" + batch_id;
                            $('#subForm').html(response);
                        }
                    });
                });
            });

        </script>
    @endpush
@endsection
