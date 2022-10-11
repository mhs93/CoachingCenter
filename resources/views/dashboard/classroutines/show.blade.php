@extends('layouts.dashboard.app')

@section('title', 'CLass Room Details')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.routines.index') }}">Class Routine List</a>
            </li>
        </ol>
        <a href="{{ route('admin.routines.index') }}" class="btn btn-sm btn-dark">Back to list</a>
    </nav>
@endsection


@section('content')
    <div class="card">
        <div class="card-header">
            <p class="m-0">Class Routine Information</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table id="table" class="table table-bordered data-table" style="width: 100%">
                        <tbody>
                            <tr>
                                <td>Batch Name</td>
                                <td>{{ $routine->batch->name }}</td>
                            </tr>
                            <tr>
                                <td>Subject Name</td>
                                <td>{{ $routine->subject->name }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>{{ $routine->status ? 'Active' : 'Inactive' }}</td>
                            </tr>
                            <tr>
                                <td>Note</td>
                                <td>{!! $routine->note !!}</td>
                            </tr>
                            <tr>
                                <td>Day</td>
                                <td>{{ $routine_days }}</td>
                            </tr>
                            <tr>
                                <td>Time</td>
                                <td>{{ $routine->time }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {{-- <div class="col-md-3">
                    @can('batch_edit')
                        <div class="form-group mt-3">
                            <a href="{{ route('admin.batches.edit', $batch->id) }}" class="btn btn-sm btn-primary" onclick="">Edit</a>
                        </div>
                    @endcan
                </div> --}}

            </div>
        </div>
    </div>
@endsection
