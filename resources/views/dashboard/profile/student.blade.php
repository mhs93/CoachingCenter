@extends('layouts.dashboard.app')

@section('title', 'Student Profile')

@push('css')

@endpush

@section('content')
    <section style="background-color: #eee;">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="{{ asset('images/users/'.$user->student->profile) }}"
                             class="rounded-circle img-fluid" style="width: 150px;">

                        <h5 class="my-3">{{ $user->student->name }}</h5>
                        <p class="text-muted mb-1">{{$user->student->batch->name}}</p>
                        <p class="text-muted mb-1">Reg No: {{$user->student->reg_no}}</p>
                        <div class="row">
                            <div class="mt-3">
                                <a href="{{route('admin.password')}}" class="btn btn-sm btn-success">Change Password</a>
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
                                <p class="mb-0">Name</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->student->name}}</p>
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
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Phone</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->student->contact_number}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Parent Phone</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->student->parent_contact}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Permanent Address</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->student->permanent_address}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Current Address</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->student->current_address}}</p>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="mt-3">
                                <a href="{{route('admin.password')}}" class="btn btn-sm btn-success">Change Password</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
                integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function () {
                $('.dropify').dropify();
            });
        </script>
    @endpush


@endsection
