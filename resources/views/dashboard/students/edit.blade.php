@extends('layouts.dashboard.app')

@section('title', 'Edit Student')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
          integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
    </style>
@endpush

@section('content')
    @include('layouts.dashboard.partials.alert')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{route('admin.students.update',$student->id)}}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')
        <span id="reauth-email" class="reauth-email"></span>
        <input type="hidden" name="std_id" value="{{$student->id}}">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="m-0">Edit Student</p>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ ($student->name) }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="reg_no">Registration Number</label>
                            <input type="text" name="reg_no" id="reg_no"
                                   class="form-control @error('reg_no') is-invalid @enderror"
                                   value="{{ ($student->reg_no) }}" readonly>
                            @error('reg_no')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ ($student->email) }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3 ">
                            <label for="batch_id">Batch</label>
                            <select name="batch_id" id="batch_id" class="form-select @error('batch') is-invalid @enderror">
                                <option>--Select batch--</option>

                                @foreach($batches as $batch)
                                    <option
                                        value="{{ $batch->id }}"
                                        @if ($batch->id == $student->batch_id)
                                            {{ 'selected' }}
                                        @endif
                                    >
                                    {{ $batch->name}}
                                </option>
                                @endforeach
                            </select>
                            @error('batch_id')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3 ">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" value="{{ ($student->gender) }}"
                                    class="form-select @error('gender') is-invalid @enderror">
                                <option>--Select gender--</option>
                                <option value="1" @if($student->gender == 1) selected @endif>Male</option>
                                <option value="2" @if($student->gender == 2) selected @endif>Female</option>
                            </select>
                            @error('gender')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="contact_number">Contact Number</label>
                            <input type="text" name="contact_number" id="contact_number"
                                   class="form-control @error('contact_number') is-invalid @enderror"
                                   value="{{ ($student->contact_number) }}">
                            @error('contact_number')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="parent_contact">Parent Contact Number</label>
                            <input type="text" name="parent_contact" id="parent_contact"
                                   class="form-control @error('parent_contact') is-invalid @enderror"
                                   value="{{ ($student->parent_contact) }}">
                            @error('parent_contact')
                            <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group mt-3">
                            <label for="current_address">Current Address</label>
                            <textarea name="current_address" id="current_address" rows="3"
                                      class="form-control @error('current_address') is-invalid @enderror"
                                      placeholder="Current Address..."> {{ ($student->current_address)}}</textarea>
                            @error('current_address')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="permanent_address">Permanent address</label>
                            <textarea name="permanent_address" id="permanent_address" rows="3"
                                      class="form-control @error('permanent_address') is-invalid @enderror"
                                      placeholder="Permanent address...">{{ ($student->permanent_address)}}</textarea>
                            @error('permanent_address')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Student Note</label>
                            <textarea name="note" class="form-control" id="note" cols="30" rows="10">{{ $student->note }}</textarea>
                            @error('description')
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
                        Image upload
                    </div>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <input type="file" id="profile"
                                   data-default-file="{{asset('images/users/'.$student->profile)}}"
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
            $(document).ready(function () {
                $('.dropify').dropify();
            });
        </script>

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
