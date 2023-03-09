@extends('layouts.dashboard.app')

@section('title', 'Teacher Attendance Report')

@push('css')
    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.tattendances.index') }}">Attendance List</a>
            </li>
        </ol>
        <a href="{{ route('admin.tattendances.index') }}" class="btn btn-sm btn-dark">Back</a>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <p class="m-0">Teacher Attendance Report</p>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ route('admin.teachers.attendance.report.list') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="month"><b>Month and Year <span class="text-danger">*</span></b> </label>
                            <input type="month" class="form-control" id="month" name="month" required>
                        </div>

                        <div class="col-md-5 form-group">
                            <label for="teacher_id"><b>Select Teacher</b></label>

                            {{-- <select name="teacher_id" id="teacher_id" class="multi-teacher mySelect2 form-control @error('teacher_id') is-invalid @enderror">
                            </select> --}}

                            <select name="teacher_id" id="teacher_id" class="form-control @error('teacher_id') is-invalid @enderror">
                            </select>
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
        <h4>There is no teacher attendance for this month. <br>Please select other month.</h4>
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

    {{-- Select2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.multi-teacher').select2();
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
            $('#month').on('change', function () {
                $('#no-found').hide();
                let month = this.value;
                $("#teacher_id").html('');
                $.ajax({
                    url: "{{route('admin.get-teacher-by-month')}}",
                    type: "POST",
                    data: {
                        month: month,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if(result.length > 0){
                            $('#teacher_id').html('<option value="">--Select Teacher--</option>');
                            $.each(result, function (key, value) {
                                $("#teacher_id").append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        }else {
                            // alert('No Teacher Found')
                            $(':input[type="submit"]').prop('disabled', true);
                            $('#no-found').show();
                        }
                    }
                });
            })
        })
    </script>

@endpush
