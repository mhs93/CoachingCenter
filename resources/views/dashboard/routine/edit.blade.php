@extends('layouts.dashboard.app')

@section('title', 'Update routine')

@push('css')
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 200px;
        }
    </style>
@endpush

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.routine.index') }}">Routine List</a>

            </li>
        </ol>
        <a href="{{route('admin.routine.index')}}" class="btn btn-sm btn-dark">Back</a>
    </nav>
@endsection
@section('content')
    @include('layouts.dashboard.partials.alert')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Add class Routine</p>
            <a href="{{ route('admin.routine.index') }}" class="btn btn-sm btn-info">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.routine.update', $routine->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="hidden" name="batch_id" id="batchId" >
                        <label for="batch"><b>Batch</b></label>
                        <input type="text" class="form-control" value="{{$routine->batch->name}}" readonly/>
                        @error('batch_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="status"> <b>Status</b></label>
                            <select name="status" value="{{$routine->status}}" class="form-control" id="batchStatus">
                                <option>Select status</option>
                                <option value="1" @if($routine->status == 1) selected @endif>Active</option>
                                <option value="0" @if($routine->status == 0) selected @endif>Deactive</option>
                            </select>
                            <div id="validStatus" class="text-danger"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3 col-md-12" id="subList" >
                    <table class="table-bordered col-md-12 mt-6">
                        <thead align="center">
                            <th>Subject</th>
                            <th>Day and Time</th>
                        </thead>
                        <tbody >
                            <tr>
                                <td style="text-align: center">
                                    <div class="align-items-center">{{ $routine->subject->name }}</div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="day">Day</label>
                                            <select name="day" id="day" value="{{ $routine->day }}" class="form-select @error('day') is-invalid @enderror">
                                                <option value="">--Select Day--</option>
                                                <option value="1" @if($routine->day == 1) selected @endif >Saturday</option>
                                                <option value="2" @if($routine->day == 2) selected @endif>Sunday</option>
                                                <option value="3" @if($routine->day == 3) selected @endif>Monday</option>
                                                <option value="4" @if($routine->day == 4) selected @endif>Tuesday</option>
                                                <option value="5" @if($routine->day == 5) selected @endif>Wednesday</option>
                                                <option value="6" @if($routine->day == 6) selected @endif>Thursday</option>
                                                <option value="7" @if($routine->day == 7) selected @endif>Friday</option>
                                            </select>
                                            @error("day")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <h6>Class Start Time</h6>
                                            <input type="time" name="start_time" class="form-control" value="{{ date('H:i', strtotime($routine->start_time)) }}">
                                            @error("start_time")
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <h6>Class End Time</h6>
                                            <input type="time" name="end_time" value="{{ date('H:i', strtotime($routine->end_time)) }}" class="form-control">
                                            @error("end_time")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-group mt-3">
                    <label for="note"> <b>Exam Note</b></label>
                    <textarea name="note" class="form-control" id="note" cols="40" rows="6">{{ $routine->note}}</textarea>
                    @error('note')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mt-3 float-right">
                    <button type="submit" class="btn btn-info float-right">Update</button>
                </div>
            </form>
        </div>
    </div>
    <div class="mb-5"></div>

    @push('js')
        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#note'), {
                    removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush

@endsection
