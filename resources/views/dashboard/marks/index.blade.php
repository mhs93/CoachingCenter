@extends('layouts.dashboard.app')

@section('title', 'Result List')

@push('css')
    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        @can('batches_create')
        <button class="btn btn-sm btn-info" id="showModal">
            <a href="{{route('admin.marks.create')}}">Create Result</a>
        </button>
        @endcan
    </nav>
@endsection

@section('content')
    @include('layouts.dashboard.partials.alert')
    <div class="card">
        <div class="show-message mt-3" align="center">
            @if(Session::has('show'))<span class="alert alert-info">{{Session::get('show')}}</span>@endif
        </div>
        <div class="card-header d-flex justify-content-between align-items-center">
            <p class="m-0">Result lists</p>
            @can('exam_modify')
                <a href="{{ route('admin.marks.create') }}" class="btn btn-sm btn-info" title="Create">Give Mark</a>
            @endcan
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered data-table" style="width: 100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Exam Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Edit Model --}}
    <div class="modal fade" id="modalCollapse" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTitle"></h5>
              <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- For validation error message show --}}
            <ul id="errors" class="mt-2"></ul>


            <form id="getDataFrom">
                <div class="modal-body">
                    <div class="form-group">

                        <table class="table table-bordered">

                            <thead>
                                <th>Name</th>
                                <th>Action</th>
                            </thead>

                            <tbody id="tbody">
                            </tbody>

                        </table>
                    </div>
                </div>
            </form>

          </div>
        </div>
    </div>

    <div class="mb-5"></div>
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

            // Get all data from database (Server Site)
            $(document).ready(function() {
                $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    info: true,
                    ajax: "{{ route('admin.marks.lists') }}",
                    'pageLength': 10,
                    'aLengthMenu': [[10, 25, 50, -1],[10, 25, 50, 'All']],
                    columns: [
                        // {data:'id',name:'id'},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'name',name: 'name',orderable: true,searchable: true},
                        // {data: 'exam.name',name: 'name',orderable: true,searchable: true},
                        {data: 'status',name: 'status',orderable: true,searchable: true},
                        {data: 'action',name: 'action',orderable: false,searchable: false},
                    ]
                });
            });

            function edit(id) {
                $("#tbody").empty();

                $('#getDataFrom').trigger("reset");
                $('#modalTitle').html("Edit Marks");
                $('#modalCollapse').modal('show');
                $('#errors').hide();


                var url = '';
                var delete_url = '';
                $.ajax({
                    url: "{{ route('admin.marks.getMarkedBatches') }}",
                    type: 'post',
                    // data: { markId: id},
                    data: { examId: id},
                    success: function(response) {
                        $.each(response, function(key, value) {
                            // var url = "{{url('marks/marked/show')}}" + "/" + id + "/" + value.batch_id;
                            var url = "mark/edit" + "/" + id + "/" + value.batch_id;
                            var delete_url = "mark/delete" + "/" + id + "/" + value.batch_id;
                            $("#tbody").append(
                                '<tr>'+
                                    '<td>'+ value.batch.name +'</td>'+
                                    '<td><a href=" '+url+ ' " '+
                                    ' class="btn btn-small btn-success">Edit</a>'+
                                    '<a href=" '+delete_url+ ' " '+
                                    ' class="btn btn-small btn-danger">Delete</a>'+
                                    '</td>'+
                                '</tr>'
                            );
                        });
                    }
                });
            }

            // Change status alert
            function statusConfirm(id) {
                event.preventDefault();
                swal({
                    title: `Are you sure?`,
                    text: 'You want to change exam status ?',
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
                var url = '{{ route("admin.marks.change-status", ":id") }}';

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
                    text: 'You want to delete this mark ?',
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
                var url = '{{ route("admin.marks.destroy",":id") }}';
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
