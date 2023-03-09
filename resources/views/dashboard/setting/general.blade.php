@extends('layouts.dashboard.app')

@section('title', 'General Setting')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
        .ck-editor__editable[role="textbox"] {
            min-height: 200px;
        }
    </style>

@endpush

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.resources.index') }}">Dashboard</a>
            </li>
        </ol>
        <a href="{{ route('admin.resources.index') }}" class="btn btn-sm btn-dark">Back to list</a>
    </nav>
@endsection

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header">
            <p class="m-0">General Information</p>
        </div>
        <div class="card-body">
        <form enctype="multipart/form-data" action="{{ route('admin.generalUpdate') }}" method="POST">
                    @csrf
                <input type="hidden" name="id" value="{{ isset($data) ? $data->id : ' ' }}">
                <div class="row">
                    <div class="form-group col-md-6 mt-2">
                        <label for="site_title"><b>Site Title</b> <b><span style="color: red">*</span></b> </label>
                        <input type="text" name="site_title" id="site_title" value="{{ isset($data) ? $data->site_title : old('site_title') }}" class="form-control" placeholder="Enter company name" required>
                        @error('site_title')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 mt-2">
                        <label for="site_address"> <b>Website Address <b><span style="color: red">*</span></b></b> </label>
                        <input type="text" name="site_address" id="site_address" class="form-control" value="@isset($data->site_address) {{ $data->site_address }} @endisset">
                        @error('site_address')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label for="email"><b>Email</b> <b><span style="color: red">*</span></b> </label>
                        <input type="email" name="email" id="email" class="form-control" value="@isset($data->email) {{ $data->email }} @endisset">
                        @error('email')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label for="phone"> <b>Phone</b><span style="color: red">*</span> </label>
                        <input type="text" name="phone" id="phone" class="form-control" value="@isset($data->phone) {{ $data->phone }} @endisset">
                        @error('phone')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 mt-2">
                        <label for="logo"> <b>Logo (Only image are allowed)</b> <b><span style="color: red">*</span></b> </label>
                        <input type="file" name="logo" id="logo" data-height="150"
                                        @if ($data) data-default-file="{{ asset('img/' . $data->logo) }}" @endif class="dropify form-control @error('logo') is-invalid @enderror" >
                        @error('logo')
                        <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 mt-2">
                        <label for="favicon"><b>Favicon (Only image are allowed, size: 33 x 33)</b> <b><span style="color: red">*</span></b> </label>
                        <input type="file" name="favicon" id="favicon" data-height="150" @if ($data) data-default-file="{{ asset('img/' . $data->favicon) }}" @endif class="dropify form-control @error('favicon') is-invalid @enderror" >

                        @error('favicon')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label for="map"><b>Map Location</b><span style="color: red">*</span></label>
                            <textarea name="map" class="form-control" rows="4" placeholder="Enter map location" required>@isset($data->map) {{ $data->map }} @endisset</textarea>
                            @error('map')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                    </div>

                    <div class="form-group col-md-6 mt-2">
                        <label for="location"> <b>Address</b> </label>
                        <textarea name="location" class="form-control" rows="4" placeholder="Enter Address">
                            @isset($data->location) {{ $data->location }} @endisset
                        </textarea>
                        
                        @error('location')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-12 mt-2">
                        <label for="site_description"> <b>Site Description</b> </label>
                        <textarea name="site_description" class="form-control" id="site_description" cols="30" rows="10">@isset($data->site_description) {{ $data->site_description }} @endisset</textarea>
                        @error('site_description')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                </div>
                <div style="margin-top: 8px">
                <button title="Create Button" type="submit" class="btn btn-success mr-2">{{ isset($data) ? 'Update' : 'Save' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });

        ClassicEditor
            .create(document.querySelector('#site_description'), {
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
