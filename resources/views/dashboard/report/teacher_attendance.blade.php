@extends('layouts.dashboard.app')

@section('title', 'Teachers Attendance')

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
            <h5>Teachers Attendance</h5>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacher_id"><b>Select Teacher</b> <span class="text-danger">*</span>
                        </label>
                        <select name="teacher_id" id="teacher_id" class=" form-select form-control mt-1">
                            <option value=""> --Select Teacher-- </option>
                            @foreach ($teachers as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>

                        @error('teacher_id')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="start_date"><b>Start Date</b>  <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                            class="form-control mt-1 @error('start_date') is-invalid @enderror"
                            placeholder="Enter start date" required>

                        @error('start_date')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                        @enderror

                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="end_date"><b>End Date</b>  <span class="text-danger">*</span></label>
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
									<th> Contact No </th>
									<th> Status </th>
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
        $('#start_date, #end_date').on('change',function(event){
            event.preventDefault();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();

            var currentDate = new Date().toISOString().slice(0, 10);

            if(start_date > currentDate){
                swal({
                    title: 'Error!!!',
                    text: "Start date must be less than current date",
                    dangerMode: true,
                });
                $('#start_date').val('null');
            }
            if(end_date > currentDate) {
                swal({
                    title: 'Error!!!',
                    text: "End date must be less than or equal current date",
                    dangerMode: true,
                });
                $('#end_date').val('null');
            }
        });

            $('#search').on('click',function(event){
                event.preventDefault();
                var teacher_id = $("#teacher_id").val();
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();

                if (start_date !== '' && end_date !== '' && teacher_id !== '') {

                var table =  $('#example').DataTable({
                    order: [],
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    processing: true,
                    serverSide: true,
                    "bDestroy": true,

                    ajax: {
                        url: "{{route('admin.teachers-attendance-list')}}",
                        type: "get",
                        data:{
                            'teacher_id':teacher_id,
                            'start_date':start_date,
                            'end_date':end_date,
                        },
                    },
                    columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'date', name: 'date'},
                    {data: 'teacher_name', name: 'teacher_name'},
                    {data: 'reg_no', name: 'reg_no'},
                    {data: 'contact_number', name: 'contact_number'},
                    {data: 'status', name: 'status'},
                    {data: 'action', searchable: false, orderable: false},
                    ],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                        buttons: [
                                {
                                    extend: 'copy',
                                    className: 'btn-sm btn-info',
                                    title: 'Teacher Attendance',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [0,1,2,3,4,5],
                                    }
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn-sm btn-success',
                                    title: 'Teacher Attendance',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [0,1,2,3,4,5],
                                    }
                                },
                                {
                                    extend: 'excel',
                                    className: 'btn-sm btn-dark',
                                    title: 'Teacher Attendance',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [0,1,2,3,4,5],
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    className: 'btn-sm btn-primary',
                                    title: 'Teacher Attendance',
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
                                    title: 'Teacher Attendance',
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
