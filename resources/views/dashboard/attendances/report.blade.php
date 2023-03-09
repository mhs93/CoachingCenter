@extends('layouts.dashboard.app')

@section('title', 'Attendance Report')

@push('css')
    {{--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}

    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
@endpush

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.attendances.index') }}">Attendance List</a>
            </li>
        </ol>
        <a href="{{ route('admin.attendances.index') }}" class="btn btn-sm btn-dark">Back</a>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <p class="m-0">Attendance Report</p>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ route('admin.attendance.report.list') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="month"><b>Month and Year<span class="text-danger">*</span></b> </label>
                            <input type="month" class="form-control" name="month" required>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="batch"><b>Batch<span class="text-danger">*</span></b> </label>
                            <select class="form-control" name="batch_id" id="batchId" required>
                                <option>select batch</option>
                                @foreach($batches as $batch)
                                    <option value="{{$batch->id}}">{{$batch->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="batch"><b>Student </b> </label>
                            <select class="form-control select2" name="student_id" id="studentId"></select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-info" style="margin-top: 24px">
                                Attendance Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div style="text-align: center" id="no-found">
        <h4>No student in this batch</h4>
    </div>
@endsection

@push('js')
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('jquery/jQuery.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#studentId .select2').select2({
                tags: true,
                placeholder: "Select an Option",
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    <script>
        $(() => {
            toastr.options.timeOut = 10000;
            @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
            @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
            @endif
        });

        $('#no-found').hide();
        $(document).ready(function () {
            $('#batchId').on('change', function () {

                $(':input[type="submit"]').prop('disabled', false);
                $('#no-found').hide();

                let batchId = this.value;
                $("#studentId").html('');
                $.ajax({
                    url: "{{route('admin.get-student-by-batch')}}",
                    type: "POST",
                    data: {
                        batch_id: batchId,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);

                        if(result.length > 0){
                            $('#studentId').html('<option value="">Select Student</option>');
                            $.each(result, function (key, value) {
                                $("#studentId").append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        }else {
                            // alert('No Student Found');
                            $(':input[type="submit"]').prop('disabled', true);
                            $('#no-found').show();
                        }
                    }
                });
            })
        })
    </script>

@endpush
