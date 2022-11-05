@extends('layouts.dashboard.app')

@section('title', 'Edit Exam')

@push('css')
    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
            <p class="m-0">Update Exam</p>
            <a href="{{ route('admin.exams.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.exams.update', $exam->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{$exam->id}}">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="batchname"><b>Exam name</b> </label>
                            <input type="text" class="form-control my-1" id="batchName" name="name" value="{{$exam->name}}" >
                            <div id="validName" class="text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="status"><b>Status</b> </label>
                            <select name="status" id="status"  class="form-control @error('status') is-invalid @enderror">
                                <option value="1" @if($exam->status=="1") {{'selected'}} @endif>Active</option>
                                <option value="0" @if($exam->status=="0") {{'selected'}} @endif>Deactive</option>
                            </select>
                        </div>
                    </div>

                    {{-- @php
                        $batchIds = [];
                        foreach($examDetails as $exams){
                            $batchIds[] = $exams->batch_id;
                        }
                    @endphp --}}

                    {{-- <div class="form-group col-md-12">
                        <div class="form-group">
                            <label for="batch_id">Select Batch</label>
                            <select name="batch_id[]" id="batchIdEx" class="multi-subject form-control @error('batch_id') is-invalid @enderror" multiple="multiple">
                                @forelse ($batches as $batch)
                                    <option value="{{ $batch->id }}"
                                        @if(in_array($batch->id, $batchIds))
                                            {{ "selected" }}
                                        @endif
                                    >
                                    {{ $batch->name }}
                                    </option>
                                @empty
                                    <option>--No Batch--</option>
                                @endforelse
                            </select>
                        </div>
                    </div> --}}

                </div>

                <div class="form-group mt-3">
                    <table class="main table-bordered col-md-12 mt-6">
                        <thead align="center">
                            <tr>
                                <th>Batch</th>
                                <th>Subjects</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                            </tr>
                        </thead>

                        @foreach ($examDetails as $item)
                            <tbody>
                                <tr>
                                    <td>
                                        <div>
                                            {{-- Batch--}}
                                            {{$item->batch->name}}
                                            <input type="hidden" name="batch_id[]" value={{$item->batch->id}}>
                                        </div>
                                    </td>

                                    <td>
                                        {{-- Subject --}}
                                        <div>
                                            {{$item->subject->name}}
                                            <input type="hidden" name="subject_id[]" value={{$item->subject->id}}>
                                        </div>
                                    </td>

                                    <td>
                                        {{-- Date --}}
                                        <div>
                                            <h6>Start Date</h6>
                                            <input type="date" name="start_date[]" class="form-control" value="{{$item->start_date}}">
                                            @error("start_time")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </td>

                                    <td>
                                        {{-- Start Time --}}
                                        <div>
                                            <h6>Start Time</h6>
                                            <input type="time" name="start_time[]" class="form-control" value="{{$item->start_time}}">
                                            @error("start_time")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </td>

                                    <td>
                                        {{-- Date --}}
                                        <div>
                                            <h6>End Date</h6>
                                            <input type="date" name="end_date[]" class="form-control" value="{{$item->end_date}}">
                                            @error("start_time")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </td>

                                    <td>
                                        {{-- End Time --}}
                                        <div>
                                            <h6>End Time</h6>
                                            <input type="time" name="end_time[]" class="form-control" value="{{$item->end_time}}">
                                            @error("end_time")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>

                {{-- Sub-Form Start --}}
                {{-- <div class="form-group mt-3 col-md-12" id="subForm" >
                </div> --}}
                {{-- Sub-Form End --}}

                {{-- Exam Note --}}
                <div class="form-group mt-3">
                    <label for="note"><b>Exam Note</b> </label>
                    <textarea name="note" class="form-control" id="note" cols="40" rows="6"> {!! $exam->note !!} </textarea>
                    @error('note')
                    <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        {{-- Select2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        {{-- Ckeditor CDN --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function () {
                // Depedancy Start
                $('#batchIdEx').on('change', function() {
                    let batch_id = $(this).val();
                    $("#subjectEx").empty();
                    $.ajax({
                        url: "{{ route('admin.getSubjects') }}",
                        type: 'post',
                        data: { batchId: batch_id},
                        success: function(response) {
                            console.log(response);
                            $.each(response, function(key, value) {
                                console.log(value.id)
                                $("#subjectEx").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                            });
                        }
                    });
                });
                // Depedancy End

                // Select2 for multi subject
                $('.multi-subject').select2();

                // For adding new batch and subject
                // $('#subForm').hide();
                // $('#batchIdEx').on('change', function() {
                //     $('#subForm').show();
                //     let batch_id = $(this).val();
                //     $("#subForm").empty();
                //     $.ajax({
                //         url: "{{ route('admin.exams.getSub') }}",
                //         type: 'post',
                //         data: { batchId: batch_id},
                //         success: function(response) {
                //             $('#subForm').html(response);
                //         }
                //     });
                // });

                // Ckeditor
                ClassicEditor.create(document.querySelector('#note'), {
                    removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
                })
                .catch(error => {
                    console.error(error);
                });

            });
        </script>
    @endpush

@endsection
