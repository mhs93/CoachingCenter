@extends('layouts.dashboard.app')

@section('title', 'Exam Marks')

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

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Exam Marks</p>
            <a href="{{ URL::previous() }}" class="btn btn-sm btn-dark">Back</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div align="center">
                        <h5>
                            Student Name: <span style="color:green">{{ $student->name }}</span> &nbsp;
                            Exam Name: <span style="color:red">{{ $exam->name }}</span> &nbsp;
                            Batch Name: <span style="color:blue">{{ $batch->name }}</span>
                        </h5>
                    </div><br>

                    @if (count($marks) > 0)
                        <table class="table table-bordered col-md-12 mt-6">
                            <thead align="center">
                                {{-- <th>Places</th> --}}
                                <th>Students</th>
                                <th width="25%">Subjects/Mark</th>
                                <th>Total</th>
                            </thead>
                            <tbody align="center">
                                @foreach ($marks as $key => $mark)
                                    <tr>
                                        {{-- <td style="vertical-align: middle;">{{$key + 1}}</td> --}}
                                        <td style="vertical-align: middle;">{{$mark->student->name}}</td>
                                        <td>
                                            @php
                                                $subject_id = json_decode($mark->subject_id);
                                                $subMark = json_decode($mark->mark);
                                                $subjects = App\Models\Subject::whereIn('id', $subject_id)->get();
                                            @endphp
                                                @foreach ($subjects as $k => $subject)
                                                <div class="row">
                                                    <div class="col-md-8" style="text-align: right;">{{$subject->name}} : </div>
                                                    <div class="col-md-4" style="text-align: left;">{{$subMark[$k]}}</div>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td style="vertical-align: middle;">{{$mark->total}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div>
                            <p><h4 align="center">There is no marks for this batch</h4></p>
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

