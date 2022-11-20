@extends('layouts.dashboard.app')

@section('title', 'Teacher profile')

@push('css')

@endpush

@section('content')
    <section style="background-color: #eee;">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="{{ asset('images/users/'.$user->teacher->profile)}}"
                             class="rounded-circle img-fluid" style="width: 150px;">
                        <h5 class="my-2">{{ $user->teacher->name }}</h5>
                        <p class="text-muted mb-1">Reg No: {{$user->teacher->reg_no}}</p>
                        <div class="row">
                            <div mt-3>
                                <a href="{{route('admin.teachers.password')}}" class="btn btn-sm btn-success">Change Password</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Full Name</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->teacher->name}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->teacher->email}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Phone</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->teacher->contact_number}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Current Address</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->teacher->current_address}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Permanent Address</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->teacher->permanent_address}}</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        </div>
    </section>

@endsection
