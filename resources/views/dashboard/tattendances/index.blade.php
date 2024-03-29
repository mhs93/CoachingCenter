@extends('layouts.dashboard.app')

@section('title', 'Teacher Attendance')

@push('css')
    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="d-flex align-items-center justify-content-between" style="width: 100%">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>

            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Teacher Attendance</p>
            <a href="{{ route('admin.tattendances.index') }}" class="btn btn-sm btn-info">Back</a>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ route('admin.teachers.by.name') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-5 form-group">
                            <label for="orderDate"><b>Date</b> <span class="text-danger"><b>*</b></span></label>
                            <input type="date" id="date" class="form-control" placeholder="" required="required" name="date" required>
                        </div>
                        <div class="col-md-5 form-group">
                            <label for="teacher_id"><b>Select Teacher</b> <span class="text-danger"><b>*</b> </span></label>

                            <select name="teacher_id[]" id="teacher_id"
                            class="multi-teacher mySelect2 form-control @error('teacher_id') is-invalid @enderror"
                            multiple="multiple" required>

                            {{-- <select class="form-control" name="teacher_id" id="teacher_id" required=""> --}}
                                @forelse ($teahcers as $teahcer)
                                <option value="{{ $teahcer->id }}">{{ $teahcer->name }}</option>
                                @empty
                                    <option>No Teacher</option>
                                @endforelse
                            </select>
                        </div> 
                        <div class="col-md-2 form-group">
                            <button type="submit" class="btn btn-primary" style="margin-top: 24px">
                                Get Teacher
                            </button>
                        </div>
                    </div>
                </form>
                <div>

                </div>

            </div>

        </div>
    </div>
@endsection

@push('js')
<script src="{{ asset('jquery/jQuery.js') }}"></script>
<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
{{-- Select2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- sweetalert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
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
</script>

@endpush
