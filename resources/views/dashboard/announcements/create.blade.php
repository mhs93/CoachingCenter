@extends('layouts.dashboard.app')

@section('title', 'Create Announcement')

@push('css')
    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 150px;
        }
    </style>
@endpush

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.announcements.index') }}">Announcement List</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header">
            <p class="m-0">Add an announcement</p>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.announcements.store') }}" method="POST">
                @csrf
                <div class="row">
                    {{-- Title --}}
                    <div class="form-group col-md-12 mt-2">
                        <label for="title"><b>Title</b> <span style="color: red">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Titile" value="{{ old('title') }}">
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12 mt-2">
                        <label for="batch_id"><b>Select Bathces</b>  <span style="color: red">*</span></label>
                        <select name="batch_id[]" class="multi-subject form-control @error('batch_id') is-invalid @enderror"
                            multiple="multiple" id="batch_id">
                            <option value="0">
                                All Batch
                            </option>
                            @forelse ($batches as $batch)
                                <option value="{{ $batch->id }}"
                                    @if (old("batch_id")) {{ (in_array($batch->id, old("batch_id")) ? "selected":"") }}@endif>
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
                </div>

                {{-- Description --}}
                <div class="form-group mt-2">
                    <label for="description"><b>Description</b></label>
                    <textarea class="form-control" name="note" id="note">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
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
        {{-- Select2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        {{-- Ckeditor5 --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
        <script>
            var id = '';
            $.ajax({
                id = $('#a').val();

            });
            console.log(id);
        </script>

        <script>
            $(document).ready(function() {
                $('.multi-subject').select2();
            });

            $(document).on("change", "#batch_id", function () {
                let value = $(this).val();
                console.log(value.includes("0"))
                if(value.includes("0")){
                    $(this).empty();
                    $(this).append('<option selected value="0">All Batch</option>');
                }
                if(value == ''){
                    $("#batch_id").empty();
                    $.ajax({
                        url: "{{ route('admin.announcements.getAllBatch') }}",
                        type: 'get',
                        success: function(response) {
                            $("#batch_id").append('<option value="0">All Batch</option>');
                            $.each(response, function(key, value) {
                                $("#batch_id").append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            // CKEditor
            ClassicEditor.create(document.querySelector('#note'), {
                    removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
                })
                .catch(error => {
                    console.error(error);
                });
        </script>

        {{-- Batch Checkbox --}}
    @endpush

@endsection
