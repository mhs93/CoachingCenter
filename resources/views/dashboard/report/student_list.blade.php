@extends('layouts.dashboard.app')

@section('title', 'Student List')

@push('css')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
     <style>
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
            <h5>Student List</h5>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="student_id"> Select Student Status<span class="text-danger">*</span>
                        </label>
                        <select name="student_id" id="student_id" class=" form-select form-control mt-1">
                            <option value=""> Select Status </option>
                            <option value="1"> Active  </option>
                            <option value="0"> In-Active  </option>
                        </select>

                        @error('student_id')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="form-group mt-3">
                <button title="Submit Button" type="submit" id="search" class="btn btn-sm btn-primary float-left search"> Search</button>
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
									<th> Name </th>
									<th> Regitration No. </th>
									<th> Phone </th>
									<th> Email </th>
									<th> Batch </th>
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
                var student_id = $("#student_id").val();
                var x = 1;

                if (student_id !== '') {

                var table =  $('#example').DataTable({
                    order: [],
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    processing: true,
                    serverSide: true,
                    "bDestroy": true,

                    ajax: {
                        url: "{{route('admin.all-active-inactive-students')}}",
                        type: "get",
                        data:{
                            'student_id':student_id,
                        },
                    },
                    columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'reg_no', name: 'reg_no'},
                    {data: 'contact_number', name: 'contact_number'},
                    {data: 'email', name: 'email'},
                    {data: 'batch_name', name: 'batch_name'},
                    {data: 'action', searchable: false, orderable: false},
                    ],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                        buttons: [
                                {
                                    extend: 'copy',
                                    className: 'btn-sm btn-info',
                                    title: 'Student List',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [0,1,2,3,4,5],
                                    }
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn-sm btn-success',
                                    title: 'Student List',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [0,1,2,3,4,5],
                                    }
                                },
                                {
                                    extend: 'excel',
                                    className: 'btn-sm btn-dark',
                                    title: 'Student List',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [0,1,2,3,4,5],
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    className: 'btn-sm btn-primary',
                                    title: 'Student List',
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
                                    title: 'Student List',
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
                        text: "Select Status",
                        dangerMode: true,
                    });
                }
            });
        </script>
    @endpush
@endsection
