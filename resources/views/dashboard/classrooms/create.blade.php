@extends('layouts.dashboard.app')

@section('title', 'Create Classroom')

@push('css')
    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 150px;
        }
    </style>
@endpush

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Add class room</p>
            <a href="{{ route('admin.class-rooms.index') }}" class="btn btn-sm btn-info">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.class-rooms.store') }}" method="POST">
                @csrf
                <div class="row">
                    {{-- Batch --}}
                    <div class="form-group col-md-6 mt-2">
                        <label for="batch"><b>Select Batch</b>  <span style="color: red">*</span></label>
                        <select name="batch_id" id="batchIdEx" class="form-control">
                            <option value="">--Select batch--</option>
                            @forelse ($batches as $batch)
                                <option value="{{ $batch->id }}" {{ old('batch_id') === $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }}</option>
                            @empty
                                <option>No batch</option>
                            @endforelse
                        </select>
                        @error('batch_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Subjects --}}
                    <div class="form-group col-md-6 mt-2">
                        <label for="batch"><b>Select Subjects</b> <span style="color: red">*</span></label>
                        <select name="subject_id" id="subjectEx" class="form-control @error('subject_id') is-invalid @enderror">
                            <option value="">--Select subject--</option>
                        </select>
                        @error('subject_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 mt-2">
                        <label for="class_type"><b>Class Type</b> <span style="color: red">*</span></label>
                        <select name="class_type" id="class_type"
                                class="form-select @error('class_type') is-invalid @enderror">
                            <option value="">--Select class type--</option>
                            <option value="1">Physical</option>
                            <option value="2">Online</option>
                        </select>
                        @error('class_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 mt-2">
                        <label for="date"><b>Date</b> <span style="color: red">*</span></label>
                        <input type="date" name="date" class="form-control" placeholder="Class date" value="{{ old('date') }}">
                        @error('date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="form-group col-md-6 mt-2">
                        <label for="start_time"><b>Start Time </b><span style="color: red">*</span></label>
                        <input type="time" name="start_time" class="form-control" placeholder="Start Time" value="{{ old('start_time') }}">
                        @error('start_time')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 mt-2">
                        <label for="end_time"><b>End Time</b> <span style="color: red">*</span></label>
                        <input type="time" name="end_time" class="form-control" placeholder="End Time" value="{{ old('end_time') }}">
                        @error('end_time')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="form-group col-md-6 mt-2">
                        <label for="duration"><b>Duration</b> <span style="color: red">*</span></label>
                        <input type="text" name="duration" class="form-control" placeholder="Enter Duration" value="{{ old('duration') }}">
                        @error('duration')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 mt-2" id="accessKey">
                        <label for="access_key"><b>Access Key</b> <span style="color: red">*</span></label>
                        <input type="text" name="access_key" class="form-control" placeholder="Enter Access Key" value="{{ old('access_key') }}">
                        @error('access_key')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mt-2" id="classLink">
                    <label for="class_link"><b>Class Link</b> <span style="color: red">*</span></label>
                    <input type="text" name="class_link" class="form-control" placeholder="Enter Video Link" value="{{ old('class_link') }}">
                    @error('class_link')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-2">
                    <label for="note"><b>Class Room Note</b> </label>
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
    <div class="mb-5"></div>

    @push('js')
        {{-- Ckeditor5 --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function () {
                // Dependancy for batch and subjects
                $('#batchIdEx').on('change', function() {
                    let batch_id = $(this).val();
                    console.log(batch_id);
                    $("#subjectEx").empty();
                    $.ajax({
                        url: "{{ route('admin.classRoomGetSubjects') }}",
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


                $('#accessKey').hide();
                $('#classLink').hide();

                $('#class_type').on('change',function () {
                    if (this.value == 1){
                        $('#accessKey').hide();
                        $('#classLink').hide();
                    }
                    if (this.value == 2){
                        $('#accessKey').show();
                        $('#classLink').show();
                    }
                })

                // CKEditor
                ClassicEditor.create(document.querySelector('#note'), {
                    removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
                })
                .catch(error => {
                    console.error(error);
                });
            })

        </script>
    @endpush

@endsection

