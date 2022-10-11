@extends('layouts.dashboard.app')

@section('title', 'Create Announcement')

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
            <p class="m-0">Add an announcement</p>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.announcements.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group">
                        <label for="batch_id">Select Bathces</label>
                        <select name="batch_id[]" class="multi-subject form-control @error('batch_id') is-invalid @enderror" multiple="multiple" id="mySelect2">
                            <option value="0">
                                All Batches
                            </option>
                            @forelse ($batches as $batch)
                                <option value="{{ $batch->id }}">
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
                    <div class="form-group col-md-12">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Titile" value="{{ old('title') }}">
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="form-group mt-2">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description">{{ old('description') }}</textarea>
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

        {{-- Select2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.multi-subject').select2();
            });
        </script>

        {{-- Batch Checkbox --}}
        <script>
            var checkboxes = document.querySelectorAll("input[type = 'checkbox']");
            console.log(checkboxes);
            function checkAll(myCheckbox){
                if(myCheckbox.checked == true){
                    checkboxes.forEach(function(checkbox){
                        checkbox.checked = true;
                    });
                }else{
                    checkboxes.forEach(function(checkbox){
                        checkbox.checked = false;
                    });
                }
            }
        </script>
    @endpush

@endsection
