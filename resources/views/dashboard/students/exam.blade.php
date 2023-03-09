@extends('layouts.dashboard.app')

@section('title', 'Exam List')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
          integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
    </style>
@endpush

@section('content')
    @include('layouts.dashboard.partials.alert')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Marked Exam List</p>
            <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-dark">Back to list</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @php
                        $studentId = $student->id;
                        $batchId   = $student->batch_id;
                    @endphp
                    @if ($exams)
                        <table id="table" class="table table-bordered data-table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Exam Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($exams as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            {{-- <a href=" {{route('admin.students.exam.result', ['id' => $item->id]) }} " class="btn btn-primary">See Result</a> --}}
                                            {{-- <a href=" {{route('admin.students.exam.result', ['id1'=>$item->id, 'id2'=>$studentId]) }} " class="btn btn-primary">See Result</a> --}}
                                            <a href=" {{route('admin.students.exam.result', ['id1'=>$item->id, 'id2'=>$batchId, 'id3'=>$studentId]) }} " class="btn btn-primary">See Result</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div align="center">
                            <h4>No Result Yet For Any Exam</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="mb-5"></div>

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
                integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function () {
                $('.dropify').dropify();
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
