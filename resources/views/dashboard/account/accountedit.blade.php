@extends('layouts.dashboard.app')

@section('title', 'Account edit')

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
                <a href="{{ route('admin.account.index') }}" >Account List</a>
            </li>
        </ol>
        <a href="{{ route('admin.account.index') }}" class="btn btn-sm btn-dark">Back to list</a>
    </nav>
@endsection

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{route('admin.account.update',$account->id)}}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$account->id}}">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="m-0">Update Account</p>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-md-6 mt-3">
                                <label for="account_no"><b>Account No</b> </label>
                                <input type="text" name="account_no" id="account_no" class="form-control @error('account_no') is-invalid @enderror" value="{{ ($account->account_no) }}">
                                @error('account_no')
                                <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 mt-3">
                                <label for="account_holder"><b>Account Holder</b> </label>
                                <input type="text" name="account_holder" id="account_holder" class="form-control @error('account_holder') is-invalid @enderror" value="{{ ($account->account_holder) }}">
                                @error('account_holder')
                                <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 mt-3 ">
                                <label for="bank_name"><b>Bank Name</b></label>
                                <input type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror" value="{{ $account->bank_name }}" >
                                @error('bank_name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 mt-3">
                                <label for="branch_name"><b>Branch Name</b></label>
                                <input type="text" name="branch_name" id="branch_name" class="form-control @error('branch_name') is-invalid @enderror" value="{{ ($account->branch_name) }}">
                                @error('branch_name')
                                <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="description"><b>Description</b></label>
                                <textarea type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror">{!! $account->description !!}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
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
@endsection

@push('js')
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
@endpush
