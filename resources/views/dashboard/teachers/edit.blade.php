@extends('layouts.dashboard.app')

@section('title', 'Edit Teacher')

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
        .ck-editor__editable {
            min-height: 200px;
        }
    </style>
@endpush

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.teachers.index') }}">Teacher List</a>
            </li>

        </ol>
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-sm btn-dark">Back to list</a>
    </nav>
@endsection

@section('content')
    @include('layouts.dashboard.partials.alert')
    <form action="{{ route('admin.teachers.update', $teacher->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')
        <span id="reauth-email" class="reauth-email"></span>

        <input type="hidden" name="teach_id" value="{{ $teacher->id }}">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="m-0">Edit Teacher</p>
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="name"><b>Name</b> </label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ $teacher->name }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="email"><b>Email Address</b></label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ $teacher->email }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Subjects --}}
                        @php
                            $subjectIds = json_decode($teacher->subject_id);
                        @endphp

                        <div class="form-group mt-3 ">
                            <label for="subject_id"><b>Select subject</b></label>
                            <select name="subject_id[]" class="multi-subject form-control @error('subjects') is-invalid @enderror" multiple="multiple" id="mySelect2">
                                <option value="0"
                                    @if (in_array("0", $subjectIds))
                                        selected
                                    @endif
                                >
                                    All Subject
                                </option>
                                @forelse ($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        @if(in_array($subject->id, $subjectIds))
                                            {{ "selected" }}
                                        @endif
                                    >
                                        {{-- @if ($subject->id == $teacher->subject_id) {{ 'selected' }} @endif> --}}
                                        {{ $subject->name }}
                                    </option>
                                @empty
                                    <option>--No subject--</option>
                                @endforelse
                            </select>
                            @error('subject_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3 ">
                            <label for="gender"><b>Gender</b></label>
                            <select name="gender" id="gender" value="{{ $teacher->gender }}"
                                class="form-select @error('gender') is-invalid @enderror">
                                <option>--Select gender--</option>
                                <option value="1" @if ($teacher->gender == 1) selected @endif>Male</option>
                                <option value="2" @if ($teacher->gender == 2) selected @endif>Female</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="contact_number"><b>Contact Number</b></label>
                            <input type="text" name="contact_number" id="contact_number"
                                class="form-control @error('contact_number') is-invalid @enderror"
                                value="{{ $teacher->contact_number }}">
                            @error('contact_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="current_address"><b>Current Address</b></label>
                            <textarea name="current_address" id="current_address" rows="3"
                                class="form-control @error('current_address') is-invalid @enderror"> {{ $teacher->current_address }}</textarea>
                            @error('current_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="permanent_address"><b>Permanent Address</b></label>
                            <textarea name="permanent_address" id="permanent_address" rows="3"
                                class="form-control @error('permanent_address') is-invalid @enderror">{{ $teacher->current_address }}</textarea>
                            @error('permanent_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Note --}}
                        <div class="form-group mt-3">
                            <label for="note"><b>Note</b></label>
                            <textarea class="form-control @error('note') is-invalid @enderror" name="note" id="note">{{ $teacher->note }}</textarea>
                            @error('note')
                            <span class="invalid-feedback" role="alert">
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
                        <b>Image upload</b>
                    </div>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <input type="file" id="profile"
                                data-default-file="{{ asset('images/users/' . $teacher->profile) }}"
                                class="dropify form-control @error('profile') is-invalid @enderror" name="profile">
                            @error('profile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
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
        <script>
            $(document).ready(function() {
                $('.dropify').dropify();
            });
        </script>

        {{-- Select2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.multi-subject').select2();
            });
        </script>

        {{-- Ckeditor5 --}}
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
