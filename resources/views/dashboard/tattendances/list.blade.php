@extends('layouts.dashboard.app')

@section('title', 'Teacher Attendances')

@push('css')
<style>

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
        <p class="m-0">Teacher Attendance</p>
    </div>
    <div class="card-body">
        <div class="row mt-1">
            <div class="col-sm-4">
                <p> Attendance Date : <b> {{ $date }}</b>
            </div>
        </div>

        {{-- Create --}}
        @if(!empty($teachers))
        <form action="{{route('admin.tattendances.store')}}" method="POST">
            @csrf
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead style="text-align: center">
                    <tr>
                        <td scope="col">#SL</td>
                        <th scope="col">Teacher Name</th>
                        <th scope="col">Registration no.</th>
                        <th scope="col">Attendance</th>
                    </tr>
                </thead>
                
                <tbody style="text-align: center">
                    @foreach($teachers as $key=> $teacher)
                        <tr >
                            <input type="hidden" name="teacher_id[]" value="{{ $teacher->id }}">
                            <input type="hidden" name="date[]" value="{{ $date }}">
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{$teacher->name}}</td>
                            <td>{{$teacher->reg_no}}</td>
                            <td>
                                <input type="radio" id="present-{{$key}}" name="attendance_{{ $key }}" value="1">
                                <label for="present-{{$key}}" >Present</label>
                                <input type="radio" id="absent-{{$key}}" name="attendance_{{ $key }}" value="0" checked >
                                <label for="absent-{{$key}}">Absent</label>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div >
                <button type="submit" class="btn btn-sm btn-primary" style="float:right" >Save</button>
            </div>
        </form>
        @endif



        {{-- Edit --}}
        @if(!empty($attendances))
        <form action="{{route('admin.tattendances.update')}}" method="POST">
            @csrf
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                <tr>
                    <td scope="col">#SL</td>
                    <th scope="col">Teacher Name</th>
                    <th scope="col">Registration no.</th>
                    <th scope="col">Attendance</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $key=> $attendance)
                        <tr>
                            <input type="hidden" name="teacher_id[]" value="{{ $attendance->teacher->id }}">
                            <input type="hidden" name="date[]" value="{{ $date }}">
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{$attendance->teacher->name}}</td>
                            <td>{{$attendance->teacher->reg_no}}</td>
                            <td>
                                <input type="radio" id="present-{{$key}}" name="attendance_{{$key}}" value="1"
                                        {{ $attendance->status == 1 ? 'checked' : ''  }}  >
                                <label for="present-{{$key}}">Present</label>
                                <input type="radio" id="absent-{{$key}}" name="attendance_{{$key}}" value="0"
                                            {{ $attendance->status == 0 ? 'checked' : ''  }} >
                                <label for="absent-{{$key}}">Absent</label>
                            </td>
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
