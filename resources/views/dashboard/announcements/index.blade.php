@extends('layouts.dashboard.app')

@section('title', 'Announcement List')

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
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Announcements</p>
            @can('announcement_modify')
                <a href="{{ route('admin.announcements.create') }}" class="btn btn-sm btn-info" title="Create">
                    Create Announcements
                </a>
            @endcan
        </div>
        <div class="card-body">
            <div style="text-align: center">
                <a class="btn btn-outline-dark" href="{{route('admin.announcements.print')}}" title="print">PDF</a>
            </div>

            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead style="text-align: center">
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Batch</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                </tbody>
            </table>

           {{-- Show announcement details modal --}}
            <div class="modal fade" id="modalCollapse" aria-hidden="true" >
                <div class="modal-dialog" style="max-width: 800px">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalTitle"> Announcement Details</h5>
                      <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <ul id="errors" class="mt-2"></ul>
                    <form id="getDataFrom">
                        <div class="modal-body">
                            <div class="">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>AnnouncementTitle</th>
                                            <td id="title"></td>
                                        </tr>
                                        <tr>
                                            <th>Batch List</th>
                                            <td id="batchList"></td>
                                        </tr>
                                        <tr>
                                            <th>Announcement Details</th>
                                            <td id="details"></td>
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
                    <ul id="errors" class="mt-2"></ul>
                    <form class="editsubmit" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                              <input type="hidden" name="announcement_id" id="announcementId">
                                <div class="form-group">
                                    <label for="announcementTitle"><b>Announcement Title <span style="color: red">*</span></b> </label>
                                    <input type="text" class="form-control" id="title" name="title">
                                    @error('title')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>

                               {{-- Batch Select --}}
                                {{-- @php
                                    $batchIds = json_decode($announcement->batch_id);
                                @endphp
                                <div class="form-group col-md-6">
                                    <label for="batch_id"><b>Select Batch <span style="color: red">*</span></b></label>
                                    <select name="batch_id[]" class="multi-subject form-control @error('batch_id') is-invalid @enderror"
                                        multiple="multiple" id="batch_id">
                                        <option value="0"
                                            @if (in_array("0", $batchIds))
                                                selected
                                            @endif
                                        >
                                            All Subject
                                        </option>
                                        @forelse ($batches as $batch)
                                            <option value="{{ $batch->id }}"
                                                @if(in_array($batch->id, $batchIds))
                                                    {{ "selected" }}
                                                @endif
                                            >

                                                {{ $batch->name }}
                                            </option>
                                        @empty
                                            <option>--No subject--</option>
                                        @endforelse
                                    </select>
                                    @error('batch_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}

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
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                            <button class="btn btn-sm btn-secondary" type="button" data-coreui-dismiss="modal">Close</button>
                        </div>
                    </form>
                  </div>
                </div>
            </div>

        </div>
    </div>
    <div class="mb-5"></div>

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

            // Get all data from database (Server Site)
            $(document).ready(function() {
                $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    info: true,
                    ajax: "{{ route('admin.announcements.list') }}",
                    'pageLength': 10,
                    'aLengthMenu': [[10, 25, 50, -1],[10, 25, 50, 'All']],
                    columns: [
                        {data: 'DT_RowIndex',name: 'DT_RowIndex'},
                        {data: 'title',name: 'title',orderable: true,searchable: true},
                        {data: 'batch_id',name: 'batch_id',orderable: true,searchable: true},
                        {data: 'status',name: 'status',orderable: false,searchable: false},
                        {data: 'action',name: 'action',orderable: false,searchable: false},
                    ]
                });
            });

            //Show Details
            function showDetailsModal(id) {
                $('#modalCollapse').modal('show');
                var url = '{{ route("admin.announcements.show", ":id") }}';

                $.ajax({
                    url: url.replace(':id', id ),
                    method: "GET",
                    success: function(response) {
                        console.log(response);
                        if (response.success === true) {
                            $('#title').html(response.data.announcement.title);
                            $('#batchList').html(response.data.batchSubs);
                            $('#details').html(response.data.announcement.note);
                        }
                    },
                    error: function(error) {
                        alert(error);
                    }
                });
            }

            // Edit batch
            function edit(id) {
                $('#btnSave').hide();
                $('#btnUpdate').show();
                $('#btnUpdate').html("Update");
                $('#getDataFrom').trigger("reset");
                $('#editTile').html("Edit Announcement");
                $('#modalCollapse').modal('show');
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
                                $('.editsubmit').trigger('reset');
                                $('#table').DataTable().ajax.reload();
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

            // Change status alert
            function statusConfirm(id) {
                event.preventDefault();
                swal({
                    title: `Are you sure?`,
                    text: 'You want to change announcements status ?',
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
                var url = '{{ route("admin.announcements.change-status", ":id") }}';

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
                    text: 'You want to delete this announcements ?',
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        deleteItem(id);
                    }
                });
            }

            // Delete Button
            function deleteItem(id)
            {
                var url = '{{ route("admin.announcements.destroy",":id") }}';
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
