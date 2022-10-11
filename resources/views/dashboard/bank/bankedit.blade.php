@extends('layouts.dashboard.app')

@section('title', 'Bank Edit')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.bank.index') }}">Bank list</a>
            </li>
        </ol>
        <a href="{{ route('admin.bank.index') }}" class="btn btn-sm btn-dark">Bank list</a>
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

    <form action="{{route('admin.bank.update',$bank->id)}}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$bank->id}}">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <p class="m-0">Update Bank</p>
                    </div>
                    <div class="card-body">

                        <div class="form-group mt-3">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror" value="{{ $bank->bank_name }}" >
                            @error('bank_name')
                            <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        {{--<div class="form-group mt-3">--}}
                            {{--<label for="branch">Branch</label>--}}
                            {{--<input type="text" name="branch" id="branch" class="form-control @error('branch') is-invalid @enderror" value="{{ $bank->branch  }}">--}}
                            {{--@error('branch')--}}
                            {{--<span class="invalid-feedback" role="alert">--}}
                             {{--<strong>{{ $message }}</strong>--}}
                            {{--</span>--}}
                            {{--@enderror--}}
                        {{--</div>--}}

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
