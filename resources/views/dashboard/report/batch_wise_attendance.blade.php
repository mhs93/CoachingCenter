@extends('layouts.dashboard.app')

@section('title', 'Batch Wise Attendance')

@push('css')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    <style>
        table {
            width: 100%;
        }
        .paging_simple_numbers,
        .dataTables_filter {
            float: right;
        }
        .swal-title:not(:last-child) {
            margin-bottom: 1px;
            padding: 1px;
        }
        .swal-title:first-child {
            margin-top: 10px;
        }
        .swal-title{
            font-size: 17px;
            color: red;
            padding: 0;
        }
        .swal-text:first-child {
         margin-top: 8px;
         color:#000000;
         max-width: 100% ;
         font-size: 13px;
    }
    .swal-text{
        margin-top: 5px !important;
        color: black;
        background-color: white;
        box-shadow: none;
    }
    .swal-modal{
        max-width: 299px ;
            /* width: auto !important; */
            padding-top: 1px;
            margin-top: 1px;
            padding: 1px 1px;
            vertical-align: top;
        }
        .swal-footer {
            height: auto !important;
            margin-top: 0px;
            text-align: right;
            padding: 1px 1px !important;
        }
        .swal-button{
            height: 25px !important;
            width: 30px !important;
            padding: 1px 5px;
        }
    </style>
@endpush

@section('content')
    @include('layouts.dashboard.partials.alert')

    <div class="card">
        <div class="card-body">
            <h5>Batch Wise Attendance</h5>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="batch_id"> Select Student<span class="text-danger">*</span>
                        </label>
                        <select name="batch_id" id="batch_id" class=" form-select form-control mt-1">
                            <option value=""> Select Student </option>
                            @foreach ($batches as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach

                        </select>

                        @error('batch_id')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="status"> Select Status<span class="text-danger">*</span>
                        </label>
                        <select name="status" id="status" class=" form-select form-control mt-1">
                            <option value=""> Select Status </option>
                            <option value="1">Present</option>
                            <option value="0">Absence</option>
                        </select>

                        @error('status')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="start_date"> Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                            class="form-control mt-1 @error('start_date') is-invalid @enderror"
                            placeholder="Enter start date" required>

                        @error('stattement_date')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                        @enderror

                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="end_date"> End Date <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                            class="form-control mt-1 @error('end_date') is-invalid @enderror"
                            placeholder="Enter end date" required>

                        @error('end_date')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                        @enderror

                    </div>
                </div>

            </div>
            <div class="form-group mt-3">
                <button title="Submit Button" type="submit" id="search" class="btn btn-sm btn-primary float-left search"> <i class="bx bxs-eye"></i>Search</button>
            </div>

        </div>
    </div>

	<!-- Main Content -->
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<table id="example" class="table table-hover table-bordered ">
							<thead>
								<tr>
									<th> SN </th>
									<th> Date </th>
									<th> Name </th>
									<th> Regitration No. </th>
									<th> Contact  </th>
									<th> Email </th>
									<th> Action </th>
								</tr>
							</thead>

							<tbody>

							</tbody>

						</table>
					</div>
				</div>
			</div>
		</div>

    @push('js')
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

            $('#search').on('click',function(event){
                event.preventDefault();
                var batch_id = $("#batch_id").val();
                var status = $("#status").val();
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();

                if (start_date !== '' && end_date !== '' && batch_id !== '' && status !== '') {

                var table =  $('#example').DataTable({
                    order: [],
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    processing: true,
                    serverSide: true,
                    "bDestroy": true,

                    ajax: {
                        url: "{{route('admin.batch-wise-attendance-list')}}",
                        type: "get",
                        data:{
                            'batch_id':batch_id,
                            'start_date':start_date,
                            'end_date':end_date,
                            'status':status,
                        },
                    },
                    columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'date', name: 'date'},
                    {data: 'student_name', name: 'student_name'},
                    {data: 'reg_no', name: 'reg_no'},
                    {data: 'contact_number', name: 'contact_number'},
                    {data: 'email_address', name: 'email_address'},
                    {data: 'action', searchable: false, orderable: false},
                    ],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                        buttons: [
                                {
                                    extend: 'copy',
                                    className: 'btn-sm btn-info',
                                    title: 'Student Attendance',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [0,1,2,3,4,5],
                                    }
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn-sm btn-success',
                                    title: 'Student Attendance',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [0,1,2,3,4,5],
                                    }
                                },
                                {
                                    extend: 'excel',
                                    className: 'btn-sm btn-dark',
                                    title: 'Student Attendance',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [0,1,2,3,4,5],
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    className: 'btn-sm btn-primary',
                                    title: 'Student Attendance',
                                    pageSize: 'A2',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [0,1,2,3,4,5],
                                    }
                                },
                                {
                                    extend: 'print',
                                    className: 'btn-sm btn-danger',
                                    title: 'Student Attendance',
                                    // orientation:'landscape',
                                    pageSize: 'A2',
                                    header: true,
                                    footer: false,
                                    orientation: 'landscape',
                                    exportOptions: {
                                        columns: [0,1,2,3,4,5],
                                        stripHtml: false
                                    }
                                }
                            ],
                })
            } else {
                   swal({
                        title: 'Error!!!',
                        text: "Enter All Values",
                        dangerMode: true,
                    });
                }
            });
        </script>
    @endpush
@endsection
