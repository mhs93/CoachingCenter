@extends('layouts.dashboard.app')

@section('title', 'Edit Announcement')

@push('css')
    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .ck-editor__editable[role="textbox"] {
                min-height: 320px;
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
            <p class="m-0">Edit an announcement</p>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    {{-- <div class="form-group col-md-6">
                        <label for="batch">Select Batch</label>
                        <select name="batch_id" id="batch" class="form-control">
                            <option>Select</option>
                            @forelse ($batches as $batche)
                                <option value="{{ $batche->id }}" {{ $announcement->batch_id == $batche->id ? 'selected' : '' }}>
                                    {{ $batche->name }}</option>
                            @empty
                                <option>No batch</option>
                            @endforelse
                        </select>
                        @error('batch_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    {{-- Batch Checkbox --}}
                    @php
                        $subjectIds = json_decode($announcement->batch_id);
                    @endphp
                    <div class="form-group mt-3 ">
                        <label for="batch_id">Select subject</label>
                        <select name="batch_id[]" class="multi-subject form-control @error('batch_id') is-invalid @enderror" multiple="multiple" id="mySelect2">
                            <option value="0"
                                @if (in_array("0", $subjectIds))
                                    selected
                                @endif
                            >
                                All Subject
                            </option>
                            @forelse ($batches as $batch)
                                <option value="{{ $batch->id }}"
                                    @if(in_array($batch->id, $subjectIds))
                                        {{ "selected" }}
                                    @endif
                                >
                                    {{-- @if ($subject->id == $teacher->subject_id) {{ 'selected' }} @endif> --}}
                                    {{ $batch->name }}
                                </option>
                            @empty
                                <option>--No subject--</option>
                            @endforelse
                        </select>
                        @error('batch_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Title --}}
                    <div class="form-group col-md-6">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Titile" value="{{ $announcement->title }}">
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="form-group mt-2">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description">{{ $announcement->description }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </form>
        </div>
    </div>
    <div class="mb-5"></div>

    @push('js')
        {{-- Select2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.multi-subject').select2();
            });
        </script>

        {{-- Ckeditor CDN --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#description'), {
                    removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush

@endsection
