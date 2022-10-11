@extends('layouts.dashboard.app')

@section('title', 'Subject Create')

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
            <p class="m-0">Create a subject</p>
            <a href="#" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.subjects.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="name">Subject name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter subject name" value="{{ old('name') }}">
                        </div>
                        @error('name')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="code">Subject Code</label>
                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" placeholder="Enter Subject Code" value="{{ old('code') }}">
                        @error('code')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="fee">Fee</label>
                        <input class="form-control @error('fee') is-invalid @enderror" name="fee" id="fee" value="{{ old('fee') }}" >
                        @error('fee')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" @if (old('status') == "1") {{ 'selected' }} @endif>Active</option>
                            <option value="0" @if (old('status') == "0") {{ 'selected' }} @endif>Inactive</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>


                <div class="form-group mt-2">
                    <label for="note">Note</label>
                    <textarea class="form-control @error('note') is-invalid @enderror" name="note" id="note">{{ old('note') }}</textarea>
                    @error('note')
                    <span class="invalid-feedback" role="alert">
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
