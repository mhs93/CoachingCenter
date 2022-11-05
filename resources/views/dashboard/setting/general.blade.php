@extends('layouts.dashboard.app')

@section('title', 'General Setting')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
        .ck-editor__editable[role="textbox"] {
            min-height: 150px;
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
    <div class="row my-3">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{route('admin.setting.general')}}" class="list-group-item list-group-item-action {{ Route::is('admin.setting.general') ? 'active' : '' }}">
                    General Setting
                </a>
                <a href="#" class="list-group-item list-group-item-action">Other Setting</a>
                <a href="#" class="list-group-item list-group-item-action">Other Setting</a>
                <a href="#" class="list-group-item list-group-item-action">Other Setting</a>
                <a href="#" class="list-group-item list-group-item-action disabled">Other Setting</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <p class="m-0">General Information</p>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.setting.general')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group my-3">
                            <label for="site_title"><b>Site Title</b></label>
                            <input type="text" name="site_title" id="site_title" class="form-control" value="@isset($setting->site_title) {{ $setting->site_title }} @endisset">
                            @error('site_title')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group my-3">
                            <label for="logo"> <b>Logo (Only image are allowed)</b> </label>
                            @if (isset($setting->logo))
                                <input type="file" class="form-control dropify" data-default-file="{{ asset('images/setting/logo/'.$setting->logo) }}" name="logo" id="logo">
                            @else
                                <input type="file" class="form-control dropify" name="logo" id="logo">
                            @endif

                            @error('logo')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group my-3">
                            <label for="favicon"><b>Favicon (Only image are allowed, size: 33 x 33)</b> </label>
                            @if (isset($setting->favicon))
                                <input type="file" class="form-control dropify" data-default-file="{{ asset('images/setting/favicon/'.$setting->favicon) }}" name="favicon" id="favicon">
                            @else
                                <input type="file" class="form-control dropify" name="favicon" id="favicon">
                            @endif

                            @error('favicon')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group my-3">
                            <label for="site_address"> <b>Site Address</b> </label>
                            <input type="text" name="site_address" id="site_address" class="form-control" value="@isset($setting->site_address) {{ $setting->site_address }} @endisset">


                            @error('site_address')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group my-3">
                            <label for="site_description"> <b>Site Description</b> </label>
                            <textarea name="site_description" class="form-control" id="site_description" cols="30" rows="10">@isset($setting->site_description) {{ $setting->site_description }} @endisset</textarea>
                            @error('site_description')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">
                            Update
                        </button>
                    </form>
                </div>
            </div>
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
