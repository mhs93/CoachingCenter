@extends('layouts.dashboard.app')

@section('title', 'Edit Batch')


@push('css')
    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- Dropify CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
        .ck-editor__editable {
            min-height: 200px;
        }
    </style>
@endpush


@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.batches.index') }}">Batch List</a>

            </li>
        </ol>
        <a href="{{ route('admin.batches.index') }}" class="btn btn-sm btn-dark">Back to list</a>
    </nav>
@endsection

@section('content')

    @include('layouts.dashboard.partials.alert')
    <form action="{{ route('admin.batches.update', $batch->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="m-0">Edit Batch</p>
                        <a href="{{ route('admin.batches.index') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <input type="hidden" name="batch_id" id="batchId" value={{$batch->id}}>
                                <div class="form-group">
                                    <label for="batchname"><b>Batch name</b> </label>
                                    <input type="text" class="form-control my-1" id="batchName" name="name" placeholder="Enter Batch Name" value="{{ $batch->name }}">
                                    <div id="validName" class="text-danger"></div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            @php
                                $subjectIds = json_decode($batch->subject_id);
                            @endphp
                            <div class="form-group col-md-6">
                                <label for="subject_id"><b>Select Subjects</b></label>

                                @php
                                    $subjectIds = json_decode($batch->subject_id);
                                @endphp
                                <select name="subject_id[]" class="multi-subject form-control @error('subjects') is-invalid @enderror" multiple="multiple" id="mySelect2">
                                    <option value="0"
                                            @if (in_array("0", $subjectIds))
                                            selected
                                            @endif
                                    >
                                        All Subject
                                    </option>
                                    @forelse ($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            @if(in_array($subject->id, $subjectIds))
                                                {{ "selected" }}
                                            @endif
                                        >
                                            {{-- @if ($subject->id == $batch->subject_id) {{ 'selected' }} @endif> --}}
                                            {{ $subject->name }}
                                        </option>
                                    @empty
                                        <option>--No subject--</option>
                                    @endforelse
                                </select>
                                @error('subject_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="batch_fee"><b>Batch fee</b></label>
                                <input type="number" class="form-control my-1" id="batch_fee" value="{{ $batch->batch_fee }}"  name="batch_fee">
                                @error('batch_fee')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="start_time"><b>Start Date</b></label>
                                <input type="date" name="start_date" class="form-control" value="{{ $batch->start_date }}">
                                @error('start_time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="end_time"><b>End Date</b></label>
                                <input type="date" name="end_date" class="form-control" value="{{ $batch->end_date }}">
                                @error('end_time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label for="note"><b>Batch Note</b></label>
                            <textarea name="note" class="form-control" id="note" cols="30" rows="10">{{ $batch->note }}</textarea>
                            @error('note')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
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
                $('.multi-subject').select2();
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
