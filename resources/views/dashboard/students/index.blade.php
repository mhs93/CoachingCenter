@extends('layouts.dashboard.app')

@section('title', 'Student List')

@push('css')
    <style>
        table {
            width: 100%;
        }
        .paging_simple_numbers,
        .dataTables_filter {
            float: right;
        }
    </style>
@endpush

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Student lists</p>
            @can('student_modify')
                <a href="{{ route('admin.students.create') }}" title="create" class="btn btn-sm btn-info">Create Student</a>
            @endcan
        </div>
        <div class="card-body">
            <form action="{{ route('admin.import-students') }}" method="post" enctype="multipart/form-data" style="text-align: center">
                @csrf
                <a class="btn btn-outline-dark" href="{{route('admin.students.print')}}" title="print">PDF</a>
                <a class="btn btn-outline-dark" href="{{ route('admin.export-students') }}">Export</a>
                <input class="btn btn-outline-dark" type="file" name="file" required>
                <input class="btn btn-outline-dark" type="submit" value="import">
            </form> 

            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead style="text-align: center">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Registration no.</th>
                        <th scope="col">Email</th>
                        <th scope="col">Batch</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>

                <tbody style="text-align: center">
                </tbody>
            </table>

            {{-- Show Modal --}}
            <div class="modal fade" id="showModel" aria-hidden="true" >
                <div class="modal-dialog" style="max-width: 800px">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalTitle"></h5>
                      <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <ul id="errors" class="mt-2"></ul>
                    <form id="getDataFrom">
                        <div class="modal-body">
                            <div class="">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Student name</th>
                                            <td id="name"></td>
                                        </tr>
                                        <tr>
                                            <th>Registration Number</th>
                                            <td id="reg_no"></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td id="email"></td>
                                        </tr>

                                        <tr>
                                            <th>Gender</th>
                                            <td id="gender"></td>
                                        </tr>
                                        <tr>
                                            <th>Current Address</th>
                                            <td id="current_address"></td>
                                        </tr>
                                        <tr>
                                            <th>Permanent Address</th>
                                            <td id="permanent_address"></td>
                                        </tr>
                                        <tr>
                                            <th>Contact Number</th>
                                            <td id="contact_number"></td>
                                        </tr>
                                        <tr>
                                            <th>Parent Information</th>
                                            <td id="parent_information"></td>
                                        </tr>
                                        <tr>
                                            <th>Parent Contact</th>
                                            <td id="parent_contact"></td>
                                        </tr>
                                        <tr>
                                            <th>Guardian Information</th>
                                            <td id="guardian_information"></td>
                                        </tr>
                                        <tr>
                                            <th>Guardian Contact</th>
                                            <td id="guardian_contact"></td>
                                        </tr>
                                        <tr>
                                            <th>Monthly Fee</th>
                                            <td id="monthly_fee"></td>
                                        </tr>
                                        <tr>
                                            <th>Batch Name</th>
                                            <td id="batch_id"></td>
                                        </tr>
                                        <tr>
                                            <th class="initialFee">Initial Fee</th>
                                            <td id="initialFee"></td>
                                        </tr>
                                        <tr>
                                            <th class="adjustmentType">Adjustment Type</th>
                                            <td id="adjustmentType"></td>
                                        </tr>
                                        <tr>
                                            <th class="adjustmentBalance">Adjustment Balance</th>
                                            <td id="adjustmentBalance"></td>
                                        </tr>
                                        <tr>
                                            <th>Total Fee</th>
                                            <td id="totalFee"></td>
                                        </tr>
                                        <tr>
                                            <th>Student Details</th>
                                            <td id="studentDetails"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-secondary" type="button" data-coreui-dismiss="modal">Close</button>
                        </div>
                    </form>
                  </div>
                </div>
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
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            info:true,
            ajax:"{{ route('admin.students.list') }}",
            'pageLength': 10,
            'aLengthMenu': [[10,25,50,-1],[10,25,50,'All']],
            columns: [
                // {data:'id',name:'id'},
                {data:'DT_RowIndex',name:'DT_RowIndex'},
                {data: 'name', name: 'name',orderable: true, searchable: true},
                {data: 'reg_no', name: 'reg_no',orderable: true, searchable: true},
                {data: 'email', name: 'email',orderable: true, searchable: true},
                {data: 'batch.name', name: 'batch',orderable: true, searchable: true},
                {data: 'status',name: 'status',orderable: false,searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });


        $('.initialFee').hide();
        $('.adjustmentType').hide();
        $('.adjustmentBalance').hide();
        $('#initialFee').hide();
        $('#adjustmentType').hide();
        $('#adjustmentBalance').hide();
        // show
        function show(id) {
            $('#getDataFrom').trigger("reset");
            $('#modalTitle').html("Batch Details");
            $('#showModel').modal('show');

            var url = '{{ route("admin.batches.show", ":id") }}';
            $.ajax({
                url: url.replace(':id', id ),
                type: 'get',
                success: function(response) {
                    console.log(response.data.batch.name);
                    if (response.success === true) {
                        $('#subjectName').html(response.data.batch.name);
                        $('#subjectList').html(response.data.batchSubs);
                        $('#startDate').html(response.data.batch.start_date);

                        $('#endDate').html(response.data.batch.end_date);

                        if(response.data.balance){
                            $('.initialFee').show();
                            $('.adjustmentType').show();
                            $('.adjustmentBalance').show();
                            $('#initialFee').show();
                            $('#adjustmentType').show();
                            $('#adjustmentBalance').show();
                            $('#initialFee').html(response.data.batch.initial_amount);
                            $('#adjustmentType').html(response.data.batch.adjustment_balance);
                            if(response.data.batch.adjustment_type == 1){
                                $('#adjustmentBalance').html('Addition');
                            }else{
                                $('#adjustmentBalance').html('Subtraction');
                            }
                        }
                        $('#totalFee').html(response.data.batch.total_amount);
                        if(response.note){
                            $('#studentDetails').html(response.data.batch.note);
                        }else{
                            $('#studentDetails').html('--');
                        }
                    }

                }
            });
        }

        // Change status alert
        function statusConfirm(id) {
            event.preventDefault();
            swal({
                title: `Are you sure?`,
                text: 'You want to change student status ?',
                buttons: true,
                dangerMode: true,
            }).then((willChangeStatus) => {
                if (willChangeStatus) {
                    changeStatus(id);
                }
            });
        }

        // Change status
        function changeStatus(id) {
            var url = '{{ route("admin.students.change-status", ":id") }}';
            $.ajax({
                url: url.replace(':id', id ),
                method: "PUT",
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(response) {
                    if (response.success === true) {
                        $('.data-table').DataTable().ajax.reload();
                        toastr.success(response.message);
                    }
                },
                error: function(error) {
                    alert(error);
                }
            });
        }

        // delete Confirm
        function showDeleteConfirm(id)
        {
            event.preventDefault();
            swal({
                title: `Are you sure?`,
                text: 'You want to delete this student ?',
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    deleteItem(id);
                }
            });
        }

        // Delete Button
        function deleteItem(id){
            var url = '{{ route("admin.students.destroy",":id") }}';
            $.ajax({
                type: "DELETE",
                url: url.replace(':id', id ),
                success: function (resp) {
                    // Reloade DataTable
                    $('.data-table').DataTable().ajax.reload();
                    if (resp.success === true) {
                        // show toast message
                        toastr.success(resp.message);
                    }
                }, // success end
                error: function (error) {
                    location.reload();
                }
            })
        }

    </script>
@endpush
