@extends('layouts.dashboard.app')

@section('title', 'Create Mark')

@push('css')
    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 200px;
        }
    </style>
@endpush

@section('content')
    @include('layouts.dashboard.partials.alert')
    <form action="{{ route('admin.marks.store') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="m-0">Create Exam Marks</p>
                        <a href="{{ route('admin.marks.index') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group mt-3">
                                <label for="batch"><b>Select Exam</b>  <span style="color: red">*</span></label>
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
                                <label for="batch"><b>Select Batch</b> <span style="color: red">*</span></label>
                                <select name="batch_id" id="batchIdEx"
                                    class="form-control @error('batch_id') is-invalid @enderror">
                                </select>
                                @error('batch_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- Dependancy End for Batch Wise Exam --}}


                            <div class="form-group mt-3 col-md-12">
                                <div class="form-group">
                                    <label for="status"><b>Select Status</b> <span style="color: red">*</span></label>
                                    <select name="status" id="status"  class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Sub-Form Start --}}
                        <div class="form-group mt-3 col-md-12" id="subForm" >
                        </div>
                        {{-- Sub-Form End --}}

                        <div class="form-group mt-3">
                            <label for="note"><b>Exam Note</b></label>
                            <textarea name="note" class="form-control" id="note" cols="40" rows="6"></textarea>
                            @error('note')
                            <span class="text-danger" role="alert">
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

    @push('js')
        {{-- Select2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        {{-- Ckeditor5 --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Dependancy for batch wise exams
            $('#examIdEx').on('change', function() {
                let exam_id = $(this).val();
                $("#batchIdEx").empty();
                $.ajax({
                    url: "{{ route('admin.marks.getBatches') }}",
                    type: 'post',
                    data: { examId: exam_id},
                    success: function(response) {
                        $("#batchIdEx").append(
                            '<option value=""> --Select Exam-- </option>'
                        );
                        $.each(response, function(key, value) {
                            console.log(value);
                            // $("#batchIdEx").append('<option value="' + value
                            // .id + '">' + value.name + '</option>');
                            $("#batchIdEx").append(
                                '<option value="' + value.batch.id + '">' + value.batch.name + '</option>'
                            );
                        });
                    }
                });
            });

            $('#subForm').hide();
            $(document).ready(function() {
                // Dependancy for batch and subjects
                $('#batchIdEx').on('change', function() {
                    $('#subForm').show();
                    let batch_id = $(this).val();
                    $("#subForm").empty();
                    $.ajax({
                        url: "{{ route('admin.marks.getSubjects') }}",
                        type: 'post',
                        data: { batchId: batch_id},
                        success: function(response) {
                            $('#subForm').html(response);
                        }
                    });
                });
                // Dependancy End

                // CKEditor
                ClassicEditor.create(document.querySelector('#note'), {
                    removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
                })
                .catch(error => {
                    console.error(error);
                });
            });
        </script>
    @endpush
@endsection
