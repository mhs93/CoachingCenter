@extends('layouts.dashboard.app')

@section('title', 'Attendance')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>

            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <p class="m-0">Student Attendance</p>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ route('admin.students.by.batch') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="orderDate">Date<span class="text-red-600">*</span></label>
                            <input id="date" class="form-control" placeholder="" required="required" name="date"
                                   type="date">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="batch_id">Batch<span class="text-red-600">*</span></label>
                            <select class="form-control" name="batch_id" id="batch_id" required="">
                                <option value="">select batch</option>
                                @foreach($batches as $batch)
                                    <option value="{{$batch->id}}">{{$batch->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-info" style="margin-top: 24px">
                                Get Student List
                            </button>
                        </div>
                    </div>
                </form>
                <div>

                </div>

            </div>

        </div>
    </div>
@endsection
