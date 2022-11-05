@extends('layouts.dashboard.app')

@section('title', 'Subject Edit')

@push('css')
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 200px;
        }
    </style>
@endpush

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                {{--<a href="">Subjects List</a>--}}
            </li>
        </ol>
        <a href="{{ route('admin.subjects.index') }}" class="btn btn-sm btn-dark">Back</a>
    </nav>
@endsection

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Edit Subject</p>
            <a href="{{ route('admin.subjects.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="name"><b>Subject name</b></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter subject name" value="{{ $subject->name }}">
                        </div>
                        @error('name')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="code"><b>Subject Code</b></label>
                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" placeholder="Enter Subject Code" value="{{ $subject->code }}">
                        @error('code')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="fee"><b>Fee</b></label>
                        <input type="number" class="form-control @error('fee') is-invalid @enderror" name="fee" id="fee" value="{{ $subject->fee }}" >
                        @error('fee')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror
                    </div>
                </div>

                {{-- Note --}}
                <div class="form-group mt-2">
                    <label for="note"><b>Subject Note</b> </label>
                    <textarea class="form-control @error('note') is-invalid @enderror" name="note" id="note">{!! $subject->note !!}</textarea>
                    @error('note')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
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
