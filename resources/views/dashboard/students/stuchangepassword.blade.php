@extends('layouts.dashboard.app')

@section('title', 'Change Student Password')

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


    <form action="{{route('admin.password.submit')}}" method="POST">
        @csrf
        <span id="reauth-email" class="reauth-email"></span>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="m-0">Edit Student Password</p>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>

                    <div class="card-body">
                        {{-- Current Password --}}
                        <div class="form-group mt-3">
                            <label for="password">Current Password</label>
                            <input type="password" name="currentPassword" class="form-control" placeholder="Enter Current Password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="password_confirmation">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter New Password">
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="password_confirmation">Confirm New Passowrd</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm New Password"><br>
                            @error('password_confirmation')
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
