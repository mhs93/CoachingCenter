@extends('layouts.dashboard.app')

@section('title', 'edit payment category')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
        </ol>
        <a href="{{ route('admin.category.list') }}" class="btn btn-sm btn-dark">Back to list</a>
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

    <form action="{{route('admin.category.update',$cat->id)}}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$cat->id}}">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <p class="m-0">Update payment Category</p>
                    </div>
                    <div class="card-body">

                        <div class="form-group mt-3">
                            <label for="reg_no">Fee Name</label>
                            <input type="text" name="cat_name" id="cat_name" class="form-control @error('cat_name') is-invalid @enderror" value="{{ $cat->cat_name }}" >
                            @error('cat_name')
                            <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="amount">Amount</label>
                            <input type="text" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ $cat->amount  }}">
                            @error('amount')
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

@endsection
