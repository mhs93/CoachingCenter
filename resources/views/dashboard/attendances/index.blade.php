@extends('layouts.dashboard.app')

@section('title', 'Attendance')
@push('css')

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
        <div class="card-header">
            <p class="m-0">Student Attendance</p>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ route('admin.students.by.batch') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="orderDate"> Date <span class="text-danger">*</span></label>
                            <input id="date" class="form-control" placeholder="" required="required" name="date" type="date">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="batch_id"> Batch <span class="text-danger">*</span></label>
                            <select class="form-control" name="batch_id" id="batch_id" required="">
                                <option value="">select batch</option>
                                @foreach($batches as $batch)
                                    <option value="{{$batch->id}}">{{$batch->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="subject_id"> Subject <span class="text-danger">*</span></label>
                            <select class="form-control" name="subject_id" id="subject_id" required="">
                                <option value="">select subject</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button id="getStudentList" type="submit" class="btn btn-info" style="margin-top: 24px">
                                Get Student List
                            </button>
                        </div>
                    </div>
                </form>
                <div>

                </div>

            </div>

        </div>
    </div>
    @push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

         $('#batch_id').on('change',function(){
                var batch_id = $("#batch_id").val();
                var url = "{{route('admin.get-batch-wise-sub')}}";
                    $.ajax({
                        type: "get",
                        url: url,
                        data: {
                            id: batch_id
                        },
                        success: function(data){
                        $('#subject_id').empty();
                        $('#subject_id').append("<option value=''>Select from the list</option>");
                        $.each(data, function(key, value){
                            $('#subject_id').append("<option value="+value.id+">"+value.name+"</option>");
                        });
                    },
                });
            });

            $('#date').on('change',function(event){
                event.preventDefault();

                var date = $("#date").val();
                var currentDate = new Date().toISOString().slice(0, 10);

                if(date > currentDate){
                    swal({
                        title: 'Error!!!',
                        text: "Date must be less than current date",
                        dangerMode: true,
                    });
                    $('#date').val('null');
                }
            });

    </script>
    @endpush
@endsection
