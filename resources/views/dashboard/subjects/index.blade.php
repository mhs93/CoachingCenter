@extends('layouts.dashboard.app')

@section('title', 'Subject List')

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
            <p class="m-0">Subjects</p>
            @can('subject_modify')
                <a class="btn btn-sm btn-info" href="{{route('admin.subjects.create')}}" title="Create">Create subject</a>
            @endcan
        </div>
        <div class="card-body">
            <form action="{{ route('admin.import-subjects') }}" method="post" enctype="multipart/form-data" style="text-align: center">
                @csrf
                <a class="btn btn-outline-dark" href="{{route('admin.subjects.print')}}" title="print">PDF</a>
                <a class="btn btn-outline-dark" href="{{ route('admin.export-subjects') }}">Export</a>
                <input class="btn btn-outline-dark" type="file" name="file" required>
                <input class="btn btn-outline-dark" type="submit" value="import">
            </form>

            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead style="text-align: center">
                    <tr>
                        <th>Id</th>
                        <th>Subject Name</th>
                        <th>Subject Code</th>
                        <th>Subject Fee</th>
                        <th>Status</th>
                        <th>Action</th>
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
                                            <th>Subject name</th>
                                            <td id="subjectName"></td>
                                        </tr>
                                        <tr>
                                            <th>Subject Code</th>
                                            <td id="subjectCode"></td>
                                        </tr>
                                        <tr>
                                            <th>Subject Fee</th>
                                            <td id="subjectFee"></td>
                                        </tr>
                                        <tr>
                                            <th>Subject Details</th>
                                            <td id="subjectDetails"></td>
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

            {{-- Edit Modal --}}
            <div class="modal fade" id="modalCollapse" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editTile"></h5>
                      <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <ul id="errors" class=""></ul>
                    <form class="editsubmit" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                              <input type="hidden" name="subject_id" id="subjectId">
                                <div class="form-group">
                                    <label for="subjectName"><b>Subject Name <span style="color: red">*</span></b> </label>
                                    <input type="text" class="form-control" id="name" name="name">
                                    @error('name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>

                               <div class="form-group">
                                    <label for="code"><b>Subject code <span style="color: red">*</span></b></label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code">
                                    @error('code')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>

                                 <div class="form-group">
                                    <label for="fee"><b>Fee<span style="color: red">*</span></b></label>
                                    <input type="number" class="form-control @error('fee') is-invalid @enderror" name="fee" id="fee">
                                    @error('fee')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="note"><b>Note</b></label>
                                    <textarea class="form-control @error('note') is-invalid @enderror" name="note" id="note"></textarea>
                                    @error('note')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            <button class="btn btn-sm btn-secondary" type="button" data-coreui-dismiss="modal">Close</button>
                        </div>
                    </form>
                  </div>
                </div>
            </div>

        </div>
    </div>

    @push('js')
        <script src="{{ asset('jquery/jQuery.js') }}"></script>
        <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>

        <!-- sweetalert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Get all data from database (Server Site).
            $(document).ready(function() {
                $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    info: true,
                    ajax: "{{ route('admin.subjects.list') }}",
                    'pageLength': 10,
                    'aLengthMenu': [[10, 25, 50, -1],[10, 25, 50, 'All']],
                    columns: [
                        // {data:'id',name:'id'},
                        {data: 'DT_RowIndex',name: 'DT_RowIndex'},
                        {data: 'name',name: 'name',orderable: true,searchable: true},
                        {data: 'code',name: 'code',orderable: true,searchable: true},
                        {data: 'fee',name: 'fee',orderable: true,searchable: true},
                        {data: 'status',name: 'status',orderable: false,searchable: false},
                        {data: 'action',name: 'action',orderable: false,searchable: false},
                    ]
                });
            });

            // show
            function show(id) {
                $('#getDataFrom').trigger("reset");
                $('#modalTitle').html("Subject Details");
                $('#showModel').modal('show');

                var url = '{{ route("admin.subjects.show", ":id") }}';
                $.ajax({
                    url: url.replace(':id', id ),
                    type: 'get',
                    success: function(response) {
                        if (response.success === true) {
                            $('#subjectName').html(response.data.name);
                            $('#subjectCode').html(response.data.code);
                            $('#subjectFee').html(response.data.fee);
                            if(response.data.note){
                                $('#subjectDetails').html(response.data.note);
                            }else{
                                $('#subjectDetails').html('---');
                            }
                        }
                        console.log(response);
                    }
                });
            }

            // Edit Subject
            function edit(id) {
                $('#btnSave').hide();
                $('#btnUpdate').show();
                $('#btnUpdate').html("Update");
                $('#getDataFrom').trigger("reset");
                $('#editTile').html("Edit Subject");
                // $('#modalCollapse').modal('show');
                $('#subjectId').val(id);
                $('#errors').hide();
                var url = '{{ route("admin.subjects.edit", ":id") }}'
                $.ajax({
                    url: url.replace(':id', id ),
                    method: "GET",
                    success: function(response) {
                        console.log(response);
                        if (response.success === true) {
                            $('#name').val(response.data.name);
                            $('#code').val(response.data.code);
                            $('#fee').val(response.data.fee);
                            if(response.data.note){
                                $('#note').val(response.data.note);
                            }else{
                                $('#subjectDetails').val('---');
                            }
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }


            $(document).ready(function ($) {
                $(".editsubmit").submit(function (event) {
                    event.preventDefault();
                    var url  =  '{{ route('admin.subjects.update',':id') }}';
                    var id   =  $('#subjectId').val();
                    var name =  $('#name').val();
                    var code =  $('#code').val();
                    var fee  =  $('#fee').val();
                    var note =  $('#note').val();

                    $.ajax({
                        url: url.replace(':id', id),
                        type: "PUT",
                        data: { name:name, code:code, fee:fee, note:note, id:id },
                        success: function (resp) {
                            if (resp.success === true) {

                                // $('#table').DataTable().ajax.reload();
                                $('.data-table').DataTable().ajax.reload();
                                $('.editsubmit').trigger('reset');
                                toastr.success(resp.message);
                            } else if (resp.errors) {
                                toastr.error(resp.errors[0]);
                            } else {
                                toastr.error(resp.message);
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                    $.noConflict();
                    $('#modalCollapse').modal('hide');
                });
            });


            function statusConfirm(id) {
                event.preventDefault();
                swal({
                    title: `Are you sure?`,
                    text: 'You want to change subject status ?',
                    buttons: true,
                    dangerMode: true,
                }).then((willChangeStatus) => {
                    if (willChangeStatus) {
                        changeStatus(id);
                    }
                });
            }

            function changeStatus(id) {
                var url = '{{ route("admin.subjects.change-status", ":id") }}';

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

            function showDeleteConfirm(id)
            {
                event.preventDefault();
                swal({
                    title: `Are you sure?`,
                    text: 'You want to delete this announcements ?',
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        deleteItem(id);
                    }
                });
            }

            function deleteItem(id)
            {
                var url = '{{ route("admin.subjects.destroy",":id") }}';
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
                        alert(error);
                    }
                })
            }

        </script>
    @endpush
@endsection
