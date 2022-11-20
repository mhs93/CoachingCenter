@extends('layouts.dashboard.app')

@section('title', 'Create Class Routine')

@push('css')
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 320px;
        }
    </style>
@endpush

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
                        <input type="hidden" name="batch_id" id="batchId" >
                        <label for="batch"><b>Select Batch</b>  <span style="color: red">*</span></label>
                        <select name="batch_id" id="batchSelect" class="form-control">
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
                            <label for="status"><b>Status</b><span style="color: red">*</span></label>
                            <select name="status" class="form-control" id="batchStatus">
                                <option value="1" selected>Active</option>
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
                    <label for="note"><b>Exam Note</b> </label>
                    <textarea name="note" class="form-control" id="note" cols="40" rows="6"></textarea>
                    @error('note')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mt-3 float-right">
                    <button type="submit" class="btn btn-info float-right">Save</button>
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
                $('#batchSelect').on('change',function () {
                    $('#subList').show();
                    let batch_id = $(this).val();
                    $("#subjectTime").empty();
                    $.ajax({
                        url: "{{ route('admin.routine.getsub') }}",
                        type: 'get',
                        data: {batchId: batch_id},
                        success: function (response) {
                            $.each(response, function (key, value) {
                                $("#subjectTime").append(
                                    '<tr align="center">'+
                                    '<td>'+value.name+
                                    '<input type="hidden" name="subject_id[]" id="subjectId" value="'+value.id+'">'+
                                    '</td>' +
                                    '<td>' +
                                    '<div style="padding:10px" class="new-day-row_'+key+'" id="newDay">'+
                                    '<div class="row">'+
                                    '<div class="form-group col-md-4">'+
                                    '<label for="day">Day</label>'+
                                    '<select name="day_'+value.id+'[]" id="day" class="form-select @error("day") is-invalid @enderror">'+
                                    '<option value="">--Select Day--</option>'+
                                    '<option value="1">Saturday</option>'+
                                    '<option value="2">Sunday</option>'+
                                    '<option value="3">Monday</option>'+
                                    '<option value="4">Tuesday</option>'+
                                    '<option value="5">Wednesday</option>'+
                                    '<option value="6">Thursday</option>'+
                                    '<option value="7">Friday</option>'+
                                    '</select>'+
                                    '@error("day_'+value.id+'")'+
                                    '<span class="invalid-feedback" role="alert">'+
                                    '<strong>{{ $message }}</strong>'+
                                    '</span>'+
                                    '@enderror'+

                                    '</div>'+
                                    '<div class="form-group col-md-3">'+
                                    '<h6>Class Start Time</h6>'+
                                    '<input type="time" name="start_time[]" class="form-control">'+
                                    '</div>'+
                                    '<div class="form-group col-md-3">'+
                                    '<h6>Class End Time</h6>'+
                                    '<input type="time" name="end_time[]" class="form-control">'+
                                    '@error("end_time")'+
                                    '<div class="text-danger">{{ $message }}</div>'+
                                    '@enderror'+
                                    '</div>'+
                                    '<div class="form-group col-md-2 mt-4" align="center">'+
                                    '<button style="width:33px;" class="btn btn-primary btn-sm" type="button" id="appendButton'+key+'" onclick="addRow('+key+','+value.id+')">+</button>'+
                                    '</div>'+
                                    '</div>'+
                                    '</div>'+
                                    '</td>'+
                                    '</tr>');
                            });
                        }
                    });
                })
            });
            var counter= 1;
            function addRow(key, value){
                counter++;
                $('.new-day-row_'+key+'#newDay').append(
                    '<div class="row" id="append-row-'+counter+'">'+
                    '<div class="form-group col-md-4">'+
                    '<label for="day">Day</label>'+
                    '<select name="day_'+value+'[]" id="day" class="form-select @error("day_'+value+'") is-invalid @enderror">'+
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
                    '<div class="form-group col-md-3">'+
                    '<h6>Class Start Time</h6>'+
                    '<input type="time" name="start_time[]" class="form-control">'+
                    '</div>'+
                    '<div class="form-group col-md-3">'+
                    '<h6>Class End Time</h6>'+
                    '<input type="time" name="end_time[]" class="form-control">'+
                    '@error("end_time")'+
                    '<div class="text-danger">{{ $message }}</div>'+
                    '@enderror'+
                    '</div>'+
                    '<div class="form-group col-md-2 mt-4" align="center">'+
                    '<button style="width:33px;" class="btn btn-danger btn-sm " type="button" id="removeBtn'+key+'" onclick="DeleteRow('+counter+')">-</button>'+
                    '</div>'+
                    '</div>'
                );
            }
            function DeleteRow(key) {
                $('#append-row-'+key).remove();
            }

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