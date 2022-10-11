@extends('layouts.dashboard.app')

@section('title', 'Admin profile')

@push('css')

@endpush

@section('content')
    <section style="background-color: #eee;">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="{{ asset('images/users/user.jpg')}}"
                             class="rounded-circle img-fluid" style="width: 150px;">
                        <h5 class="my-3">{{ $user->name }}</h5>
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                    <div class="card-body p-0">
                        {{--<ul class="list-group list-group-flush rounded-3">--}}
                            {{--<li class="list-group-item d-flex justify-content-between align-items-center p-3">--}}
                                {{--<i class="fas fa-globe fa-lg text-warning"></i>--}}
                                {{--<p class="mb-0">https://mdbootstrap.com</p>--}}
                            {{--</li>--}}
                            {{--<li class="list-group-item d-flex justify-content-between align-items-center p-3">--}}
                                {{--<i class="fab fa-github fa-lg" style="color: #333333;"></i>--}}
                                {{--<p class="mb-0">mdbootstrap</p>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
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
                                <p class="text-muted mb-0">{{$user->name}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->email}}</p>
                            </div>
                        </div>
                        <hr>

                </div>
                {{--<div class="row">--}}
                    {{--<div class="col-md-6">--}}
                        {{--<div class="card mb-4 mb-md-0">--}}
                            {{--<div class="card-body">--}}
                                {{--<p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status--}}
                                {{--</p>--}}
                                {{--<p class="mb-1" style="font-size: .77rem;">Web Design</p>--}}
                                {{--<div class="progress rounded" style="height: 5px;">--}}
                                    {{--<div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"--}}
                                         {{--aria-valuemin="0" aria-valuemax="100"></div>--}}
                                {{--</div>--}}

                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-6">--}}
                        {{--<div class="card mb-4 mb-md-0">--}}
                            {{--<div class="card-body">--}}
                                {{--<p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status--}}
                                {{--</p>--}}
                                {{--<p class="mb-1" style="font-size: .77rem;">Web Design</p>--}}
                                {{--<div class="progress rounded" style="height: 5px;">--}}
                                    {{--<div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"--}}
                                         {{--aria-valuemin="0" aria-valuemax="100"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
        </div>
    </section>
@endsection