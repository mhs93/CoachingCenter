@extends('layouts.dashboard.app')

@section('title', 'Classroom Details Show')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.class-rooms.index') }}">Class Room List</a>
            </li>
        </ol>
        <a href="{{ route('admin.class-rooms.index') }}" class="btn btn-sm btn-dark">Back to list</a>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Class Room Information</p>
            <a href="{{ route('admin.class-rooms.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <table id="table" class="table table-bordered data-table" style="width: 100%">
                        <tbody>
                        <tr>
                            <td>Batch Name</td>
                            <td>{{ $batch->name }}</td>
                        </tr>
                        <tr>
                            <td>Subject Name</td>
                            <td>{{ $subject->name }}</td>
                        </tr>
                        <tr>
                            <td>Class Type</td>
                            <td>
                                @if($classroom->class_type == 1)
                                    Physical
                                    @else
                                    Online
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Class Link</td>
                            <td>{{ $classroom->class_link }}</td>
                        </tr>
                        <tr>
                            <td>Class Access Key</td>
                            <td>{{ $classroom->access_key }}</td>
                        </tr>
                        <tr>
                            <td>Class Date</td>
                            <td>{{ $classroom->date }}</td>
                        </tr>
                        <tr>
                            <td>Start Time</td>
                            <td>{{ $classroom->start_time }}</td>
                        </tr>
                        <tr>
                            <td>End Time</td>
                            <td>{{ $classroom->end_time }}</td>
                        </tr>
                        <tr>
                            <td>Classroom Note</td>
                            <td>{!! $classroom->note !!}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
