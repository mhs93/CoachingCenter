@extends('layouts.dashboard.app')

@section('title', 'Teacher profile')


@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Teacher Information</p>
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <table id="table" class="table table-bordered data-table" style="width: 100%">
                        <tbody>
                            <tr>
                                <td>Full Name</td>
                                <td>{{ $teacher->name }}</td>
                            </tr>
                            <tr>
                                <td>Subject List</td>
                                <td>{{ $batchSubs }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $teacher->email }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ $teacher->contact_number }}</td>
                            </tr>
                            <tr>
                                <td>Present Address</td>
                                <td>{{ $teacher->current_address }}</td>
                            </tr>
                            <tr>
                                <td>Permanent Address</td>
                                <td>{{ $teacher->permanent_address }}</td>
                            </tr>
                            <tr>
                                <td>Teacher note</td>
                                <td>{!! $teacher->note !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                    <div>
                        <img src="{{ asset('images/users/'.$teacher->profile)}}" alt="Image" class=" img-fluid" style="width: 150px;">
                    </div>
                    @can('teacher_edit')
                        <div class="form-group mt-3">
                            <a href="{{ route('admin.teachers.edit',$teacher->id) }}" class="btn btn-sm btn-primary" onclick="">Edit</a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
