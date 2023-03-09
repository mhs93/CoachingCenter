@extends('layouts.dashboard.app')

@section('title', 'Account Create')

@push('css')
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 200px;
        }
    </style>
@endpush


@section('content')

    @include('layouts.dashboard.partials.alert')

    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}} 

    <form action="{{route('admin.account.store')}}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <p class="m-0">Create account</p>
                        <a href="{{ route('admin.account.index') }}" class="btn btn-sm btn-dark">Back to list</a>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group mt-3 col-md-6">
                                <label for="account_no"><b>Account No</b> <span class="text-danger"><b>*</b></span></label>
                                <input type="text" name="account_no" id="account_no" class="form-control @error('account_no') is-invalid @enderror" value="{{ old('account_no') }}" placeholder="Enter account no">
                                @error('account_no')
                                <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>

                            <div class="form-group mt-3 col-md-6">
                                <label for="account_holder"><b>Account Holder</b> <span class="text-danger"><b>*</b></span></label>
                                <input type="text" name="account_holder" id="account_holder" class="form-control @error('account_holder') is-invalid @enderror" value="{{ old('account_holder') }}" placeholder="Enter account holder">
                                @error('account_holder')
                                <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mt-3 col-md-6">
                                <label for="bank_name"><b>Bank Name</b> <span class="text-danger"><b>*</b></span></label>
                                <input type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror" value="{{ old('bank_name') }}" placeholder="Enter bank name">
                                @error('bank_name')
                                <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group mt-3 col-md-6">
                                <label for="branch_name"><b>Branch Name</b> <span class="text-danger"><b>*</b></span></label>
                                <input type="text" name="branch_name" id="branch_name" class="form-control @error('branch_name') is-invalid @enderror" value="{{ old('branch_name') }}" placeholder="Enter branch name">
                                @error('branch_name')
                                <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mt-3 col-md-6">
                                <label for="initial_balance"><b>Initial Balance</b> <span class="text-danger"><b>*</b></span></label>
                                <input type="number" name="initial_balance" id="initial_balance" class="form-control @error('initial_balance') is-invalid @enderror" value="{{ old('initial_balance') }}" placeholder="Enter initial balance ">
                                @error('initial_balance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="description"><b>Description</b></span></label>
                            <textarea type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror">{!! old('description') !!}</textarea>
                            @error('description')
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
        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

        <script>
            ClassicEditor.create(document.querySelector('#description'), {
                    removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush

@endsection
