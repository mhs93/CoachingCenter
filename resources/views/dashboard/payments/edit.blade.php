@extends('layouts.dashboard.app')

@section('title', 'edit payment')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>

            </li>
        </ol>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-dark">Back to list</a>
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

    <form action="{{route('admin.payments.update',$payment->id)}}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')
        {{--<span id="reauth-email" class="reauth-email"></span>--}}
        <input type="hidden" name="id" value="{{$payment->id}}">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <p class="m-0">Update payment</p>
                    </div>
                    <div class="card-body">


                        <div class="form-group mt-3">
                            <label for="reg_no">Registration Number</label>
                            <input type="text" name="reg_no" id="reg_no" class="form-control @error('reg_no') is-invalid @enderror" value="{{ $payment->reg_no }}" >
                            @error('reg_no')
                            <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="amount">Amount</label>
                            <input type="text" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ $payment->amount  }}">
                            @error('amount')
                            <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="paid_amount">Paid Amount</label>
                            <input type="text" name="paid_amount" id="paid_amount" class="form-control @error('paid_amount') is-invalid @enderror" value="{{ $payment->paid_amount  }}">
                            @error('paid_amount')
                            <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="due_amount">Due Amount</label>
                            <input type="text" name="due_amount" id="due_amount" class="form-control @error('due_amount') is-invalid @enderror"" value="{{ $payment->due_amount  }}">
                            @error('due_amount')
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
