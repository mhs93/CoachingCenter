@extends('layouts.dashboard.app')

@section('title', 'Account Create')

@push('css')
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
                <a href="{{ route('admin.account.index') }}" >Account List</a>

            </li>
        </ol>
        <a href="{{ route('admin.account.index') }}" class="btn btn-sm btn-dark">Back to list</a>
    </nav>
@endsection

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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <p class="m-0">Create account</p>
                    </div>
                    <div class="card-body">

                        <div class="form-group mt-3">
                            <label for="account_no">Account No</label>
                            <input type="text" name="account_no" id="account_no" class="form-control @error('account_no') is-invalid @enderror" value="{{ old('account_no') }}" placeholder="Enter account no">
                            @error('account_no')
                            <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="account_holder">Account Holder</label>
                            <input type="text" name="account_holder" id="account_holder" class="form-control @error('account_holder') is-invalid @enderror" value="{{ old('account_holder') }}" placeholder="Enter account holder">
                            @error('account_holder')
                            <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3 ">
                            <label for="bank_id">Bank</label>
                            <select name="bank_id" id="bank_id"
                                    class="form-select @error('bank_id') is-invalid @enderror">
                                <option value="">--Select Bank--</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}" {{ old('bank_id') === $bank->id ? 'selected' : '' }}>{{$bank->bank_name}}</option>
                                @endforeach
                            </select>
                            @error('bank_id')
                            <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="branch_name">Branch Name</label>
                            <input type="text" name="branch_name" id="branch_name" class="form-control @error('branch_name') is-invalid @enderror" value="{{ old('branch_name') }}" placeholder="Enter branch name">
                            @error('branch_name')
                            <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="initial_balance">Initial Balance</label>
                            <input type="text" name="initial_balance" id="initial_balance" class="form-control @error('initial_balance') is-invalid @enderror" value="{{ old('initial_balance') }}" placeholder="Enter initial balance ">
                            @error('initial_balance')
                            <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="description">Description</label>
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
