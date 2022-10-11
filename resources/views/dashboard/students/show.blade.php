@extends('layouts.dashboard.app')
@section('title','Student Details')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.students.index') }}">Student List</a>
            </li>
        </ol>
        <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-dark">Back to list</a>
    </nav>
@endsection

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Student Information</p>
            <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-dark">Back to list</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <table id="table" class="table table-bordered data-table" style="width: 100%">
                        <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ $student->name }}</td>
                        </tr>
                        <tr>
                            <td>Registration No.</td>
                            <td>{{ $student->reg_no }}</td>
                        </tr>
                        <tr>
                            <td>Batch</td>
                            <td>{{ $student->batch->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $student->email }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ $student->contact_number }}</td>
                        </tr>
                        <tr>
                            <td>Parent Phone</td>
                            <td>{{ $student->parent_contact }}</td>
                        </tr>
                        <tr>
                            <td>Present Address</td>
                            <td>{{ $student->current_address }}</td>
                        </tr>
                        <tr>
                            <td>Permanent Address</td>
                            <td>{{ $student->permanent_address }}</td>
                        </tr>
                        <tr>
                            <td>Student Note</td>
                            <td>{!! $student->note !!}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                <div class="col-md-3">
                    <div>
                        <img src="{{ asset('images/users/'.$student->profile)}}" alt="Image" class=" img-fluid" style="width: 150px;">
                    </div>
                    @can('student_edit')
                    <div class="form-group mt-3">
                        <a href="{{ route('admin.students.edit',$student->id) }}" class="btn btn-sm btn-primary" onclick="">Edit</a>
                    </div>
                    @endcan
                </div>

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>
@endpush
