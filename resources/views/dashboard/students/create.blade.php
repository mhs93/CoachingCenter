@extends('layouts.dashboard.app')

@section('title', 'Create Student')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
    </style>
@endpush



@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Create</p>
            <a href="#" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.students.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <p class="m-0">Create Student</p>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                        placeholder="Enter name">
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
                                        value="{{$latestReg}}" placeholder="Enter registration number" readonly>
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
                                        value="{{ old('email') }}" placeholder="Enter email address">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- <div class="form-group mt-3">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        value="{{ old('password') }}" placeholder="Enter password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror""
                                        value="{{ old('password_confirmation') }}" placeholder="Confirm password">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}

                                <div class="form-group mt-3 ">
                                    <label for="batch">Batch</label>
                                    <select name="batch_id" id="batch"
                                        class="form-select @error('batch_id') is-invalid @enderror">
                                        <option value="">--Select batch--</option>
                                        @forelse ($batches as $batch)
                                            <option value="{{ $batch->id }}">{{ $batch->name }}</option>
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

                                <div class="form-group mt-3 ">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender"
                                        class="form-select @error('gender') is-invalid @enderror">
                                        <option value="">--Select gender--</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
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
                                        value="{{ old('contact_number') }}" placeholder="Enter contact number">
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
                                        value="{{ old('parent_contact') }}" placeholder="Enter parent contact number">
                                    @error('parent_contact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="current_address">Current Address</label>
                                    <textarea name="current_address" id="current_address" rows="3"
                                        class="form-control @error('current_address') is-invalid @enderror" placeholder="Current Address...">{{ old('current_address') }}</textarea>
                                    @error('current_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="permanent_address">Permanent address</label>
                                    <textarea name="permanent_address" id="permanent_address" rows="3"
                                        class="form-control @error('permanent_address') is-invalid @enderror" placeholder="Permanent address...">{{ old('permanent_address') }}</textarea>
                                    @error('permanent_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Salary --}}
                                <div class="form-group mt-3">
                                    <label for="monthly_fee">Monthly Fee</label>
                                    <input type="text" name="monthly_fee" id="monthly_salary"
                                        class="form-control @error('monthly_fee') is-invalid @enderror" placeholder="Enter Monthly Fee">
                                    @error('monthly_fee')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">

                                    <label for="description">Student Note</label>
                                    <textarea name="note" class="form-control" id="note" cols="40" rows="6"></textarea>
                                    @error('note')
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
                                        class="dropify form-control @error('profile') is-invalid @enderror"
                                        name="profile">
                                    @error('profile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3 ">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="mb-5"></div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>
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
