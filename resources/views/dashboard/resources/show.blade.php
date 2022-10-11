@extends('layouts.dashboard.app')

@section('title', 'Resource Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Resource Information</p>
            <a href="{{ route('admin.resources.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <table id="table" class="table table-bordered data-table" style="width: 100%">
                        <tbody>
                            <tr>
                                <td>Title</td>
                                <td>{{ $resource->title }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>{{ $resource->status ? 'Active' : 'Inactive' }}</td>
                            </tr>
                            
                            <tr>
                                <td>Batches</td>
                                <td>{{ $batch_name}}</td>
                            </tr>
                            <tr>
                                <td>Subjects</td>
                                <td>{{ $subject_name }}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>{!! $resource->note !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-3">
                    <div>
                        <img src="{{ asset('files/'.$resource->file)}}" alt="Image" class=" img-fluid" style="width: 300px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
