@extends('layouts.dashboard.app')

@section('title', 'Students Mark')

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
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Students Mark</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="exam_id"> Select Exam <span class="text-danger">*</span>
                        </label>
                        <select name="exam_id" id="exam_id" class=" form-select form-control mt-1">
                            <option value=""> Select Exam </option>
                            @foreach ($exams as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>

                        @error('exam_id')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="batch_id"> Select Batch <span class="text-danger">*</span>
                        </label>
                        <select name="batch_id" id="batch_id" class=" form-select form-control mt-1">
                        </select>

                        @error('batch_id')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="student_id"> Select Student <span class="text-danger">*</span>
                        </label>
                        <select name="student_id" id="student_id" class=" form-select form-control mt-1">
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
									<th> Regi No. </th>
									<th> Contact  </th>
									<th> Subject/Mark </th>
									<th> Total Mark </th>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //get batch by exam
            $('#exam_id').on('change',function(){
            var exam_id = $("#exam_id").val();
            var url = "{{route('admin.marks.getBatches')}}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        examId: exam_id
                    },
                    success: function(data){
                    $('#batch_id').empty();
                    $('#batch_id').append("<option value=''>Select Batch</option>");
                    $.each(data, function(key, value){
                        $('#batch_id').append("<option value="+value.batch.id+">"+value.batch.name+"</option>");
                    });
                },
            });
            });

            //get student by batch
            $('#batch_id').on('change',function(){
            var batch_id = $("#batch_id").val();
            var url = "{{route('admin.get-batch-wise-student')}}";
                $.ajax({
                    type: "get",
                    url: url,
                    data: {
                        batch_id: batch_id
                    },
                    success: function(data){
                    $('#student_id').empty();
                    $('#student_id').append("<option value=''> Select Student </option>");
                    $.each(data, function(key, value){
                        $('#student_id').append("<option value="+value.id+">"+value.name+"</option>");
                    });
                },
            });
            });

            $('#search').on('click',function(event){
                event.preventDefault();
                var batch_id = $("#batch_id").val();
                var student_id = $("#student_id").val();
                var exam_id = $("#exam_id").val();

                if (exam_id !== '' && student_id !== '' && batch_id !== '') {

                var table =  $('#example').DataTable({
                    order: [],
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    processing: true,
                    serverSide: true,
                    "bDestroy": true,

                    ajax: {
                        url: "{{route('admin.students-mark-list')}}",
                        type: "get",
                        data:{
                            'student_id':student_id,
                            'batch_id':batch_id,
                            'exam_id':exam_id,
                        },
                    },
                    columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'dateFormat', name: 'dateFormat'},
                    {data: 'reg_no', name: 'reg_no'},
                    {data: 'contact_number', name: 'contact_number'},
                    {data: 'subjects_mark', name: 'subjects_mark'},
                    {data: 'total', name: 'total'},
                    ],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                        buttons: [
                                {
                                    extend: 'copy',
                                    className: 'btn-sm btn-info',
                                    title: 'Student Mark',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [1,2,3,4,5],
                                    }
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn-sm btn-success',
                                    title: 'Student Mark',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [0,1,2,3,4,5,6],
                                    }
                                },
                                {
                                    extend: 'excel',
                                    className: 'btn-sm btn-dark',
                                    title: 'Student Mark',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [1,2,3,4,5],
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    className: 'btn-sm btn-primary',
                                    title: 'Student Mark',
                                    pageSize: 'A2',
                                    header: true,
                                    footer: true,
                                    exportOptions: {
                                        columns: [1,2,3,4,5],
                                    }
                                },
                                {
                                    extend: 'print',
                                    className: 'btn-sm btn-danger',
                                    title: 'Student Mark',
                                    // orientation:'landscape',
                                    pageSize: 'A2',
                                    header: true,
                                    footer: false,
                                    orientation: 'landscape',
                                    exportOptions: {
                                        columns: [1,2,3,4,5],
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
