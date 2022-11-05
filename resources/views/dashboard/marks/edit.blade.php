@extends('layouts.dashboard.app')

@section('title', 'Edit Marks')

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
            <p class="m-0">Update Exam</p>
            <a href="{{ route('admin.exams.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card-body">
            {{-- {{ route('admin.marks.update', $mark->id) }} --}}
            <form action="" method="POST">
                {{-- @csrf
                @method('PUT') --}}
                <div class="form-group mt-3">

                    <div class="form-group">
                        <label for="batch">Select Batch</label>
                        <select name="batch_id" id="batchIdEx" class="form-control">
                            @forelse ($batch as $batch)
                                <option value="">--Select Batch--</option>
                                <option value="{{ $batch->id }}">
                                    {{ $batch->name }}
                                </option>
                            @empty
                                <option>No batch</option>
                            @endforelse
                        </select>
                        @error('batch_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Sub-Form Start --}}
                    <div class="form-group mt-3 col-md-12" id="subForm" >
                    </div>
                    {{-- Sub-Form End --}}


                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        {{-- Ckeditor CDN --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function () {
                // Depedancy Start
                $('#batchIdEx').on('change', function() {
                    let batch_id = $(this).val();
                    $("#subjectEx").empty();
                    $.ajax({
                        url: "{{ route('admin.getSubjects') }}",
                        type: 'post',
                        data: { batchId: batch_id},
                        success: function(response) {
                            console.log(response);
                            $.each(response, function(key, value) {
                                console.log(value.id)
                                $("#subjectEx").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                            });
                        }
                    });
                });

                //for showing marks
                $('#subForm').hide();
                $('#batchIdEx').on('change', function() {
                    $('#subForm').show();
                    let batch_id = $(this).val();
                    $("#subForm").empty();
                    $.ajax({
                        url: "{{ route('admin.result.getResultsEdit') }}",
                        type: 'post',
                        data: { batchId: batch_id},
                        success: function(response) {
                            $('#subForm').html(response);
                        }
                    });
                });

                // Ckeditor
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
