@extends('layouts.dashboard.app')

@section('title', 'Create Teacher')

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

@section('content')
    @include('layouts.dashboard.partials.alert')
    <form action="{{ route('admin.teachers.store') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="m-0">Create Teacher</p>
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Name --}}
                        <div class="form-group mt-3">
                            <label for="name"><b>Name <span style="color: red">*</span></b> </label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="Enter name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Registration Number --}}
                        <div class="form-group mt-3">
                            <label for="reg_no"><b>Registration Number</b></label>
                            <input type="text" name="reg_no" id="reg_no" readonly
                                class="form-control @error('reg_no') is-invalid @enderror" value="{{ $latestReg }}"
                                placeholder="Enter registration number" >
                            @error('reg_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group mt-3">
                            <label for="email"><b>Email Address <span style="color: red">*</span></b></label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="Enter email address">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Subjects --}}
                        <div class="form-group mt-3">
                            <label for="subject_id"><b>Select Subjects <span style="color: red">*</span></b></label>
                            <select name="subject_id[]" multiple="multiple" id="subject_id"
                                    class="multi-subject form-control @error('subject_id') is-invalid @enderror">
                                <option value="0">All Subject</option>
                                @forelse ($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        @if (old("subject_id")) {{ (in_array($subject->id, old("subject_id")) ? "selected":"") }}@endif>
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

                        {{-- Reference --}}
                        <div class="form-group mt-3">
                            <label for="reference"><b>Reference </b></label>
                            <textarea type="text" name="reference" id="reference" class="form-control @error('reference') is-invalid @enderror" placeholder="Enter reference details">
                                {{ old('reference') }}
                            </textarea>
                            @error('reference')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- ID Number --}}
                        <div class="form-group mt-3">
                            <label for="id_number"><b>ID Number <span style="color: red">*</span></b></label>
                            <input type="text" name="id_number" id="id_number"
                                    class="form-control @error('id_number') is-invalid @enderror"
                                    value="{{ old('id_number') }}"  placeholder="Enter NID or Passport number">
                            @error('id_number')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Qualification --}}
                        <div class="form-group mt-3">
                            <label for="qualification"><b>Qualification <span style="color: red">*</span></b></label>
                            <input type="text" name="qualification" id="qualification"
                                    class="form-control @error('qualification') is-invalid @enderror"
                                    value="{{ old('qualification') }}"  placeholder="Enter qualification">
                            @error('qualification')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Salary --}}
                        <div class="form-group mt-3">
                            <label for="monthly_salary"><b>Salary<span style="color: red">*</span></b></label>
                            <input type="text" name="monthly_salary" id="monthly_salary"
                                class="form-control @error('monthly_salary') is-invalid @enderror"
                                value="{{ old('monthly_salary') }}" placeholder="Enter Monthly Salary">
                            @error('monthly_salary')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Gender --}}
                        <div class="form-group mt-3 ">
                            <label for="gender"><b>Gender <span style="color: red">*</span></b></label>
                            <select name="gender" id="gender"
                                class="form-select @error('gender') is-invalid @enderror"
                                value="{{ old('gender') }}">
                                <option>--Select gender--</option>
                                <option value="1" @if (old('gender') == "1") {{ 'selected' }} @endif>Male</option>
                                <option value="2" @if (old('gender') == "2") {{ 'selected' }} @endif>Female</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Contact Number --}}
                        <div class="form-group mt-3">
                            <label for="contact_number"><b>Contact Number <span style="color: red">*</span></b></label>
                            <input type="text" name="contact_number" id="contact_number"
                                class="form-control @error('contact_number') is-invalid @enderror"
                                value="{{ old('contact_number') }}" placeholder="Enter contact number">
                            @error('contact_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Present Address --}}
                        <div class="form-group mt-3">
                            <label for="current_address"><b>Current Address<span style="color: red">*</span></b></label>
                            <textarea name="current_address" id="current_address" rows="3"
                                class="form-control @error('current_address') is-invalid @enderror" placeholder="Current Address...">{{ old('current_address') }}</textarea>
                            @error('current_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Permanant Address --}}
                        <div class="form-group mt-3">
                            <label for="permanent_address"><b>Permanent Address <span style="color: red">*</span></b></label>
                            <textarea name="permanent_address" id="permanent_address" rows="3"
                                class="form-control @error('permanent_address') is-invalid @enderror" placeholder="Permanent address...">{{ old('permanent_address') }}</textarea>
                            @error('permanent_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Note --}}
                        <div class="form-group mt-3">
                            <label for="note"><b>Note</b></label>
                            <textarea class="form-control @error('note') is-invalid @enderror" name="note" id="note">{{ old('note') }}</textarea>
                            @error('note')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Image --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <b>Image upload</b>
                    </div>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <input type="file" id="profile"
                                class="dropify form-control @error('profile') is-invalid @enderror" name="profile">
                            @error('profile')
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
        {{-- Select2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.multi-subject').select2();
            });
        </script>

        {{-- Dropify CDN --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
            integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
            crossorigin="anonymous" referrerpolicy="no-referrer">
        </script>
        <script>
            $(document).ready(function() {
                $('.dropify').dropify();
            });

            $(document).on("change", "#subject_id", function () {
                let value = $(this).val();
                console.log(value.includes("0"))
                if(value.includes("0")){
                    $(this).empty();
                    $(this).append('<option selected value="0">All Subject</option>');
                }
                if(value == ''){
                    $("#subject_id").empty();
                    $.ajax({
                        url: "{{ route('admin.batch.getAllSubject') }}",
                        type: 'get',
                        success: function(response) {
                            $("#subject_id").append('<option value="0">All Subject</option>');
                            $.each(response, function(key, value) {
                                $("#subject_id").append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        }
                    });
                }
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
