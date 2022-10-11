@extends('layouts.dashboard.app')

@section('title', 'Create Class Routine')

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Add class Routine</p>
            <a href="{{ route('admin.routine.index') }}" class="btn btn-sm btn-info">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.routine.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="hidden" name="batch_id" id="batchId">
                        <label for="batch">Select Batch</label>
                        <select name="batch_id" id="batch" class="form-control">
                            <option>Select</option>
                            @forelse ($batches as $batch)
                                <option value="{{ $batch->id }}" {{ old('batch_id') === $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }}</option>
                            @empty
                                <option>No batch</option>
                            @endforelse
                        </select>
                        @error('batch_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" id="batchStatus">
                                <option>Select status</option>
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                            <div id="validStatus" class="text-danger"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3 col-md-12" id="subList" >
                    <table class="table-bordered col-md-12 mt-6">
                        <thead align="center">
                            <th>Subjects</th>
                            <th>Day and Time</th>
                        </thead>
                        <tbody id="subjectTime">

                        </tbody>
                    </table>
                </div>
                <div class="form-group mt-3">
                    <label for="note">Exam Note</label>
                    <textarea name="note" class="form-control" id="note" cols="40" rows="6"></textarea>
                    @error('note')
                    <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>


                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-info">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div class="mb-5"></div>

    @push('js')

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#subList').hide();
            $(document).ready(function () {
                $('#batch').on('change',function () {
                    $('#subList').show();
                    let batch_id = $(this).val();
                    $("$subjectTime").empty();
                    $.ajax({
                        url: "{{ route('admin.routine.getsub') }}",
                        type: 'get',
                        data: {batchId: batch_id},
                        success: function (response) {
                            console.log(response);
                            $.each(response, function (key, value) {
                                console.log(value.id)
                                $("#subjectTime").append('<tr align="center">'+
                                                                '<td>'+value.name+
                                                                    '<input type="hidden" name="subject_id[]" id="subjectId" value="'+value.id+'">'+
                                                                '</td>' +
                                                                '<td>' +
                                                                    '<div class="row">'+
                                                                        '<div class="form-group col-md-4">'+
                                                                            '<label for="day">Day</label>'+
                                                                            '<select name="day" id="day" class="form-select @error("day") is-invalid @enderror">'+
                                                                            '<option value="">--Select Day--</option>'+
                                                                            '<option value="1">Saturday</option>'+
                                                                            '<option value="2">Sunday</option>'+
                                                                            '<option value="3">Monday</option>'+
                                                                            '<option value="4">Tuesday</option>'+
                                                                            '<option value="5">Wednesday</option>'+
                                                                            '<option value="6">Thursday</option>'+
                                                                            '<option value="7">Friday</option>'+
                                                                            '</select>'+
                                                                            '@error("day")'+
                                                                                '<span class="invalid-feedback" role="alert">'+
                                                                                    '<strong>{{ $message }}</strong>'+
                                                                                '</span>'+
                                                                            '@enderror'+
                                                                        '</div>'+
                                                                        '<div class="form-group col-md-4">'+
                                                                            '<h6>Start Time</h6>'+
                                                                            '<input type="datetime-local" name="start_time[]" class="form-control" placeholder="Start Time">'+
                                                                        '</div>'+
                                                                        '<div class="form-group col-md-4">'+
                                                                            '<h6>Exam End Time</h6>'+
                                                                            '<input type="datetime-local" name="end_time[]" class="form-control" placeholder="End Time">'+
                                                                            '@error("end_time")'+
                                                                                '<div class="text-danger">{{ $message }}</div>'+
                                                                            '@enderror'+
                                                                        '</div>'+
                                                                    '</div>'+
                                                                '</td>'+
                                                        '</tr>');
                        };
                    });
                })
            });

        </script>

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
