@extends('layouts.dashboard.app')

@section('title', 'Edit Classroom')

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Update class room</p>
            <a href="{{ route('admin.class-rooms.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.class-rooms.update', $classRoom->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="batch">Select Batch</label>
                        <select name="batch_id" id="batchIdEx" class="form-control">
                            @forelse ($batches as $batch)
                                <option value="{{ $batch->id }}" {{ $classRoom->batch_id == $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }}</option>
                            @empty
                                <option>No batch</option>
                            @endforelse
                        </select>
                        @error('batch_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Subject --}}
                    <div class="form-group col-md-6">
                        <label for="subject">Select Subject</label>
                        <select name="subject_id" id="subjectEx" class="form-control">
                            @forelse ($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $classRoom->subject_id == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}</option>
                            @empty
                                <option>No Subject</option>
                            @endforelse
                        </select>
                        @error('subject_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="class_type">Class Type</label>
                        <select name="class_type" id="class_type" value="{{ ($classRoom->class_type) }}"
                                class="form-select @error('class_type') is-invalid @enderror">
                            <option>--Select class type--</option>
                            <option value="1" @if($classRoom->class_type == 1) selected @endif>Physical</option>
                            <option value="2" @if($classRoom->class_type == 2) selected @endif>Online</option>
                        </select>
                        @error('class_type')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="start_time">Start Time</label>
                        <input type="datetime-local" name="start_time" class="form-control" placeholder="Start Time" value="{{ $classRoom->start_time }}">
                        @error('start_time')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="end_time">End Time</label>
                        <input type="datetime-local" name="end_time" class="form-control" placeholder="End Time" value="{{ $classRoom->end_time }}">
                        @error('end_time')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="duration">Duration</label>
                        <input type="text" name="duration" class="form-control" placeholder="Enter Duration" value="{{ $classRoom->duration }}">
                        @error('duration')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6" id="accessKey">
                        <label for="access_key">Access Key</label>
                        <input type="text" name="access_key" class="form-control" placeholder="Generate Access Key" value="{{ $classRoom->access_key }}">
                        @error('access_key')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="form-group mt-2" id="classLink">
                    <label for="class_link">Class Video Link</label>
                    <input type="text" name="class_link" class="form-control" placeholder="Enter Video Link" value="{{ $classRoom->class_link }}">
                    @error('class_link')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-info">Update</button>
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

            $(document).ready(function () {
                $('#accessKey').hide();
                $('#classLink').hide();

                let accessKey = $('#accessKey').val();
                let classLink = $('#classLink').val();

                if (class_type == 1){
                    $('#accessKey').hide();
                    $('#classLink').hide();
                }
                else if(class_type == 2){
                    $('#accessKey').show();
                    $('#classLink').show();
                }

                $('#class_type').on('change',function () {
                    if (this.value == 1){
                        $('#accessKey').hide();
                        $('#classLink').hide();
                    }
                    if (this.value == 2){
                        $('#accessKey').show();
                        $('#classLink').show();
                    }
                })

                // Dependancy for batch and subjects
                $('#batchIdEx').on('change', function() {
                    let batch_id = $(this).val();
                    $("#subjectEx").empty();
                    $.ajax({
                        url: "{{ route('admin.getSubjects') }}",
                        type: 'post',
                        data: { batchId: batch_id},
                        success: function(response) {
                            // $('#subject').html(response)
                            console.log(response);
                            $.each(response, function(key, value) {
                                console.log(value.id)
                                $("#subjectEx").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                            });
                        }
                    });
                });
            })

        </script>
    @endpush

@endsection