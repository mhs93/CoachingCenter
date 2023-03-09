@extends('layouts.dashboard.app')
@section('title', 'Teacher Attendance Report')

<style>

</style>

@section('content')
    @include('layouts.dashboard.partials.alert')

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <p class="m-0">Teacher Attendance Report</p>
                <a href="{{ route('admin.teachers.attendances.report') }}" class="btn btn-sm btn-info">Back</a>
            </div>
            <div class="card-body">
                <table id="table" class="table table-bordered data-table" style="width: 100%">
                    <thead style="text-align: center">
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Teacher Name</th>
                            <th scope="col">Registration no.</th>
                            <th scope="col">Attendance</th>
                        </tr>
                    </thead>

                    <tbody style="text-align: center">
                        @foreach($reports as $key => $report)
                            <tr>
                                <td>{{ $report->date }}</td>
                                <td scope="row">{{ $report->teacher->name }}</td>
                                <td>{{ $report->teacher->reg_no }}</td>
                                <td>
                                    @if ( $report->status == 1)
                                        Present
                                    @else
                                        Absent
                                    @endif
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
