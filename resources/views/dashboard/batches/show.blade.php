@extends('layouts.dashboard.app')

@section('title', 'Batch Details')


@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Batch Information</p>
            <a href="{{ route('admin.batches.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div> 
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table id="table" class="table table-bordered data-table" style="width: 100%">
                        <tbody>
                            <tr>
                                <td>Batch Name</td>
                                <td>{{ $batch->name }}</td>
                            </tr>
                            <tr>
                                <td>Subject List</td>
                                <td>{{ $batchSubs }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>{{ $batch->status ? 'Active' : 'Dead' }}</td>
                            </tr>

                            <tr>
                                <td>Start Date</td>
                                <td>{{ $batch->start_date }}</td>
                            </tr>
                            <tr>
                                <td>End Date</td>
                                <td>{{ $batch->end_date }}</td>
                            </tr>

                            <tr>
                                <td>Initial Batch Fee</td>
                                <td>{{ $batch->initial_amount }}</td>
                            </tr>

                            @if ($balance)
                                <tr>
                                    <td>Adjustment Balance</td>
                                    <td>{{ $batch->adjustment_balance }}</td>
                                </tr>

                                <tr>
                                    <td>Adjustment Type</td>
                                    <td>{{ $batch->adjustment_type }}</td>
                                </tr>

                                <tr>
                                    <td>Adjustment Cause</td>
                                    <td>{{ $batch->adjustment_cause }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td>Totol Batch Fee</td>
                                <td>{{ $batch->total_amount }}</td>
                            </tr>

                            <tr>
                                <td>Description</td>
                                <td>{!! $batch->note !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                    @can('batches_modify')
                        <div class="form-group mt-3">
                            <a href="{{ route('admin.batches.edit', $batch->id) }}" class="btn btn-sm btn-primary" onclick="">Edit</a>
                        </div>
                    @endcan
                </div>

            </div>
        </div>
    </div>
@endsection
