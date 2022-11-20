@extends('layouts.dashboard.app')

@section('title', 'Subject Details Show')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.teachers.index') }}">Teacher List</a>
            </li>
        </ol>
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-sm btn-dark">Back to list</a>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Subject Details</p>
            <a href="{{ route('admin.subjects.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table id="table" class="table table-bordered data-table" style="width: 100%">
                        <tbody>
                        <tr>
                            <td>Subject Name</td>
                            <td>{{ $subject->name }}</td>
                        </tr>
                        <tr>
                            <td>Subject Code</td>
                            <td>{{ $subject->code }}</td>
                        </tr>

                        <tr>
                            <td>Subject Fee</td>
                            <td>{{ $subject->fee }}</td>
                        </tr>

                        <tr>
                            <td>Subject Note</td>
                            <td>{!! $subject->note !!}</td>
                        </tr>

                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    @can('subject_modify')
                        <div class="form-group mt-3">
                            <a href="{{ route('admin.subjects.edit',$subject->id) }}" class="btn btn-sm btn-primary" onclick="">Edit</a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
