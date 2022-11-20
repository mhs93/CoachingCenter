@extends('layouts.dashboard.app')

@section('title', 'Showing Result')

@push('css')

@endpush

@section('content')
    @include('layouts.dashboard.partials.alert')
    {{-- <form action="{{ route('admin.marks.store') }}" enctype="multipart/form-data" method="POST">
        @csrf --}}
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
                                <label for="batch"><b>Select Exam</b> </label>
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

                            {{-- Dependancy Start for Batch Wise Exam --}}
                            <div class="form-group mt-3">
                                <label for="batch"><b>Select Batch</b></label>
                                <select name="batch_id" id="batchIdEx"
                                    class="form-control @error('batch_id') is-invalid @enderror">
                                    {{-- <option value="">--Select Batch--</option> --}}
                                </select>
                                @error('batch_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- Dependancy End for Batch Wise Exam --}}
                        </div>


                        {{-- Sub-Form Start --}}
                        <div class="form-group mt-3 col-md-12" id="subForm" >
                        </div>
                        {{-- Sub-Form End --}}

                        {{-- <div class="form-group mt-3" id="deleteResult">
                            <a href="" class="btn btn-sm btn-danger">Delete</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    {{-- </form> --}}
    <div class="mb-5"></div>

    @push('js')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Dependancy for batch wise exams
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
                        $.each(response, function(key, value) {
                            $("#batchIdEx").append(
                                '<option value=""> --Select Batch-- </option>'+
                                '<option value="' + value.batch.id + '">' + value.batch.name + '</option>');
                        });
                    }
                });
            });
            // data: { batchId: batch_id, examId: exam_id},
            var batch_id = '';
            $('#subForm').hide();
            $(document).ready(function() {
                // Dependancy for batch and subjects
                $('#batchIdEx').on('change', function() {
                    $('#subForm').show();
                    batch_id = $(this).val();
                    // let batch_id = $(this).val();
                    $("#subForm").empty();
                    $.ajax({
                        url: "{{ route('admin.result.getResults') }}",
                        type: 'post',
                        // data: { batchId: batch_id},
                        data: { batchId: batch_id, examId: exam_id},
                        success: function(response) {
                            $('#subForm').html(response);
                        }
                    });
                });
                // Dependancy End

                // PDF

                $('#exportPDF').on('change', function() {

                    $("#subForm").empty();
                    $.ajax({
                        url: "{{ route('admin.result.resultPDF') }}",
                        type: 'post',
                        // data: { batchId: batch_id},
                        data: { batchId: batch_id, examId: exam_id},
                        success: function(response) {
                            $('#subForm').html(response);
                        }
                    });
                });
            });

        </script>
    @endpush
@endsection
