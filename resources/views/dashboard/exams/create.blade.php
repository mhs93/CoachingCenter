@extends('layouts.dashboard.app')

@section('title', 'Create Exam')

@push('css')
    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
    </style>
@endpush

@section('content')
    @include('layouts.dashboard.partials.alert')
    <form action="{{ route('admin.exams.store') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="m-0">Create Exam</p>
                        <a href="{{ route('admin.exams.index') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="hidden" name="batch_id" id="batchId">
                                <div class="form-group">
                                    <label for="batchname">Exam name</label>
                                    <input type="text" class="form-control my-1" id="batchName" name="name" placeholder="Enter Exam Name" >
                                    <div id="validName" class="text-danger"></div>
                                </div>
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

                        {{-- Dependancy Start --}}
                        <div class="form-group mt-6">
                            <label for="batch">Select Batch</label>
                            <select name="batch_id[]" id="batchIdEx"
                                class="multi-batch mySelect2 form-control @error('batch_id') is-invalid @enderror"
                                multiple="multiple">
                                {{-- <option value="0">
                                    All Batch
                                </option> --}}
                                @forelse ($batches as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @empty
                                    <option>No batch</option>
                                @endforelse
                            </select>
                            @error('batch_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Sub-Form Start --}}
                        <div class="form-group mt-3 col-md-12" id="subForm" >
                            <table class="table-bordered col-md-12 mt-6">
                                <thead align="center">
                                    <th>Subjects</th>
                                    <th>Exam Date and Time</th>
                                </thead>
                                <tbody id="subjectEx">

                                </tbody>
                            </table>
                        </div>
                        {{-- Sub-Form End --}}

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
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="mb-5"></div>

    @push('js')
        {{-- Select2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {

                $('.multi-batch').select2();
                $('.multi-subject').select2();
            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
            integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
            crossorigin="anonymous" referrerpolicy="no-referrer">
        </script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#subForm').hide();
            $(document).ready(function() {
                // Dependancy for batch and subjects
                $('#batchIdEx').on('change', function() {
                    $('#subForm').show();
                    let batch_id = $(this).val();
                    $("#subjectEx").empty();
                    $.ajax({
                        url: "{{ route('admin.exams.getSub') }}",
                        type: 'post',
                        data: { batchId: batch_id},
                        success: function(response) {
                            console.log(response);
                            $.each(response, function(key, value) {
                                console.log(value.id)
                                $("#subjectEx").append('<tr align="center">'+
                                                            '<td>'+value.name+
                                                                '<input type="hidden" name="subject_id[]" id="subjectId" value="'+value.id+'">'+
                                                            '</td>' +
                                                            '<td>' +
                                                                '<div class="row">'+
                                                                    '<div class="form-group col-md-6">'+
                                                                        '<h6>Exam Start Time</h6>'+
                                                                        '<input type="datetime-local" name="start_time[]" class="form-control" placeholder="Start Time">'+
                                                                    '</div>'+
                                                                    '<div class="form-group col-md-6">'+
                                                                        '<h6>Exam End Time</h6>'+
                                                                        '<input type="datetime-local" name="end_time[]" class="form-control" placeholder="End Time">'+
                                                                        '@error("end_time")'+
                                                                            '<div class="text-danger">{{ $message }}</div>'+
                                                                        '@enderror'+
                                                                    '</div>'+
                                                                '</div>'+
                                                            '</td>'+
                                                        '</tr>');
                            });
                        }
                    });
                });
                // Dependancy End


            });
        </script>

        {{-- Ckeditor5 --}}
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
