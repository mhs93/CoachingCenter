@extends('layouts.dashboard.app')

@section('title', 'attendances')

@push('css')
<style>
    /*table {*/
        /*width: 100%;*/
    /*}*/

    /*.paging_simple_numbers,*/
    /*.dataTables_filter {*/
        /*float: right;*/
    /*}*/
</style>
@endpush

@section('breadcrumb')
<nav aria-label="breadcrumb" class="d-flex  align-items-center justify-content-between" style="width: 100%">
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.attendances.index') }}">Attendance List</a>

        </li>
    </ol>

</nav>
@endsection

@section('content')
@include('layouts.dashboard.partials.alert')
<div class="card">
    <div class="card-header">
        <p class="m-0">Attendance</p>
    </div>
    <div class="card-body">
        <p>Attendance Date:<b> {{$date}}</b></p>
        @if(!empty($students))
        <form action="{{route('admin.attendances.store')}}" method="POST">
            @csrf
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Batch</th>
                    <th scope="col">Registration no.</th>
                    <th scope="col">Attendance</th>
                </tr>
                </thead>
                <tbody>

                    @foreach($students as $key=> $student)
                        <tr>
                            <input type="hidden" name="student_id[]" value="{{ $student->id }}">
                            <input type="hidden" name="date[]" value="{{ $date }}">
                            <input type="hidden" name="batch_id[]" value="{{$student->batch_id}}">
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{$student->name}}</td>
                            <td>{{$student->batch->name}}</td>
                            <td>{{$student->reg_no}}</td>
                            {{--@foreach($student->attendance as $attendance)--}}
                            <td>
                                <input type="radio" id="present-{{$key}}" name="attendance_{{ $key }}" value="1">
                                <label for="present-{{$key}}" >Present</label>
                                <input type="radio" id="absent-{{$key}}" name="attendance_{{ $key }}" value="0" checked >
                                <label for="absent-{{$key}}">Absent</label>
                            </td>
                            {{--@endforeach--}}
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div >
                <button type="submit" class="btn btn-sm btn-primary" style="float:right" >Save</button>
            </div>
        </form>
        @endif

        @if(!empty($attendances))
        <form action="{{route('admin.attendances.update')}}" method="POST">
            @csrf
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Batch</th>
                    <th scope="col">Registration no.</th>
                    <th scope="col">Attendance</th>
                </tr>
                </thead>
                <tbody>
                @foreach($attendances as $key=> $attendance)
                    <tr>
                        <input type="hidden" name="student_id[]" value="{{ $attendance->student->id }}">
                        {{--<input type="hidden" name="date" value="{{ $attendance->date }}">--}}
                        <input type="hidden" name="date[]" value="{{ $date }}">
                        <input type="hidden" name="batch_id[]" value="{{$attendance->student->batch_id}}">
                        <td scope="row">{{ $loop->iteration }}</td>
                        <td>{{$attendance->student->name}}</td>
                        <td>{{$attendance->batch->name}}</td>
                        <td>{{$attendance->student->reg_no}}</td>
                        {{--@foreach($student->attendance as $attendance)--}}
                        <td>
                            <input type="radio" id="present-{{$key}}" name="attendance_{{$key}}" value="1"
                                        {{ $attendance->status == 1 ? 'checked' : ''  }}  >
                            <label for="present-{{$key}}">Present</label>
                            <input type="radio" id="absent-{{$key}}" name="attendance_{{$key}}" value="0"
                                        {{ $attendance->status == 0 ? 'checked' : ''  }} >
                            <label for="absent-{{$key}}">Absent</label>
                        </td>
                        {{--@endforeach--}}
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <div >
                <button type="submit" class="btn btn-sm btn-primary" style="float:right" >Save</button>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('jquery/jQuery.js') }}"></script>
<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- sweetalert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(() => {
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
        toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
        toastr.success('{{ Session::get('success') }}');
        @endif
    });
</script>

@endpush
