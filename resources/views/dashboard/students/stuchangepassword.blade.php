@extends('layouts.dashboard.app')

@section('title', 'Change Student Password')

@push('css')

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
                        <a href="{{ route('admin.user.profile') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>

                    <div class="card-body">
                        {{-- Current Password --}}
                        <div class="form-group mt-3">
                            <label for="password">Current Password <span style="color: red">*</span></label>
                            <input type="password" name="currentPassword" class="form-control" placeholder="Enter Current Password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="password_confirmation">New Password <span style="color: red">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Enter New Password">
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="password_confirmation">Confirm New Passowrd <span style="color: red">*</span></label>
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

    @endpush
@endsection
