@extends('layouts.dashboard.app')

@section('title', 'Create Resource')

@push('css')
    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
        .ck-editor__editable[role="textbox"] {
            min-height: 200px;
        }
    </style>
@endpush

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.resources.store') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="m-0">Upload Resource</p>
                        <a href="{{ route('admin.resources.index') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>
                    <div class="card-body">
                        {{-- Title --}}
                        <div class="form-group mt-3">
                            <label for="last_name"><B>Title</B> <b><span style="color: red">*</span></b> </label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                placeholder="Enter Title">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        {{-- Dependancy Start --}}
                        <div class="form-group mt-3">
                            <label for="batch"><B>Select Batch</B> <b><span style="color: red">*</span></b> </label>
                            <select name="batch_id[]" id="batchIdEx"
                                class="multi-batch mySelect2 form-control @error('batch_id') is-invalid @enderror"
                                multiple="multiple">
                                <option value="0">
                                    All Batch
                                </option>
                                @forelse ($batches as $item)
                                    <option value="{{ $item->id }}"
                                        @if (old("batch_id")) {{ (in_array($item->id, old("batch_id")) ? "selected":"") }}@endif>
                                        {{ $item->name }}
                                    </option>
                                @empty
                                    <option>No batch</option>
                                @endforelse
                            </select>
                            @error('batch_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Subjects --}}
                        <div class="form-group mt-3">
                            <label for="batch"><B>Select Subjects</B>  <b><span style="color: red">*</span></b> </label>
                            {{-- <select name="subject_id[]" id="subjectEx" class="form-control"> --}}
                            <select name="subject_id[]" id="subjectEx"
                                class="multi-subject mySelect2 form-control @error('subject_id') is-invalid @enderror"
                                multiple="multiple">

                                {{-- <option value="0">
                                    All Subject
                                </option> --}}
                            </select>
                            @error('subject_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Dependancy End --}}
                        <div class="form-group mt-3">
                            <label for="description"><B>Resource Note</B> </label>
                            <textarea name="note" class="form-control" id="note" cols="40" rows="6"></textarea>
                            @error('note')
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
                    <div class="card-header">
                        <b>Upload file</b>  <b><span style="color: red">*</span></b>
                    </div>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <input type="file" id="file"
                                class="dropify form-control @error('file') is-invalid @enderror" name="file" required>
                            @error('file')
                                <span class="invalid-feedback" role="alert">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
            integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        {{-- Select2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.multi-batch').select2();
                $('.multi-subject').select2();
            });
        </script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {
                $('.dropify').dropify();

                // Dependancy for batch and subjects
                $("#subjectEx").hide();
                $('#batchIdEx').on('change', function() {
                    let batch_id = $(this).val();
                    $("#subjectEx").show();
                    $("#subjectEx").append('<option value="0">All Subject</option>');
                    $.ajax({
                        url: "{{ route('admin.getSubjects') }}",
                        type: 'post',
                        data: { batchId: batch_id},
                        success: function(response) {
                            // $('#subject').html(response)
                            $.each(response, function(key, value) {
                                console.log(value.id)
                                $("#subjectEx").append('<option value="' + value
                                .id + '  ">' + value.name + '</option>');
                            });
                        }
                    });
                });

                // All Batch Validation
                $(document).on("change", "#batchIdEx", function () {
                    let value = $(this).val();
                    console.log(value.includes("0"))
                    if(value.includes("0")){
                        $(this).empty();
                        $(this).append('<option selected value="0">All Batch</option>');
                    }
                    if(value == ''){
                        $("#batchIdEx").empty();
                        $.ajax({
                            url: "{{ route('admin.announcements.getAllBatch') }}",
                            type: 'get',
                            success: function(response) {
                                $("#batchIdEx").append('<option value="0">All Batch</option>');
                                $.each(response, function(key, value) {
                                    $("#batchIdEx").append('<option value="' + value
                                        .id + '">' + value.name + '</option>');
                                });
                            }
                        });
                    }
                });

                // All subject Validation
                $(document).on("change", "#subjectEx", function () {
                    let value = $(this).val();
                    console.log(value.includes("0"))
                    if(value.includes("0")){
                        $(this).empty();
                        $(this).append('<option selected value="0">All Subject</option>');
                    }
                    if(value == ''){
                        $("#subjectEx").empty();
                        $.ajax({
                            url: "{{ route('admin.announcements.getAllSubject') }}",
                            type: 'get',
                            success: function(response) {
                                $("#subjectEx").append('<option value="0">All Subject</option>');
                                $.each(response, function(key, value) {
                                    $("#subjectEx").append('<option value="' + value
                                        .id + '">' + value.name + '</option>');
                                });
                            }
                        });
                    }
                });

            });
        </script>

        {{-- Ckeditor5 --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
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
    @endpush
@endsection
