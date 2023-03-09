@extends('layouts.dashboard.app')
@section('title', 'Student Attendance Report')

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <p class="m-0">Student Attendance Report</p>
            <a href="{{ route('admin.attendances.report') }}" class="btn btn-sm btn-info">Back</a>
        </div>
        <div class="card-body">
                    <table id="table" class="table table-bordered data-table" style="width: 100%">
                        <thead>
                            <tr style="text-align: center">
                                <th scope="col">Date</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Batch</th>
                                <th scope="col">Registration no.</th>
                                <th scope="col">Attendance</th>
                            </tr>
                        </thead>

                        <tbody style="text-align: center">
                            @foreach($reports as $key=> $report)
                                <tr>
                                    <td>{{ $report -> date }}</td>
                                    <td scope="row">{{ $report->student->name }}</td>
                                    <td>{{$report->batch->name}}</td>
                                    <td>{{$report->student->reg_no}}</td>
                                    <td>
                                        @if ( $report->status == 1)
                                            Present
                                        @else
                                            Absent
                                        @endif
                                        {{-- <input type="radio" name="attendance{{$key}}" id="present-{{$key}}" value="1" {{ $report->status == 1 ? 'checked' : ''  }}>
                                        <label for="present-{{$key}}" >Present</label>
                                        <input type="radio" name="attendance{{$key}}" id="absent-{{$key}}" value="0" {{ $report->status == 0 ? 'checked' : ''  }} >
                                        <label for="absent-{{$key}}">Absent</label> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            <div>
                @can('student_report')
                <a href="javascript:window.print()" class="btn btn-sm btn-primary" style="float:right" >Print</a>
                @endcan
            </div>
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
